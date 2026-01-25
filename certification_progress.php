<?php
// halalv2/certification_progress.php
session_start();
include 'includes/db.php';

// Auth Check
if (!isset($_SESSION['user_id']) && !isset($_SESSION['owner'])) {
    header("Location: login_owner.php");
    exit();
}

$ownerEmail = $_SESSION['owner']['email'] ?? null;
$application = null;
$status = 'Not Found';

// 1. Fetch Application by Email (Strict ownership)
if ($ownerEmail) {
    // Get the specific ID if passed, otherwise get latest
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM halal_certification_applications WHERE id = ? AND email = ?");
        $stmt->bind_param("is", $_GET['id'], $ownerEmail);
    } else {
        $stmt = $conn->prepare("SELECT * FROM halal_certification_applications WHERE email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("s", $ownerEmail);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
}

// REMOVED: The insecure "fallback to random latest application" block

// Flowchart Logic
$stages = [
    'Application', 'Technical Review', 'Audit Inspection', 
    'Laboratory Analysis', 'Fatwa Recommendations', 'Compliance', 'Monitoring'
];

$statusMap = [
    'Pending' => 'Application',
    'Under Review' => 'Technical Review',
    'Inspection Scheduled' => 'Audit Inspection',
    'Approved' => 'Compliance',
    'Rejected' => 'Non-Compliance'
];

$status = $application['status'] ?? 'None';
$currentStage = $statusMap[$status] ?? 'Application';
$currentIdx = array_search($currentStage, $stages);
if ($currentIdx === false) $currentIdx = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certification Progress - Halal Keeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .step { padding: 10px; border: 1px solid #ddd; border-radius: 8px; text-align: center; margin-bottom: 10px; opacity: 0.5; }
        .step.completed { background-color: #d1e7dd; opacity: 1; border-color: #badbcc; }
        .step.current { border: 2px solid #0d8c4c; opacity: 1; font-weight: bold; }
        .flow-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; }
    </style>
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 900px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold text-center mb-4">Certification Tracker</h3>

                <?php if (!$application): ?>
                    <div class="alert alert-info text-center">
                        <p class="mb-3">You have not submitted a Halal Certification application yet.</p>
                        <a href="halal_certification_application.php" class="btn btn-success">Apply Now</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light border mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Company:</strong> <?= htmlspecialchars($application['company_name']) ?><br>
                                <strong>App ID:</strong> #<?= $application['id'] ?>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <strong>Current Status:</strong> 
                                <span class="badge bg-success"><?= htmlspecialchars($status) ?></span>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Progress Flow</h5>
                    <div class="flow-grid">
                        <?php foreach ($stages as $index => $label): 
                            $class = '';
                            if ($index < $currentIdx) $class = 'completed';
                            elseif ($index === $currentIdx) $class = 'current';
                        ?>
                            <div class="step <?= $class ?>">
                                <small class="d-block text-muted">Step <?= $index + 1 ?></small>
                                <?= $label ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-4 text-center">
                    <a href="owner_dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>