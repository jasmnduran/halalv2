<?php
session_start();
// Security: Only Owners
if (!isset($_SESSION['owner_id'])) {
    header("Location: login_owner.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Market Insights - Area Analysis</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .main-card { max-width: 650px; margin: 0 auto; border: none; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; }
    .stat-box { background: #f8fafc; padding: 1.25rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; height: 100%; text-align: center; }
    .stat-label { font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; }
    .stat-val { font-size: 1.75rem; font-weight: 700; color: #0f172a; }
    .growth-text { color: #16a34a; }
    .btn-tool { text-align: left; padding: 1rem; border: 1px solid #e2e8f0; background: white; border-radius: 0.75rem; transition: all 0.2s; }
    .btn-tool:hover { transform: translateY(-2px); border-color: #cbd5e1; background: #f8fafc; }
  </style>
</head>
<body class="py-4">
  <div class="container">
    
    <div class="main-card bg-white">
      <div class="p-4 border-bottom bg-white sticky-top">
        <div class="d-flex align-items-center">
            <a href="market_overview.php" class="btn btn-light rounded-circle btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h5 class="fw-bold mb-0">Local Market Analysis</h5>
                <small class="text-muted"><i class="bi bi-geo-alt-fill me-1"></i>Makati City, Metro Manila</small>
            </div>
        </div>
      </div>

      <div class="p-4">
        <h2 class="fw-bold mb-2">Halal Market Potential</h2>
        <p class="text-muted mb-4 small">Based on demographic data and consumer trends within a 5km radius.</p>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="stat-box">
                    <div class="stat-label">Muslim Population</div>
                    <div class="stat-val text-primary">24,500</div>
                    <small class="text-muted d-block mt-1">Potential Customers</small>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="stat-label">Market Growth</div>
                    <div class="stat-val growth-text">+18%</div>
                    <small class="text-muted d-block mt-1">Year over Year</small>
                </div>
            </div>
        </div>

        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Revenue Projection</h6>
        <div class="bg-light p-3 rounded-3 mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Current Avg (Non-Halal)</span>
                <span class="fw-semibold">₱45,000/mo</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Projected (Halal)</span>
                <span class="fw-bold text-success">₱61,000/mo</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Projected Annual Gain</span>
                <span class="badge bg-primary fs-6">+₱192,000</span>
            </div>
        </div>

        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Growth Drivers</h6>
        <ul class="list-group list-group-flush mb-4 small">
            <li class="list-group-item px-0"><i class="bi bi-check-circle-fill text-success me-2"></i>25% increase in customer base diversity</li>
            <li class="list-group-item px-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Premium pricing capability on niche items</li>
            <li class="list-group-item px-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Higher retention rate among Muslim diners</li>
        </ul>

        <div class="row g-2">
            <div class="col-md-6">
                <a href="market_insights_demand.php" class="btn btn-tool w-100 d-flex align-items-center text-decoration-none">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3"><i class="bi bi-bar-chart-fill"></i></div>
                    <div class="text-dark">
                        <div class="fw-bold">Demand Analysis</div>
                        <small class="text-muted">View Peak Times</small>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="#" class="btn btn-tool w-100 d-flex align-items-center text-decoration-none opacity-75">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3"><i class="bi bi-shop"></i></div>
                    <div class="text-dark">
                        <div class="fw-bold">Competitor Map</div>
                        <small class="text-muted">Coming Soon</small>
                    </div>
                </a>
            </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>