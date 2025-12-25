<?php 
session_start(); 
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - Halal Keeps</title>
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
    <h1 class="text-center">Edit Profile</h1>
    <form action="actions/edit_profile.php" method="post">
      <div class="card" style="margin-bottom: 24px;">
        <h2 style="font-size:1.2em;font-weight:bold;margin-bottom:8px;">Personal Information</h2>
        <hr>
        <div style="display:flex; gap:16px;">
          <div style="flex:1;">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="First name" required value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
          </div>
          <div style="flex:1;">
            <label>Middle Initial</label>
            <input type="text" name="middle_initial" placeholder="Middle initial" maxlength="1" value="<?= htmlspecialchars($user['middle_initial'] ?? '') ?>">
          </div>
        </div>
        <div style="display:flex; gap:16px; margin-top:8px;">
          <div style="flex:1;">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Last name" required value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
          </div>
          <div style="flex:1;">
            <label>Age</label>
            <input type="number" name="age" placeholder="Age" min="0" required value="<?= htmlspecialchars($user['age'] ?? '') ?>">
          </div>
        </div>
        <div style="margin-top:8px;">
          <label>Gender</label>
          <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
      </div>
      <div class="card" style="margin-bottom: 24px;">
        <h2 style="font-size:1.2em;font-weight:bold;margin-bottom:8px;">Location</h2>
        <hr>
        <div style="display:flex; gap:16px;">
          <div style="flex:1;">
            <label>Barangay</label>
            <input type="text" name="barangay" placeholder="Enter barangay" required value="<?= htmlspecialchars($user['barangay'] ?? '') ?>">
          </div>
          <div style="flex:1;">
            <label>City</label>
            <input type="text" name="city" placeholder="City" required value="<?= htmlspecialchars($user['city'] ?? '') ?>">
          </div>
        </div>
        <div style="margin-top:8px;">
          <label>Province</label>
          <input type="text" name="province" placeholder="Province" required value="<?= htmlspecialchars($user['province'] ?? '') ?>">
        </div>
      </div>
      <div class="card" style="margin-bottom: 24px;">
        <h2 style="font-size:1.2em;font-weight:bold;margin-bottom:8px;">Account Information</h2>
        <hr>
        <div style="margin-bottom:8px;">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter email address" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        </div>
      </div>
      <button type="submit" style="width:100%;background:#218a57;color:#fff;font-size:1.3em;padding:12px 0;border:none;border-radius:6px;margin-bottom:12px;">Update Profile</button>
      <div class="text-center mt-2">
        <a href="customer_dashboard.php"><button type="button" class="btn-blue" style="min-width:160px;">Back to Dashboard</button></a>
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
      var firstName = $('input[name="first_name"]').val();
      var lastName = $('input[name="last_name"]').val();
      
      if (!firstName || !lastName) {
        e.preventDefault();
        $.mobile.showPageLoadingMsg('error', 'Please fill in required fields', true);
        setTimeout(function() {
          $.mobile.hidePageLoadingMsg();
        }, 2000);
        return false;
      }
    });
  });
</script>
</html>