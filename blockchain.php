<?php
// Example: Get transaction hash from query string
$tx = isset($_GET['tx']) ? $_GET['tx'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blockchain Verification - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .blockchain-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .blockchain-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .blockchain-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .blockchain-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .blockchain-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 15px;
    }

    .blockchain-card ul {
      color: #333;
      line-height: 1.7;
      padding-left: 20px;
    }

    .blockchain-card li {
      margin-bottom: 8px;
    }

    @media (max-width: 768px) {
      .blockchain-card {
        padding: 25px 20px;
      }

      .blockchain-card h2, .blockchain-card h3 {
        font-size: 1.3rem;
      }
    }
  </style>
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .main-card { max-width: 500px; margin: 64px auto; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); background: #fff; padding: 2rem; text-align: center; }
    .tx-hash { font-family: monospace; font-size: 1.1em; color: #198754; }
    .explorer-link { color: #198754; font-weight: 500; }
    .status-badge { background: #198754; color: #fff; border-radius: 0.5em; padding: 0.3em 0.8em; font-size: 1em; }
  </style>
</head>
<body>
  <div class="main-card">
    <h2 class="fw-bold mb-3" style="color:#198754;">Blockchain Verification</h2>
    <?php if ($tx): ?>
      <div class="mb-3">
        <span class="status-badge">Verified</span>
      </div>
      <div class="mb-2">Transaction Hash:</div>
      <div class="tx-hash mb-3"><?= htmlspecialchars($tx) ?></div>
      <a href="https://mumbai.polygonscan.com/tx/<?= urlencode($tx) ?>" target="_blank" class="explorer-link">View on PolygonScan</a>
    <?php else: ?>
      <div class="text-danger mb-3">No transaction hash provided.</div>
    <?php endif; ?>
    <div class="mt-4">
      <a href="owner_dashboard.php" class="btn btn-success">Return to Dashboard</a>
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
    $('.btn, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly navigation
    $('a').on('click', function() {
      $.mobile.showPageLoadingMsg();
    });
  });
</script>
</html> 