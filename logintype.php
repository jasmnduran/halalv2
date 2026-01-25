<?php
session_start();
// Auto-redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'owner') {
        header("Location: owner_dashboard.php");
    } else {
        header("Location: customer_dashboard.php");
    }
    exit();
} elseif (isset($_SESSION['certifier_id'])) {
    header("Location: halal_certifying_body.php");
    exit();
} elseif (isset($_SESSION['auditor_id'])) {
    header("Location: audit-team.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Selection - Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
      body { background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
      .card-select { transition: transform 0.2s; cursor: pointer; border: 2px solid transparent; }
      .card-select:hover { transform: translateY(-5px); border-color: #198754; }
  </style>
</head>
<body>
  <div class="container text-center">
    <div class="mb-5">
        <h1 class="fw-bold text-dark">Welcome Back</h1>
        <p class="text-muted">Choose your account type to login</p>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-4 col-lg-3">
            <a href="login_customer.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-4">
                    <div class="mb-3 text-success"><i class="bi bi-person-fill display-4"></i></div>
                    <h5 class="fw-bold text-dark">Customer</h5>
                    <p class="small text-muted mb-0">Find Halal food</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="login_owner.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-4">
                    <div class="mb-3 text-primary"><i class="bi bi-shop display-4"></i></div>
                    <h5 class="fw-bold text-dark">Business Owner</h5>
                    <p class="small text-muted mb-0">Manage certifications</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="login_certifier.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-4">
                    <div class="mb-3 text-warning"><i class="bi bi-patch-check-fill display-4"></i></div>
                    <h5 class="fw-bold text-dark">Certifier</h5>
                    <p class="small text-muted mb-0">Review applications</p>
                </div>
            </a>
        </div>
        
        <div class="col-md-4 col-lg-3">
            <a href="login_auditor.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-4">
                    <div class="mb-3 text-info"><i class="bi bi-clipboard-check-fill display-4"></i></div>
                    <h5 class="fw-bold text-dark">Auditor</h5>
                    <p class="small text-muted mb-0">Field inspections</p>
                </div>
            </a>
        </div>
    </div>
    
    <div class="mt-5">
        <a href="welcome.php" class="text-muted text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
    </div>
  </div>
</body>
</html>