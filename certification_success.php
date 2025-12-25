<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Submitted - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .success-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }

    .success-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 40px;
      text-align: center;
      border-top: 4px solid var(--primary-green);
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .success-icon {
      font-size: 4rem;
      color: var(--primary-green);
      margin-bottom: 20px;
    }

    .success-card h1 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .success-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .application-id {
      background: var(--light-green);
      border: 2px solid var(--primary-green);
      border-radius: 10px;
      padding: 15px;
      margin: 20px 0;
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--primary-green);
    }

    .next-steps {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin: 20px 0;
      text-align: left;
    }

    .next-steps h3 {
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .next-steps ul {
      margin: 0;
      padding-left: 20px;
    }

    .next-steps li {
      margin-bottom: 8px;
      line-height: 1.6;
    }

    .contact-info {
      background: var(--light-green);
      border-radius: 10px;
      padding: 20px;
      margin: 20px 0;
    }

    .contact-info h4 {
      color: var(--primary-green);
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .success-container {
        padding: 10px;
      }
      
      .success-card {
        padding: 30px 20px;
      }

      .success-card h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="success-container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo">
    
    <div class="success-card">
      <div class="success-icon">✅</div>
      <h1>Application Submitted Successfully!</h1>
      <p>Your halal certification application has been received and is now under review.</p>
      
      <?php if (isset($_GET['id'])): ?>
        <div class="application-id">
          Application ID: #<?php echo htmlspecialchars($_GET['id']); ?>
        </div>
      <?php endif; ?>

      <div class="next-steps">
        <h3>What happens next?</h3>
        <ul>
          <li>We will review your application within 5-7 business days</li>
          <li>Our team will contact you to confirm audit dates</li>
          <li>You will receive a detailed audit schedule via email</li>
          <li>Our auditors will conduct the initial assessment</li>
          <li>You will receive feedback and recommendations</li>
          <li>Final audit will be scheduled upon compliance</li>
        </ul>
      </div>

      <div class="contact-info">
        <h4>Need Help?</h4>
        <p>If you have any questions about your application, please contact us:</p>
        <p><strong>Email:</strong> certification@halalkeeps.com</p>
        <p><strong>Phone:</strong> +63 2 1234 5678</p>
        <p><strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
      </div>

      <div style="margin-top: 30px;">
        <a href="owner_dashboard.php" class="btn" onclick="closeModalAndRedirect()">Back to Dashboard</a>
        <a href="halal_certification_application.php" class="btn btn-secondary" style="margin-left: 10px;">Submit Another Application</a>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function closeModalAndRedirect() {
      // Check if we're in an iframe (modal)
      if (window.parent !== window) {
        // Close the modal and redirect parent window
        window.parent.postMessage('closeModal', '*');
        window.parent.location.href = 'owner_dashboard.php';
      } else {
        // Direct navigation if not in iframe
        window.location.href = 'owner_dashboard.php';
      }
    }

    $(document).ready(function() {
      $.mobile.initializePage();
      
      $('.btn').on('touchstart', function() {
        $(this).addClass('ui-btn-active');
      }).on('touchend', function() {
        $(this).removeClass('ui-btn-active');
      });
    });
  </script>
</body>
</html>
