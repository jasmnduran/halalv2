<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Choose Account Type | Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      display: flex;
      align-items: center;
      padding: 40px 20px;
    }

    .container {
      max-width: 900px;
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
      animation: fadeInDown 0.6s ease;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2rem;
    }

    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #1a1a1a;
      animation: fadeInDown 0.6s ease 0.1s both;
    }

    .subtitle {
      color: var(--gray);
      font-size: 1.1rem;
      margin-bottom: 2rem;
      animation: fadeInDown 0.6s ease 0.2s both;
    }

    .type-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 40px 30px;
      transition: all 0.3s ease;
      cursor: pointer;
      border: 2px solid transparent;
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .type-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-green), var(--secondary-green));
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .type-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-8px);
      border-color: var(--primary-green);
    }

    .type-card:hover::before {
      transform: scaleX(1);
    }

    .type-card:active {
      transform: translateY(-5px);
    }

    .type-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      margin: 0 auto 20px;
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.25);
      transition: all 0.3s ease;
      color: white;
    }

    .type-card:hover .type-icon {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 12px 35px rgba(13, 140, 76, 0.35);
    }

    .type-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 12px;
    }

    .type-desc {
      color: var(--gray);
      font-size: 1.05rem;
      line-height: 1.6;
    }

    .login-section {
      background: var(--card-bg);
      padding: 25px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      animation: fadeInUp 0.6s ease 0.5s both;
    }

    .link {
      color: var(--primary-green);
      text-decoration: none;
      font-weight: 600;
      position: relative;
      transition: color 0.3s ease;
    }

    .link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary-green);
      transition: width 0.3s ease;
    }

    .link:hover {
      color: var(--secondary-green);
    }

    .link:hover::after {
      width: 100%;
    }

    .card-container {
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    a {
      text-decoration: none;
    }

    .row {
      margin-bottom: 2rem;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2rem;
      }

      .type-card {
        padding: 30px 20px;
        margin-bottom: 20px;
      }

      .type-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
      }

      .type-title {
        font-size: 1.3rem;
      }

      .subtitle {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo mb-4"><img src="logo.jpg" alt="Halal Keeps Logo" class="logo"></div>
    <p class="text-center subtitle">Choose your account type to get started</p>
    
    <div class="row justify-content-center card-container">
      <div class="col-12 col-md-6 mb-4">
        <a href="register.php">
          <div class="type-card text-center">
            <div class="type-icon"><i class="fas fa-store"></i></div>
            <div class="type-title">Business Owner</div>
            <div class="type-desc">Register your halal business and reach more customers</div>
          </div>
        </a>
      </div>
      
      <div class="col-12 col-md-6 mb-4">
        <a href="register_customer.php">
          <div class="type-card text-center">
            <div class="type-icon"><i class="fas fa-user"></i></div>
            <div class="type-title">Customer</div>
            <div class="type-desc">Discover and connect with verified halal businesses</div>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-6 mb-4">
        <a href="register_certifier.html">
          <div class="type-card text-center">
            <div class="type-icon"><i class="fas fa-certificate"></i></div>
            <div class="type-title">Halal Certifying Body</div>
            <div class="type-desc">Register your organization to verify and certify halal businesses</div>
          </div>
        </a>
      </div>
    </div>
    
    <div class="login-section text-center">
      <span style="color: var(--gray); font-size: 1.05rem;">Already have an account?</span> 
      <a href="logintype.php" class="link">Sign in</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
