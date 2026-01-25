<?php
require_once "includes/db.php";

$tx = isset($_GET['tx']) ? trim($_GET['tx']) : null;
$isValid = false;
$record = null;

if ($tx) {
    // Check if this hash exists in Applications OR Claims
    // 1. Check Applications
    $stmt = $conn->prepare("SELECT company_name, 'Certification' as type, status FROM halal_certification_applications WHERE blockchain_tx = ?");
    $stmt->bind_param("s", $tx);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $isValid = true;
        $record = $res->fetch_assoc();
    } else {
        // 2. Check Customer Claims
        $stmt2 = $conn->prepare("SELECT id, 'Customer Claim' as type, status FROM customer_claims WHERE blockchain_tx = ?");
        $stmt2->bind_param("s", $tx);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        if ($res2->num_rows > 0) {
            $isValid = true;
            $record = $res2->fetch_assoc();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Blockchain Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>body { background: #f6f8fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body class="p-3">
  <div class="card p-5 border-0 shadow" style="max-width: 550px; width: 100%;">
    
    <?php if ($isValid): ?>
      <div class="text-center">
        <div class="text-success mb-3"><i class="bi bi-shield-fill-check display-1"></i></div>
        <h2 class="fw-bold mb-2">Verified Record</h2>
        <span class="badge bg-success mb-4">On-Chain Verified</span>
        
        <div class="alert alert-light border text-start">
            <strong>Record Type:</strong> <?= htmlspecialchars($record['type']) ?><br>
            <strong>Status:</strong> <?= htmlspecialchars($record['status']) ?><br>
            <?php if(isset($record['company_name'])): ?>
                <strong>Entity:</strong> <?= htmlspecialchars($record['company_name']) ?>
            <?php endif; ?>
        </div>
        
        <p class="text-muted small fw-bold">Transaction Hash</p>
        <div class="bg-light p-2 rounded border text-break font-monospace small mb-4">
            <?= htmlspecialchars($tx) ?>
        </div>

        <a href="https://mumbai.polygonscan.com/tx/<?= urlencode($tx) ?>" target="_blank" class="btn btn-primary w-100 rounded-pill">
            View on PolygonScan
        </a>
      </div>
    <?php else: ?>
      <div class="text-center">
        <div class="text-danger mb-3"><i class="bi bi-x-circle display-1"></i></div>
        <h3 class="fw-bold text-danger">Verification Failed</h3>
        <p class="text-muted">The transaction hash provided could not be found in our verified records.</p>
        <?php if($tx): ?>
            <div class="bg-light p-2 rounded border text-break font-monospace small text-muted">
                <?= htmlspecialchars($tx) ?>
            </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</body>
</html>