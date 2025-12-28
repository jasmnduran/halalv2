<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Submitted - Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-green: #0d8c4c;
      --bs-body-bg: #f5fcf7;
      --bs-font-sans-serif: 'Inter', sans-serif;
    }
    body { background-color: var(--bs-body-bg); }

    .success-container { max-width: 650px; margin: 0 auto; }
    
    .success-card {
        background: white;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 5px solid var(--primary-green);
    }
    
    .step-list {
        list-style: none;
        padding: 0;
        position: relative;
    }
    .step-list li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 0.75rem;
        color: #495057;
    }
    .step-list li::before {
        content: "\F26A"; /* Bootstrap Icon Check */
        font-family: "bootstrap-icons";
        position: absolute;
        left: 0;
        color: var(--primary-green);
        font-weight: bold;
    }
  </style>
</head>
<body class="py-5">
  <div class="container success-container">
    
    <div class="text-center mb-4">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border" width="60" height="60">
    </div>

    <div class="success-card p-4 p-md-5 text-center">
      <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success display-1"></i>
      </div>
      
      <h2 class="fw-bold text-dark mb-2">Application Submitted!</h2>
      <p class="text-muted mb-4">Your Halal certification request has been received.</p>
      
      <?php if (isset($_GET['id'])): ?>
        <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 py-2 px-3 d-inline-block rounded-pill mb-4">
          <i class="bi bi-hash me-1"></i> Application ID: <strong><?php echo htmlspecialchars($_GET['id']); ?></strong>
        </div>
      <?php endif; ?>

      <div class="card bg-light border-0 rounded-4 text-start p-4 mb-4">
        <h5 class="fw-bold text-success mb-3">What happens next?</h5>
        <ul class="step-list mb-0">
          <li>Review within 5-7 business days</li>
          <li>Confirmation of audit schedule via email</li>
          <li>Initial on-site assessment by auditors</li>
          <li>Feedback & compliance recommendations</li>
          <li>Final audit and certificate issuance</li>
        </ul>
      </div>

      <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
        <a href="owner_dashboard.php" class="btn btn-success fw-bold px-4 py-2" onclick="return closeModalAndRedirect(event)">
            Back to Dashboard
        </a>
        <a href="halal_certification_application.php" class="btn btn-outline-secondary px-4 py-2">
            Submit Another
        </a>
      </div>
    </div>
    
    <div class="text-center mt-4 text-muted small">
        <p class="mb-1">Need help? Email us at <a href="mailto:certification@halalkeeps.com" class="text-decoration-none text-success">certification@halalkeeps.com</a></p>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function closeModalAndRedirect(e) {
      // Check if inside a modal/iframe
      if (window.parent && window.parent !== window) {
        e.preventDefault();
        // Assuming parent has a standard modal close logic, or we just reload parent
        window.parent.location.href = 'owner_dashboard.php';
        return false;
      }
      return true;
    }
  </script>
</body>
</html>