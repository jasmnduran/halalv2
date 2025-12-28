<?php
// Get transaction hash from query string
$tx = isset($_GET['tx']) ? $_GET['tx'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blockchain Verification - Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .verify-card { max-width: 550px; width: 100%; border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .hash-box { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0.5rem; padding: 1rem; word-break: break-all; font-family: 'Courier New', monospace; color: #495057; }
    .icon-circle { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
  </style>
</head>
<body class="p-3">
  <div class="card verify-card p-4 p-md-5">
    
    <?php if ($tx): ?>
      <div class="text-center">
        <div class="icon-circle bg-success bg-opacity-10 text-success">
            <i class="bi bi-shield-check display-3"></i>
        </div>
        
        <span class="badge bg-success rounded-pill px-3 py-2 mb-3">Verified on Blockchain</span>
        <h2 class="fw-bold mb-4">Transaction Verified</h2>
        
        <p class="text-muted small text-uppercase fw-bold mb-2">Transaction Hash</p>
        <div class="hash-box mb-4">
            <?= htmlspecialchars($tx) ?>
        </div>

        <a href="https://mumbai.polygonscan.com/tx/<?= urlencode($tx) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4 mb-3">
            <i class="bi bi-box-arrow-up-right me-2"></i>View on PolygonScan
        </a>
      </div>
    <?php else: ?>
      <div class="text-center">
        <div class="icon-circle bg-danger bg-opacity-10 text-danger">
            <i class="bi bi-exclamation-triangle display-3"></i>
        </div>
        <h3 class="fw-bold text-danger mb-3">Verification Failed</h3>
        <p class="text-muted">No transaction hash was provided or the record could not be found.</p>
      </div>
    <?php endif; ?>

    <div class="text-center mt-4 pt-3 border-top">
      <a href="owner_dashboard.php" class="text-decoration-none text-secondary fw-bold">
        <i class="bi bi-arrow-left me-1"></i> Return to Dashboard
      </a>
    </div>
  </div>
</body>
</html>