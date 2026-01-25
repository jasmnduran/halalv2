<?php
session_start();
// FIXED: Strict check for AUDITOR ID. 
// If you are a Certifier, you cannot access this page (Separation of Duties).
if (!isset($_SESSION['auditor_id'])) {
    // Assuming you have a login page named login_auditor.html or similar
    header("Location: login_auditor.html"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Team Verification - HDIP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #0d8c4c;
            --bs-body-bg: #f5f7fa;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }
        body { background-color: var(--bs-body-bg); display: flex; flex-direction: column; min-height: 100vh; }
        .bg-brand { background: linear-gradient(135deg, var(--primary-green), #0a6d3a); }
        .text-brand { color: var(--primary-green) !important; }
        
        .stat-card {
            border: none; border-left: 5px solid var(--primary-green);
            background: white; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .view-section { display: none; animation: fadeIn 0.3s ease-in-out; }
        .view-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-brand shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#" onclick="showView('home')">
                <i class="bi bi-shield-check fs-4"></i> HDIP Audit Team
            </a>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light btn-sm rounded-pill px-3" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
        </div>
    </nav>

    <div class="container py-4 flex-grow-1">

        <div id="home-view" class="view-section active">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm stat-card h-100">
                        <div class="card-body text-center p-3">
                            <h2 class="display-5 fw-bold text-brand mb-0" id="stat-scheduled">-</h2>
                            <small class="text-muted text-uppercase fw-bold">Scheduled Inspections</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm stat-card h-100" style="border-left-color: #198754;">
                        <div class="card-body text-center p-3">
                            <h2 class="display-5 fw-bold text-success mb-0" id="stat-completed">-</h2>
                            <small class="text-muted text-uppercase fw-bold">Completed Today</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clipboard-check text-brand me-2"></i>Pending Inspections</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">App ID</th>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="audit-list-body">
                                <tr><td colspan="5" class="text-center py-4 text-muted">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="inspection-view" class="view-section">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-3" style="position: sticky; top: 80px;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-brand text-white py-3 rounded-top-4">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2"></i>Premise Details</h6>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-1" id="insp-company">Company Name</h5>
                                <p class="text-muted small mb-3" id="insp-address">Address...</p>
                                
                                <div class="mb-3">
                                    <label class="small text-muted fw-bold">CONTACT</label>
                                    <div id="insp-contact">Person</div>
                                    <div class="small" id="insp-phone">Phone</div>
                                </div>

                                <hr class="opacity-25">
                                
                                <button class="btn btn-outline-secondary w-100 mb-2" onclick="showView('home')">Cancel</button>
                                <button class="btn btn-brand w-100 fw-bold" onclick="submitAuditResult()">
                                    <i class="bi bi-check2-all me-2"></i>Finalize Audit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-list-check text-brand me-2"></i>On-Site Checklist</h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="auditForm">
                                <input type="hidden" name="app_id" id="insp-app-id">
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">1. Raw Materials & Ingredients</label>
                                    <select class="form-select mb-2" name="check_materials">
                                        <option value="Compliant">Compliant</option>
                                        <option value="Non-Compliant">Non-Compliant</option>
                                    </select>
                                    <textarea class="form-control form-control-sm" placeholder="Remarks..." name="rem_materials"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">2. Storage & Warehousing</label>
                                    <select class="form-select mb-2" name="check_storage">
                                        <option value="Compliant">Compliant</option>
                                        <option value="Non-Compliant">Non-Compliant</option>
                                    </select>
                                    <textarea class="form-control form-control-sm" placeholder="Remarks..." name="rem_storage"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">3. Processing & Equipment (Cleanliness)</label>
                                    <select class="form-select mb-2" name="check_process">
                                        <option value="Compliant">Compliant</option>
                                        <option value="Non-Compliant">Non-Compliant</option>
                                    </select>
                                    <textarea class="form-control form-control-sm" placeholder="Remarks..." name="rem_process"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">4. Waste Disposal</label>
                                    <select class="form-select mb-2" name="check_waste">
                                        <option value="Compliant">Compliant</option>
                                        <option value="Non-Compliant">Non-Compliant</option>
                                    </select>
                                    <textarea class="form-control form-control-sm" placeholder="Remarks..." name="rem_waste"></textarea>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-uppercase text-brand">Final Recommendation</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="final_verdict" id="v_approve" value="Approved" checked>
                                            <label class="form-check-label fw-bold text-success" for="v_approve">
                                                Approve for Certification
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="final_verdict" id="v_reject" value="Rejected">
                                            <label class="form-check-label fw-bold text-danger" for="v_reject">
                                                Fail / Re-Audit Required
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // State
        let auditList = [];

        document.addEventListener('DOMContentLoaded', () => {
            loadAuditTasks();
        });

        function showView(viewName) {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById(viewName + '-view').classList.add('active');
            window.scrollTo(0,0);
        }

        async function loadAuditTasks() {
            try {
                const res = await fetch('actions/fetch_audit_tasks.php');
                const data = await res.json();
                auditList = data.tasks;

                // Update Stats
                document.getElementById('stat-scheduled').innerText = data.stats.scheduled;
                document.getElementById('stat-completed').innerText = data.stats.completed;

                // Render Table
                const tbody = document.getElementById('audit-list-body');
                if(auditList.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">No pending inspections found.</td></tr>';
                    return;
                }

                tbody.innerHTML = auditList.map(task => `
                    <tr>
                        <td class="ps-4 fw-bold text-secondary">#${task.id}</td>
                        <td class="fw-medium">${task.company_name}</td>
                        <td class="text-muted small text-truncate" style="max-width: 200px;">${task.business_address}</td>
                        <td class="small">${task.contact_person}</td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-brand rounded-pill px-3" onclick="startInspection(${task.id})">
                                Inspect
                            </button>
                        </td>
                    </tr>
                `).join('');

            } catch (e) {
                console.error("Fetch error", e);
            }
        }

        function startInspection(id) {
            const task = auditList.find(t => t.id == id);
            if(!task) return;

            // Populate Form
            document.getElementById('insp-app-id').value = task.id;
            document.getElementById('insp-company').innerText = task.company_name;
            document.getElementById('insp-address').innerText = task.business_address;
            document.getElementById('insp-contact').innerText = task.contact_person;
            document.getElementById('insp-phone').innerText = task.telephone;

            // Reset Form fields
            document.getElementById('auditForm').reset();

            showView('inspection');
        }

        async function submitAuditResult() {
            if(!confirm("Submit final audit findings? This will update the application status.")) return;

            const form = document.getElementById('auditForm');
            const formData = new FormData(form);

            try {
                const res = await fetch('actions/submit_audit_review.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if(data.success) {
                    alert("Audit Submitted Successfully!");
                    loadAuditTasks(); // Refresh list
                    showView('home');
                } else {
                    alert("Error: " + data.message);
                }
            } catch (e) {
                alert("Submission failed.");
            }
        }
    </script>
</body>
</html>