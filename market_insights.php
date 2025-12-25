<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Market Insights - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .insights-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .insights-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .insights-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .insights-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .insights-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 15px;
    }

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

    @media (max-width: 768px) {
      .insights-card {
        padding: 25px 20px;
      }

      .insights-card h2, .insights-card h3 {
        font-size: 1.3rem;
      }
    }
  </style>
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .main-card { max-width: 600px; margin: 32px auto; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; }
    .header-bar { background: #fff; border-bottom: 1px solid #e5e7eb; border-radius: 1rem 1rem 0 0; padding: 1rem 1.5rem; display: flex; align-items: center; }
    .header-bar img { height: 40px; width: 40px; border-radius: 50%; margin-right: 1rem; }
    .header-bar .back-btn { font-size: 1.5rem; color: #22c55e; background: none; border: none; margin-right: 0.5rem; }
    .header-bar .menu-btn { margin-left: auto; font-size: 2rem; color: #222; background: none; border: none; }
    .stat-card { background: #f8fafc; border-radius: 0.75rem; padding: 1.2rem; text-align: center; margin-bottom: 1rem; }
    .stat-title { font-size: 1.1em; color: #64748b; }
    .stat-value { font-size: 2em; font-weight: bold; }
    .stat-accent { color: #22c55e; }
    .progress-bar { border-radius: 6px; }
    .section-title { font-weight: 600; font-size: 1.2em; margin-top: 1.5rem; }
    .tool-link { text-decoration: none; font-weight: 500; }
    .tool-link.try { color: #22c55e; }
    .tool-link.report { color: #2563eb; }
    .tool-link.guide { color: #f59e42; }
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
      <img src="logo.jpg" alt="Halal Keeps Logo">
      <span class="fw-bold fs-5">Market Insights</span>
      <button class="menu-btn d-md-none" title="Menu"><span>&#9776;</span></button>
    </div>
    <div class="p-4">
      <div class="section-title mb-3"><span style="color:#2563eb;">&#128200;</span> Demand Analysis</div>
      <div class="row g-2 mb-3">
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Within 1km</div>
            <div class="stat-value stat-accent">8,500</div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Within 3km</div>
            <div class="stat-value" style="color:#0ea5e9;">16,200</div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Within 5km</div>
            <div class="stat-value" style="color:#a78bfa;">24,500</div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold mb-2">Peak Demand Times</div>
        <div class="small text-muted mb-1">Lunch (12-2 PM)</div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-success" style="width: 85%"></div>
        </div>
        <div class="small text-muted mb-1">Dinner (6-9 PM)</div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-primary" style="width: 91%"></div>
        </div>
        <div class="small text-muted mb-1">Weekend</div>
        <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-purple" style="width: 75%; background-color:#a78bfa;"></div>
        </div>
      </div>
      <div class="section-title mb-3"><span style="color:#22c55e;">&#128101;</span> Market Overview</div>
      <div class="row g-2 mb-3">
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Local Demand</div>
            <div class="stat-value stat-accent">78%</div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Avg Revenue Boost</div>
            <div class="stat-value" style="color:#16a34a;">+35%</div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-title">Market Growth</div>
            <div class="stat-value" style="color:#f59e42;">+12%</div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold mb-2">78% of consumers seek halal options</div>
        <div class="fw-semibold mb-2">+35% average revenue increase</div>
      </div>
      <div class="section-title mb-3"><span style="color:#0ea5e9;">&#128202;</span> Revenue Projection</div>
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
      <div class="section-title mb-3"><span style="color:#f59e42;">&#128295;</span> Business Tools</div>
      <div class="mb-2">
        <a href="#" class="tool-link try">Revenue Calculator <span class="small">Try now</span></a>
      </div>
      <div class="mb-2">
        <a href="#" class="tool-link report" data-bs-toggle="modal" data-bs-target="#premiumModal">
          <span style="display:inline-flex;align-items:center;">
            Market Insights
            <span style="margin-left:8px; color:#facc15; font-size:1.2em;">&#11088;</span>
          </span>
          <span class="small">View Report</span>
        </a>
      </div>
      <!-- Premium Modal -->
      <div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="premiumModalLabel">Unlock Premium Features</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3 text-center">
                <span style="font-size:2.2em; color:#facc15;">&#11088;</span>
                <div class="fw-bold mt-2 mb-2">Go Premium to Access:</div>
                <ul class="text-start" style="max-width:320px; margin:0 auto;">
                  <li><b>Revenue Projection</b></li>
                  <li><b>Demand Analysis</b></li>
                  <li><b>Growth Factors</b></li>
                </ul>
              </div>
              <div class="text-center mt-3">
                <button class="btn btn-warning w-100" disabled>Unlock Premium (Coming Soon)</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-2">
        <a href="halal_starter_pack.php" class="tool-link guide">Certification Guide <span class="small">Get Started</span></a>
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
    $('.btn, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly form handling
    $('input, select').on('focus', function() {
      $(this).addClass('ui-focus');
    }).on('blur', function() {
      $(this).removeClass('ui-focus');
    });
  });
</script>
</html> 