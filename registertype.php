<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['user_role'] == 'owner' ? 'owner_dashboard.php' : 'customer_dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Selection - Halal Keeps</title>
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
        <h1 class="fw-bold text-dark">Create Account</h1>
        <p class="text-muted">Join us as...</p>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-5 col-lg-4">
            <a href="register_customer.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-5">
                    <div class="mb-3 text-success"><i class="bi bi-person-plus-fill display-3"></i></div>
                    <h4 class="fw-bold text-dark">Customer</h4>
                    <p class="text-muted">I want to find Halal restaurants and write reviews.</p>
                </div>
            </a>
        </div>

        <div class="col-md-5 col-lg-4">
            <a href="register.php" class="text-decoration-none">
                <div class="card card-select h-100 shadow-sm border-0 p-5">
                    <div class="mb-3 text-primary"><i class="bi bi-shop-window display-3"></i></div>
                    <h4 class="fw-bold text-dark">Business Owner</h4>
                    <p class="text-muted">I want to get certified and manage my business.</p>
                </div>
            </a>
        </div>
        
        <div class="col-12 mt-4">
            <p class="text-muted small">
                Represent a Certifying Body? <a href="register_certifier.php" class="fw-bold text-success text-decoration-none">Register as Certifier</a>
            </p>
        </div>
    </div>
    
    <div class="mt-5">
        <a href="welcome.php" class="text-muted text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
    </div>
  </div>
</body>
</html>