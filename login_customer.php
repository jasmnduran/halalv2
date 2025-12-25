<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      max-width: 480px;
      width: 100%;
    }

    .login-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 40px;
      border-top: 4px solid var(--primary-green);
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .login-card h2 {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary-green);
      text-align: center;
      margin-bottom: 30px;
    }

    .submit-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(13, 140, 76, 0.3);
      margin-top: 10px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }

    .input-wrapper {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--gray);
      cursor: pointer;
      font-size: 1.2rem;
      padding: 5px;
      transition: color 0.3s ease;
    }

    .password-toggle:hover {
      color: var(--primary-green);
    }

    .forgot-password {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }

    .register-section {
      text-align: center;
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid #e0e0e0;
      color: var(--gray);
      font-size: 0.95rem;
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 30px 25px;
      }

      .login-card h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo">
    <h1>Welcome to Halal Keeps</h1>
    <p class="subtitle">Your trusted platform for verified halal businesses</p>
    
    <div class="login-card">
      <h2>Sign In</h2>
      <form action="actions/login.php" method="post">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="button" class="password-toggle" onclick="togglePassword()">
              <span id="toggleIcon">👁</span>
            </button>
          </div>
        </div>
        
        <button type="submit" class="submit-btn">Sign in</button>
      </form>
      
      <div class="forgot-password">
        <a href="#" class="link">Forgot Password?</a>
      </div>
      
      <div class="register-section">
        Don't have an account? <a href="registertype.php" class="link">Create New Account</a>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // jQuery Mobile initialization
    $(document).ready(function() {
      // Initialize jQuery Mobile
      $.mobile.initializePage();
      
      // Enhanced mobile interactions
      $('input, button').on('touchstart', function() {
        $(this).addClass('ui-btn-active');
      }).on('touchend', function() {
        $(this).removeClass('ui-btn-active');
      });
      
      // Form validation with mobile-friendly feedback
      $('form').on('submit', function(e) {
        var email = $('input[name="email"]').val();
        var password = $('input[name="password"]').val();
        
        if (!email || !password) {
          e.preventDefault();
          $.mobile.showPageLoadingMsg('error', 'Please fill in all fields', true);
          setTimeout(function() {
            $.mobile.hidePageLoadingMsg();
          }, 2000);
          return false;
        }
      });
    });

    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.textContent = '🙈';
      } else {
        passwordInput.type = 'password';
        toggleIcon.textContent = '👁';
      }
    }
  </script>
</html>