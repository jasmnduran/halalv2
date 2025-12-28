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
    :root {
      --primary-green: #0d8c4c;
      --secondary-green: #16a765;
      --light-green: #e8f5e9;
      --bs-body-bg: #f5f7fa;
      --bs-font-sans-serif: 'Inter', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .hero-container {
      max-width: 1000px;
      margin: 0 auto;
    }

    .logo-circle {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 3px solid var(--primary-green);
      padding: 4px;
      background: white;
      box-shadow: 0 10px 25px rgba(13, 140, 76, 0.2);
      object-fit: cover;
    }

    .main-card {
      background: white;
      border-radius: 1.5rem;
      border: none;
      box-shadow: 0 10px 40px rgba(0,0,0,0.05);
      overflow: hidden;
      border-top: 5px solid var(--primary-green);
    }

    .feature-card {
      background: #f8faf9;
      border-radius: 1rem;
      padding: 1.5rem;
      height: 100%;
      transition: all 0.3s ease;
      border: 1px solid rgba(0,0,0,0.03);
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.05);
      background: white;
      border-color: var(--light-green);
    }

    .btn-hero {
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      border: none;
      padding: 12px 32px;
      border-radius: 50px;
      font-weight: 600;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(13, 140, 76, 0.3);
      transition: all 0.3s ease;
    }
    .btn-hero:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(13, 140, 76, 0.4);
      background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
    }

    .check-list li {
      margin-bottom: 0.5rem;
      display: flex;
      align-items: start;
      gap: 10px;
      color: #555;
    }
    .check-list i {
      color: var(--primary-green);
      font-size: 1.1rem;
      margin-top: 2px;
    }
  </style>
</head>
<body class="py-5">

  <div class="container hero-container">
    
    <div class="text-center mb-5 fade-in">
      <img src="logo.jpg" alt="Logo" class="logo-circle mb-4">
      <h1 class="fw-bold display-5 text-dark mb-2">Welcome to Halal Keeps</h1>
      <p class="lead text-success fw-medium">Verified Halal, Anytime, Anywhere.</p>
    </div>

    <div class="card main-card mb-5">
      <div class="card-body p-4 p-lg-5">
        <div class="row g-5 align-items-center">
          
          <div class="col-lg-6">
            <h2 class="h3 fw-bold mb-3 text-dark">Empowering Communities, Connecting Businesses</h2>
            <p class="text-secondary mb-4" style="line-height: 1.7;">
              Halal Keeps connects you to verified halal businesses through a trusted, centralized platform. 
              Whether you are looking for a meal or growing your business, we ensure quality, compliance, and ethical consumption.
            </p>
            
            <ul class="list-unstyled check-list mb-4">
              <li><i class="bi bi-check-circle-fill"></i> <span>Find halal-friendly food with real-time GPS search</span></li>
              <li><i class="bi bi-shield-check"></i> <span>Trust blockchain-backed verification data</span></li>
              <li><i class="bi bi-heart-fill"></i> <span>Support ethical consumption (SDG 8 & 12)</span></li>
              <li><i class="bi bi-graph-up-arrow"></i> <span>Business analytics & Halal Starter Pack</span></li>
            </ul>

            <div class="d-grid d-sm-block text-center text-sm-start">
              <button class="btn btn-hero btn-lg text-white" data-bs-toggle="modal" data-bs-target="#authModal">
                Get Started Now
              </button>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="d-flex flex-column gap-3">
              <div class="feature-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="bg-success bg-opacity-10 p-2 rounded-circle text-success">
                    <i class="bi bi-people-fill fs-4"></i>
                  </div>
                  <h3 class="h5 fw-bold mb-0 text-dark">For Users</h3>
                </div>
                <p class="small text-muted mb-0">Discover certified halal & pork-free dining options nearby. Read community reviews and dine with confidence.</p>
              </div>

              <div class="feature-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary">
                    <i class="bi bi-shop-window fs-4"></i>
                  </div>
                  <h3 class="h5 fw-bold mb-0 text-dark">For Business Owners</h3>
                </div>
                <p class="small text-muted mb-0">Showcase your halal status, access market insights, and streamline your certification process.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="text-center text-muted small px-3">
      <p class="mb-0 max-w-md mx-auto">
        Halal Keeps empowers communities by promoting responsible and ethical consumption through a trusted digital ecosystem.
      </p>
      <div class="mt-3 opacity-50">
        &copy; <?php echo date("Y"); ?> Halal Keeps. All rights reserved.
      </div>
    </div>

  </div>

  <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
        <div class="modal-header border-0 bg-light p-4">
          <h5 class="modal-title fw-bold mx-auto text-dark">Join Halal Keeps</h5>
          <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <p class="text-muted mb-4">Select an option to continue your journey</p>
          <div class="d-grid gap-3">
            <a href="logintype.php" class="btn btn-success btn-lg fw-bold py-3 rounded-3 shadow-sm">
              <i class="bi bi-box-arrow-in-right me-2"></i> Log In
            </a>
            <a href="registertype.php" class="btn btn-outline-success btn-lg fw-bold py-3 rounded-3">
              <i class="bi bi-person-plus me-2"></i> Create Account
            </a>
          </div>
        </div>
        <div class="modal-footer border-0 bg-light justify-content-center py-3">
          <small class="text-muted">By continuing, you agree to our Terms & Privacy Policy.</small>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>