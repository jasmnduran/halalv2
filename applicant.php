<?php
session_start();
require_once "includes/db.php";

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login_owner.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check for existing application
$stmt = $conn->prepare("SELECT * FROM halal_certification_applications WHERE email = (SELECT email FROM users WHERE id = ?) ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$existing_app = $result->fetch_assoc();

$has_app = ($existing_app !== null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Portal - Halal Keeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; font-family: 'Inter', sans-serif; display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: white; border-right: 1px solid #eee; padding: 1.5rem; }
        .content { flex: 1; padding: 2rem; }
        .nav-link { color: #64748b; padding: 0.8rem 1rem; border-radius: 0.5rem; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 10px; }
        .nav-link.active { background-color: #e8f5e9; color: #0d8c4c; font-weight: 600; }
        .nav-link:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

    <div class="sidebar d-none d-lg-block">
        <div class="d-flex align-items-center gap-3 mb-5">
            <img src="logo.jpg" class="rounded-circle border" width="40">
            <h6 class="fw-bold mb-0 text-dark">Halal Keeps</h6>
        </div>
        
        <nav class="nav flex-column">
            <a href="owner_dashboard.php" class="nav-link"><i class="bi bi-grid"></i> Main Dashboard</a>
            <a href="#" class="nav-link active"><i class="bi bi-file-earmark-text"></i> Certification</a>
            <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Certification Portal</h2>
            <div class="d-lg-none">
                <a href="owner_dashboard.php" class="btn btn-outline-secondary btn-sm">Back</a>
            </div>
        </div>

        <?php if (!$has_app): ?>
            <div class="text-center py-5 bg-white rounded-4 border border-dashed mb-4">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-3 text-muted">
                    <i class="bi bi-clipboard-plus fs-1"></i>
                </div>
                <h4>Start Your Application</h4>
                <p class="text-muted mb-4">Get certified to unlock the full potential of the Halal market.</p>
                <a href="halal_certification_application.php" class="btn btn-success rounded-pill px-5 fw-bold">
                    Apply Now
                </a>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-1"><?= htmlspecialchars($existing_app['company_name']) ?></h5>
                            <span class="badge bg-<?= $existing_app['status'] == 'Approved' ? 'success' : 'warning' ?> text-dark">
                                <?= htmlspecialchars($existing_app['status']) ?>
                            </span>
                        </div>
                        <div class="text-end text-muted small">
                            ID: #<?= $existing_app['id'] ?><br>
                            Date: <?= date('M d, Y', strtotime($existing_app['application_date'])) ?>
                        </div>
                    </div>

                    <?php 
                        $prog = 10; // pending
                        if($existing_app['status'] == 'under_review') $prog = 40;
                        if($existing_app['status'] == 'inspection_scheduled') $prog = 70;
                        if($existing_app['status'] == 'Approved') $prog = 100;
                    ?>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: <?= $prog ?>%"></div>
                    </div>
                    <p class="small text-muted text-end"><?= $prog ?>% Complete</p>

                    <div class="d-grid gap-2 d-md-flex mt-4">
                        <a href="certification_progress.php?status=<?= strtolower($existing_app['status']) ?>" class="btn btn-success rounded-pill px-4">
                            View Detailed Progress
                        </a>
                        <?php if($existing_app['status'] == 'Pending'): ?>
                            <button class="btn btn-outline-secondary rounded-pill px-4" disabled>Edit Application (Locked)</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>