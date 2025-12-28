<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Market Insights - Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .insights-container { max-width: 800px; margin: 0 auto; }
    
    .main-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .stat-card {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
        height: 100%;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-2px); border-color: #cbd5e1; }
    
    .stat-title { font-size: 0.85rem; color: #64748b; font-weight: 500; text-transform: uppercase; }
    .stat-value { font-size: 1.5rem; font-weight: 700; margin-top: 0.25rem; }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tool-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    
    .tool-btn.try { background: #f0fdf4; color: #16a34a; border-color: #dcfce7; }
    .tool-btn.try:hover { background: #dcfce7; }
    
    .tool-btn.report { background: #eff6ff; color: #2563eb; border-color: #dbeafe; }
    .tool-btn.report:hover { background: #dbeafe; }
    
    .tool-btn.guide { background: #fff7ed; color: #ea580c; border-color: #ffedd5; }
    .tool-btn.guide:hover { background: #ffedd5; }

    /* Custom Progress Colors */
    .bg-purple { background-color: #a855f7 !important; }
  </style>
</head>
<body class="py-4">
  <div class="container insights-container">
    
    <div class="d-flex align-items-center mb-4">
        <a href="owner_dashboard.php" class="btn btn-light rounded-circle shadow-sm me-3" title="Back">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="d-flex align-items-center gap-3">
            <img src="logo.jpg" alt="Logo" class="rounded-circle border" width="48" height="48">
            <div>
                <h4 class="mb-0 fw-bold">Market Insights</h4>
                <small class="text-muted">Analytics for your business area</small>
            </div>
        </div>
    </div>

    <div class="card main-card">
      <div class="card-body p-4">
        
        <div class="mb-4">
            <div class="section-title"><i class="bi bi-graph-up-arrow text-primary"></i> Demand Analysis</div>
            <div class="row g-3 mb-4">
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">1km Radius</div>
                        <div class="stat-value text-success">8,500</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">3km Radius</div>
                        <div class="stat-value text-primary">16.2k</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">5km Radius</div>
                        <div class="stat-value text-purple" style="color: #a855f7;">24.5k</div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 border">
                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Peak Demand Times</h6>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Lunch (12-2 PM)</span>
                        <span class="fw-bold">85%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Dinner (6-9 PM)</span>
                        <span class="fw-bold">91%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 91%"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Weekend</span>
                        <span class="fw-bold">75%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-purple" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4 opacity-10">

        <div class="mb-4">
            <div class="section-title"><i class="bi bi-people-fill text-success"></i> Market Potential</div>
            <div class="row g-3 mb-3">
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">Local Demand</div>
                        <div class="stat-value text-success">78%</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">Rev. Boost</div>
                        <div class="stat-value text-success">+35%</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-title">Growth</div>
                        <div class="stat-value text-warning">+12%</div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-success bg-opacity-10 border-success border-opacity-25 d-flex align-items-center gap-2 mb-0">
                <i class="bi bi-check-circle-fill text-success"></i>
                <small class="fw-medium text-success-emphasis">78% of local consumers actively seek Halal options.</small>
            </div>
        </div>

        <hr class="my-4 opacity-10">

        <div class="mb-4">
            <div class="section-title"><i class="bi bi-currency-dollar text-warning"></i> Revenue Projection</div>
            <div class="p-3 rounded-3 border bg-white shadow-sm">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Current Avg (Non-Halal)</span>
                    <span class="fw-semibold">₱45,000/mo</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Projected (With Halal)</span>
                    <span class="fw-bold text-success">₱61,000/mo</span>
                </div>
                <div class="p-2 bg-light rounded text-center border border-dashed">
                    <small class="text-muted text-uppercase fw-bold">Projected Annual Increase</small>
                    <div class="fs-4 fw-bold text-primary">+₱192,000</div>
                </div>
            </div>
            
            <div class="mt-3">
                <h6 class="fw-bold small mb-2">Key Growth Factors</h6>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item px-0 py-1 border-0"><i class="bi bi-dot text-primary me-1"></i> 25% increase in customer base</li>
                    <li class="list-group-item px-0 py-1 border-0"><i class="bi bi-dot text-primary me-1"></i> 10% premium pricing capability</li>
                    <li class="list-group-item px-0 py-1 border-0"><i class="bi bi-dot text-primary me-1"></i> Higher customer retention rate</li>
                </ul>
            </div>
        </div>

        <hr class="my-4 opacity-10">

        <div>
            <div class="section-title"><i class="bi bi-tools text-secondary"></i> Business Tools</div>
            <div class="d-grid gap-2">
                <a href="#" class="tool-btn try">
                    <span><i class="bi bi-calculator me-2"></i> Revenue Calculator</span>
                    <span class="badge bg-success bg-opacity-25 text-success rounded-pill">Try Now</span>
                </a>
                <a href="#" class="tool-btn report" data-bs-toggle="modal" data-bs-target="#premiumModal">
                    <span><i class="bi bi-file-earmark-bar-graph me-2"></i> Full Market Report</span>
                    <i class="bi bi-lock-fill text-muted"></i>
                </a>
                <a href="halal_starter_pack.php" class="tool-btn guide">
                    <span><i class="bi bi-book me-2"></i> Certification Guide</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="premiumModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-lg text-center">
        <div class="modal-body p-5">
            <div class="mb-3 text-warning">
                <i class="bi bi-star-fill display-1"></i>
            </div>
            <h3 class="fw-bold mb-2">Unlock Premium Insights</h3>
            <p class="text-muted mb-4">Get access to detailed demographic data, competitor analysis, and AI-driven growth strategies.</p>
            
            <ul class="list-unstyled text-start bg-light p-3 rounded-3 mb-4 d-inline-block w-100">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Detailed Revenue Projections</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Competitor Heatmaps</li>
                <li class="mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i> Customer Demographics</li>
            </ul>

            <button class="btn btn-warning w-100 py-2 fw-bold" disabled>Unlock Premium (Coming Soon)</button>
            <button class="btn btn-link text-muted mt-2 text-decoration-none" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>