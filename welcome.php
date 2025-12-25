<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    :root {
      --primary-green: #0d8c4c;
      --secondary-green: #16a765;
      --light-green: #e8f5e9;
      --card-bg: #ffffff;
      --shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 15px 50px rgba(0, 0, 0, 0.12);
      --border-radius: 15px;
      --gray: #555;
    }

    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }

    .logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      box-shadow: 0 5px 20px rgba(13, 140, 76, 0.3);
      border: 3px solid var(--primary-green);
      object-fit: cover;
      display: block;
      margin: 0 auto;
    }

    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #1a1a1a;
    }

    .tagline {
      font-size: 1.25rem;
      color: var(--primary-green);
      font-weight: 500;
    }

    .value-section {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 40px;
      margin-bottom: 32px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
    }

    .value-section:hover {
      box-shadow: var(--shadow-hover);
    }

    .uvp {
      font-size: 1.1rem;
      color: var(--gray);
      line-height: 1.8;
    }

    .value-section ul {
      list-style: none;
      padding-left: 0;
    }

    .value-section ul li {
      padding: 10px 0;
      font-size: 1.05rem;
      color: var(--gray);
      transition: all 0.2s ease;
    }

    .value-section ul li:hover {
      transform: translateX(5px);
      color: var(--primary-green);
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 8px;
    }

    .card {
      background: linear-gradient(135deg, #f8fffe, var(--light-green));
      border: none;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      height: 100%;
      border-left: 4px solid var(--primary-green);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    .card ul {
      list-style: none;
      padding-left: 0;
    }

    .card ul li {
      padding: 8px 0;
      padding-left: 25px;
      position: relative;
      color: var(--gray);
    }

    .card ul li::before {
      content: '✓';
      position: absolute;
      left: 0;
      color: var(--primary-green);
      font-weight: bold;
      font-size: 1.2em;
    }

    .welcome-btn {
      font-size: 1.1rem;
      padding: 14px 40px;
      border-radius: 50px;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      border: none;
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.3);
      transition: all 0.3s ease;
      font-weight: 600;
    }

    .welcome-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(13, 140, 76, 0.4);
      background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
    }

    .footer-text {
      background: var(--card-bg);
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      font-size: 1.05rem;
      line-height: 1.8;
    }

    .modal-content {
      border-radius: 15px;
      border: none;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
      border-bottom: 1px solid #e0e0e0;
      padding: 20px 25px;
      background: linear-gradient(135deg, var(--light-green), #ffffff);
      border-radius: 15px 15px 0 0;
    }

    .modal-title {
      color: var(--primary-green);
      font-weight: 600;
    }

    .modal-body {
      padding: 30px;
    }

    .modal .btn-success {
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      border: none;
      padding: 14px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .modal .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(13, 140, 76, 0.3);
    }

    .modal .btn-outline-success {
      border: 2px solid var(--primary-green);
      color: var(--primary-green);
      padding: 14px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .modal .btn-outline-success:hover {
      background: var(--primary-green);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(13, 140, 76, 0.3);
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2rem;
      }

      .value-section {
        padding: 25px 20px;
      }

      .tagline {
        font-size: 1.1rem;
      }

      .uvp {
        font-size: 1rem;
      }

      .card {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo mt-4 mb-3">
    <h1 class="text-center mb-2">Welcome to Halal Keeps</h1>
    <p class="text-center tagline mb-5">Verified Halal, Anytime, Anywhere.</p>
    
    <div class="value-section">
      <div class="row g-4 align-items-center">
        <div class="col-12 col-lg-6">
          <h2 class="h3 mb-3" style="color:var(--primary-green); font-weight: 700;">Empowering Communities, Connecting Halal Businesses</h2>
          <p class="uvp mb-4">Halal Keeps is a digital platform designed to strengthen the halal industry by improving claim verification, promoting halal businesses, and offering halal or non-pork establishments to the community. We connect users to verified halal businesses through a centralized marketplace, helping business owners boost their income while ensuring the quality of meals offered.</p>
          <ul class="mb-4">
            <li>✔️ <b>Find halal-friendly food easily</b> with GPS-enabled search and real-time filters</li>
            <li>✔️ <b>Trust verified establishments</b> with blockchain-backed halal status</li>
            <li>✔️ <b>Support responsible, ethical consumption</b> (SDG 8 & 12)</li>
            <li>✔️ <b>Business owners:</b> Gain market insights, boost recognition, and access the Halal Starter Pack</li>
          </ul>
          <div class="text-center text-lg-start">
            <button type="button" class="btn welcome-btn btn-success" data-bs-toggle="modal" data-bs-target="#authModal">
              Let's Get Started
            </button>
          </div>
        </div>
        
        <div class="col-12 col-lg-6">
          <div class="row g-3">
            <div class="col-12">
              <div class="card">
                <div class="text-center mb-3"><span class="feature-icon">🌍</span></div>
                <h3 class="h5 text-center mb-3" style="color: var(--primary-green); font-weight: 600;">For Users</h3>
                <ul>
                  <li>Quickly find halal or non-pork food nearby</li>
                  <li>Toggle between certified halal and pork-free options</li>
                  <li>Read community reviews and feedback</li>
                </ul>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="text-center mb-3"><span class="feature-icon">🏪</span></div>
                <h3 class="h5 text-center mb-3" style="color: var(--primary-green); font-weight: 600;">For Business Owners</h3>
                <ul>
                  <li>Showcase your halal status and reach new customers</li>
                  <li>Access market insights and analytics</li>
                  <li>Download the Halal Starter Pack for easy certification steps</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="text-center mb-4">
      <div class="footer-text text-muted">
        Halal Keeps empowers communities with a trusted platform that connects users to verified halal establishments, helping businesses grow while promoting responsible and ethical consumption.
      </div>
    </div>
  </div>

  <!-- Auth Modal -->
  <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="authModalLabel">Welcome to Halal Keeps</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-4" style="font-size: 1.1rem; color: var(--gray);">Choose how you want to get started:</p>
          <div class="d-grid gap-3">
            <a href="logintype.php" class="btn btn-success btn-lg">Log In</a>
            <a href="registertype.php" class="btn btn-outline-success btn-lg">Register</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // jQuery Mobile initialization
    $(document).ready(function() {
      // Initialize jQuery Mobile
      $.mobile.initializePage();
      
      // Enhanced mobile interactions
      $('.welcome-btn, .btn').on('touchstart', function() {
        $(this).addClass('ui-btn-active');
      }).on('touchend', function() {
        $(this).removeClass('ui-btn-active');
      });
      
      // Smooth transitions for mobile
      $('a').on('click', function() {
        $.mobile.showPageLoadingMsg();
      });
      
      // Mobile-friendly modal handling
      $('#authModal').on('show.bs.modal', function() {
        $.mobile.hidePageLoadingMsg();
      });
    });
  </script>
</body>
</html>