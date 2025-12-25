<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .form-section {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 24px;
      border-top: 4px solid var(--primary-green);
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .form-section h2 {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-green);
    }

    .form-row {
      display: flex;
      gap: 16px;
      margin-bottom: 16px;
    }

    .form-row .form-group {
      flex: 1;
      margin-bottom: 0;
    }

    .submit-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.3rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(13, 140, 76, 0.3);
      margin-bottom: 12px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      
      .form-section {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo">
    <h1 class="text-center">Business Registration</h1>
    <p class="subtitle text-center">Create your business account</p>
    
    <form action="actions/register.php" method="post" autocomplete="off">
      <div class="form-section">
        <h2>Personal Information</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First name" required>
          </div>
          <div class="form-group">
            <label for="middle_initial">Middle Initial</label>
            <input type="text" id="middle_initial" name="middle_initial" placeholder="Middle initial" maxlength="1">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last name" required>
          </div>
          <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" placeholder="Age" min="0" required>
          </div>
        </div>
        <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <div class="form-section">
        <h2>Location</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="barangay">Barangay</label>
            <input type="text" id="barangay" name="barangay" placeholder="Enter barangay" required>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="City" required>
          </div>
        </div>
        <div class="form-group">
          <label for="province">Province</label>
          <input type="text" id="province" name="province" placeholder="Province" required>
        </div>
      </div>

      <div class="form-section">
        <h2>Account Information</h2>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter email address" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create password" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
          </div>
        </div>
      </div>

      <button type="submit" class="submit-btn">Create Business Owner Account</button>
      
      <div class="text-center mt-2">
        Already have an account? <a href="logintype.php" class="link">Sign in</a>
      </div>
    </form>
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
    $('input, select, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Form validation
    $('form').on('submit', function(e) {
      var password = $('input[name="password"]').val();
      var confirmPassword = $('input[name="confirm_password"]').val();
      
      if (password !== confirmPassword) {
        e.preventDefault();
        $.mobile.showPageLoadingMsg('error', 'Passwords do not match!', true);
        setTimeout(function() {
          $.mobile.hidePageLoadingMsg();
        }, 2000);
        return false;
      }
    });
  });
</script>
</html>