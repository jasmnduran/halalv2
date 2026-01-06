<?php
session_start();
require_once "includes/db.php";

// 1. Security Check
if (!isset($_SESSION["certifier_id"])) {
    header("Location: login_certifier.html");
    exit();
}

$app_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. Fetch Application Data
$stmt = $conn->prepare("SELECT * FROM halal_certification_applications WHERE id = ?");
$stmt->bind_param("i", $app_id);
$stmt->execute();
$app = $stmt->get_result()->fetch_assoc();

if (!$app) die("Application not found.");

// 3. Fetch Documents
$docStmt = $conn->prepare("SELECT * FROM application_documents WHERE application_id = ?");
$docStmt->bind_param("i", $app_id);
$docStmt->execute();
$documents = $docStmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Review - App #<?= $app_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; font-family: 'Inter', sans-serif; }
        .sidebar-sticky { position: sticky; top: 20px; }
        .doc-card { border-left: 4px solid transparent; transition: all 0.2s; }
        .doc-card.compliant { border-left-color: #198754; background-color: #f8fff9; }
        .doc-card.non-compliant { border-left-color: #dc3545; background-color: #fff8f8; }
    </style>
</head>
<body class="py-4">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="halal_certifying_body.php" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
                <h4 class="fw-bold mb-0">Review Application #<?= $app_id ?></h4>
                <span class="text-muted"><?= htmlspecialchars($app['company_name']) ?></span>
            </div>
            <div>
                <span class="badge bg-<?= $app['status'] == 'Approved' ? 'success' : 'warning' ?> fs-6 px-3 py-2">
                    <?= htmlspecialchars($app['status']) ?>
                </span>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sidebar-sticky">
                    <div class="card-header bg-success text-white py-3 rounded-top-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2"></i>Company Profile</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Applicant</label>
                            <div class="fw-medium"><?= htmlspecialchars($app['applicant_name']) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Contact</label>
                            <div><?= htmlspecialchars($app['contact_person']) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($app['email']) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($app['telephone']) ?></div>
                        </div>
                        <div class="mb-4">
                            <label class="small text-muted fw-bold text-uppercase">Address</label>
                            <div class="small"><?= htmlspecialchars($app['business_address']) ?></div>
                        </div>
                        
                        <hr class="opacity-25">
                        
                        <form id="decisionForm">
                            <input type="hidden" name="app_id" value="<?= $app_id ?>">
                            <label class="form-label fw-bold">Final Decision</label>
                            <select name="final_status" class="form-select mb-3" required>
                                <option value="Pending" <?= $app['status']=='Pending'?'selected':'' ?>>Pending Review</option>
                                <option value="Approved" <?= $app['status']=='Approved'?'selected':'' ?>>Approve Certification</option>
                                <option value="Rejected" <?= $app['status']=='Rejected'?'selected':'' ?>>Reject Application</option>
                            </select>
                            
                            <label class="form-label fw-bold">Auditor Remarks</label>
                            <textarea name="remarks" class="form-control mb-3" rows="3" placeholder="Enter notes..."></textarea>
                            
                            <button type="submit" class="btn btn-success w-100 fw-bold">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <h5 class="fw-bold mb-3">Document Verification</h5>
                
                <div class="d-flex flex-column gap-3" id="docList">
                    <?php foreach ($documents as $doc): ?>
                    <div class="card border-0 shadow-sm doc-card <?= $doc['status'] == 'compliant' ? 'compliant' : ($doc['status'] == 'non_compliant' ? 'non-compliant' : '') ?>" id="card-<?= $doc['id'] ?>">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light p-3 rounded">
                                    <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($doc['document_type']) ?></h6>
                                    <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="small text-decoration-none">
                                        View File <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-success <?= $doc['status'] == 'compliant' ? 'active' : '' ?>" 
                                        onclick="updateDocStatus(<?= $doc['id'] ?>, 'compliant')">
                                    <i class="bi bi-check-lg"></i> Valid
                                </button>
                                <button class="btn btn-sm btn-outline-danger <?= $doc['status'] == 'non_compliant' ? 'active' : '' ?>" 
                                        onclick="updateDocStatus(<?= $doc['id'] ?>, 'non_compliant')">
                                    <i class="bi bi-x-lg"></i> Invalid
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

    <script>
        async function updateDocStatus(docId, status) {
            try {
                const formData = new FormData();
                formData.append('doc_id', docId);
                formData.append('status', status);

                const res = await fetch('actions/update_doc_status.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await res.json();
                
                if (data.success) {
                    // Update UI Class
                    const card = document.getElementById(`card-${docId}`);
                    card.className = `card border-0 shadow-sm doc-card ${status == 'compliant' ? 'compliant' : 'non-compliant'}`;
                    
                    // Update Buttons
                    const btns = card.querySelectorAll('button');
                    btns.forEach(b => b.classList.remove('active'));
                    if (status === 'compliant') btns[0].classList.add('active');
                    else btns[1].classList.add('active');
                } else {
                    alert('Error updating status');
                }
            } catch (e) { console.error(e); }
        }

        document.getElementById('decisionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!confirm('Submit final decision?')) return;

            const formData = new FormData(e.target);
            const res = await fetch('actions/save_inspection.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            if (data.success) {
                alert('Review saved successfully!');
                window.location.href = 'halal_certifying_body.php';
            } else {
                alert('Error: ' + data.message);
            }
        });
    </script>
</body>
</html>