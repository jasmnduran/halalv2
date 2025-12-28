<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Choose Account Type | Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-green: #0d8c4c;
      --secondary-green: #16a765;
      --bs-body-bg: #f5f7fa;
      --bs-font-sans-serif: 'Inter', sans-serif;
    }
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .type-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        text-decoration: none;
        color: inherit;
        background: white;
        position: relative;
        overflow: hidden;
    }
    
    .type-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(13, 140, 76, 0.15);
        border: 1px solid var(--primary-green);
    }

    .type-card:hover .icon-wrapper {
        background: var(--primary-green);
        color: white;
        transform: scale(1.1);
    }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(13, 140, 76, 0.1);
        color: var(--primary-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }

    .logo-glow {
        box-shadow: 0 0 20px rgba(13, 140, 76, 0.2);
    }
  </style>
</head>
<body class="py-5">
  <div class="container">
    
    <div class="text-center mb-5">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border border-3 border-success mb-4 logo-glow" width="90" height="90">
        <h1 class="fw-bold text-dark mb-2">Sign In to Halal Keeps</h1>
        <p class="text-muted lead fs-6">Select your account type to continue</p>
    </div>

    <div class="row justify-content-center g-4 mb-5">
      <div class="col-md-4 col-lg-3">
        <a href="login_owner.php" class="card type-card p-4 text-center">
            <div class="card-body">
                <div class="icon-wrapper">
                    <i class="bi bi-shop"></i>
                </div>
                <h4 class="fw-bold mb-2">Business Owner</h4>
                <p class="text-muted small mb-0">Manage your business profile, analytics, and certifications.</p>
            </div>
        </a>
      </div>
      
      <div class="col-md-4 col-lg-3">
        <a href="login_customer.php" class="card type-card p-4 text-center">
            <div class="card-body">
                <div class="icon-wrapper">
                    <i class="bi bi-person-heart"></i>
                </div>
                <h4 class="fw-bold mb-2">Customer</h4>
                <p class="text-muted small mb-0">Discover Halal food, leave reviews, and save favorites.</p>
            </div>
        </a>
      </div>

      <div class="col-md-4 col-lg-3">
        <a href="login_certifier.html" class="card type-card p-4 text-center">
            <div class="card-body">
                <div class="icon-wrapper">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h4 class="fw-bold mb-2">Certifying Body</h4>
                <p class="text-muted small mb-0">Review applications and verify business documents.</p>
            </div>
        </a>
      </div>
    </div>
    
    <div class="text-center">
      <p class="text-muted mb-0">Don't have an account yet?</p>
      <a href="registertype.php" class="text-success fw-bold text-decoration-none">Create New Account</a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>