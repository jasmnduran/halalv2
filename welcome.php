<?php
session_start();

// Auto-redirect if logged in
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
    // Fixed: Added Auditor Redirection
    header("Location: audit-team.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --primary-green: #0d8c4c; --secondary-green: #16a765; }
    body { background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%); min-height: 100vh; display: flex; flex-direction: column; }
    .main-card { background: white; border-radius: 1.5rem; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border-top: 5px solid var(--primary-green); }
    .logo-circle { width: 90px; height: 90px; border-radius: 50%; border: 3px solid var(--primary-green); padding: 4px; background: white; object-fit: cover; }
    .btn-hero { background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); border: none; padding: 12px 32px; border-radius: 50px; font-weight: 600; color: white; transition: all 0.3s ease; }
    .btn-hero:hover { transform: translateY(-2px); color: white; box-shadow: 0 8px 20px rgba(13, 140, 76, 0.3); }
  </style>
</head>
<body class="py-5">
  <div class="container" style="max-width: 1000px;">
    <div class="text-center mb-5">
      <img src="logo.jpg" alt="Logo" class="logo-circle mb-4">
      <h1 class="fw-bold display-5 text-dark mb-2">Welcome to Halal Keeps</h1>
      <p class="lead text-success fw-medium">Verified Halal, Anytime, Anywhere.</p>
    </div>

    <div class="card main-card mb-5">
      <div class="card-body p-4 p-lg-5">
        <div class="row g-5 align-items-center">
          <div class="col-lg-6">
            <h2 class="h3 fw-bold mb-3 text-dark">Connecting Community & Business</h2>
            <p class="text-secondary mb-4">
              Halal Keeps connects you to verified halal businesses through a trusted platform. 
              Whether you are looking for a meal or growing your business, we ensure quality and compliance.
            </p>
            <div class="d-grid d-sm-block text-center text-sm-start">
              <a href="logintype.php" class="btn btn-hero btn-lg me-sm-2 mb-2 mb-sm-0">Login</a>
              <a href="registertype.php" class="btn btn-outline-success btn-lg rounded-pill px-4">Register</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="d-flex flex-column gap-3">
              <div class="p-3 border rounded-3 bg-light">
                <div class="d-flex align-items-center gap-3">
                  <i class="bi bi-people-fill fs-2 text-success"></i>
                  <div><h5 class="fw-bold mb-0">For Users</h5><small class="text-muted">Find restaurants & leave reviews</small></div>
                </div>
              </div>
              <div class="p-3 border rounded-3 bg-light">
                <div class="d-flex align-items-center gap-3">
                  <i class="bi bi-shop fs-2 text-primary"></i>
                  <div><h5 class="fw-bold mb-0">For Business Owners</h5><small class="text-muted">Get certified & track growth</small></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center text-muted small">&copy; <?php echo date("Y"); ?> Halal Keeps. All rights reserved.</div>
  </div>
</body>
</html>