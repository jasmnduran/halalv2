<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Market Insights - Your Area Analysis</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .tool-btn {
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
      margin-bottom: 15px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .tool-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }
  </style>
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .main-card { max-width: 600px; margin: 32px auto; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; }
    .header-bar { background: #fff; border-bottom: 1px solid #e5e7eb; border-radius: 1rem 1rem 0 0; padding: 1rem 1.5rem; display: flex; align-items: center; }
    .header-bar .back-btn { font-size: 1.5rem; color: #22c55e; background: none; border: none; margin-right: 0.5rem; }
    .header-bar img { height: 40px; width: 40px; border-radius: 50%; margin-right: 1rem; }
    .header-bar .menu-btn { margin-left: auto; font-size: 2rem; color: #222; background: none; border: none; }
    .section-title { font-weight: 600; font-size: 1.2em; margin-top: 1.5rem; }
    .stat-title { font-size: 1.1em; color: #64748b; }
    .stat-value { font-size: 2em; font-weight: bold; }
    .stat-accent { color: #22c55e; }
    .tool-btn { border: none; background: #f3f4f6; border-radius: 0.5rem; padding: 0.75rem 1.2rem; font-weight: 500; margin-right: 1rem; margin-bottom: 0.5rem; display: inline-block; }
    .tool-btn.demand { color: #2563eb; }
    .tool-btn.competitor { color: #f97316; }
    @media (max-width: 600px) {
      .main-card { margin: 0; border-radius: 0; }
      .header-bar { border-radius: 0; }
    }
  </style>
</head>
<body>
  <div class="main-card bg-white">
    <div class="header-bar">
      <button onclick="history.back()" class="back-btn" title="Back">&#8592;</button>
      <span class="fw-bold fs-5">Market Insights</span>
      <button class="menu-btn d-md-none" title="Menu"><span>&#9776;</span></button>
    </div>
    <div class="p-4">
      <div class="text-muted mb-2">Makati City, Metro Manila</div>
      <h2 class="fw-bold mb-1" style="font-size:1.4em;">Your Local Halal Market</h2>
      <div class="mb-3" style="font-size:0.98em; color:#64748b;">Based on demographic data, consumer surveys, and market trends in your area.</div>
      <div class="row g-2 mb-3">
        <div class="col-6">
          <div class="stat-title mb-1">Muslim Population</div>
          <div class="stat-value stat-accent">24,500</div>
          <div class="small text-muted">Within 5km radius</div>
        </div>
        <div class="col-6">
          <div class="stat-title mb-1">Market Growth</div>
          <div class="stat-value" style="color:#16a34a;">+18%</div>
          <div class="small text-muted">Year over year</div>
        </div>
      </div>
      <div class="section-title mb-2">Revenue Projection</div>
      <div class="mb-3">
        <div class="d-flex justify-content-between">
          <span>Current Average (Non-Halal):</span>
          <span class="fw-bold text-muted">₱45,000/month</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Projected (With Halal):</span>
          <span class="fw-bold" style="color:#22c55e;">₱61,000/month</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Monthly Increase:</span>
          <span class="fw-bold" style="color:#0ea5e9;">+₱16,000</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Annual Increase:</span>
          <span class="fw-bold" style="color:#a78bfa;">+₱192,000</span>
        </div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold mb-2">Growth Factors</div>
        <ul class="mb-0">
          <li>25% increase in customer base</li>
          <li>10% premium pricing capability</li>
          <li>Higher customer retention rate</li>
        </ul>
      </div>
      <div class="d-flex flex-wrap gap-2 mt-3">
        <a href="market_insights_demand.php" class="tool-btn demand">&#128200; Demand Analysis</a>
        <a href="#" class="tool-btn competitor">&#128202; Competitor Analysis</a>
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
    $('.tool-btn, button').on('touchstart', function() {
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