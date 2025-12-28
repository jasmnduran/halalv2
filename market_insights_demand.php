<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Market Insights - Demand Analysis</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .main-card { max-width: 650px; margin: 0 auto; border: none; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; }
    .geo-card {
        padding: 1rem; border-radius: 0.75rem; text-align: center; height: 100%;
        display: flex; flex-direction: column; justify-content: center;
    }
    .geo-card.green { background: #f0fdf4; color: #16a34a; }
    .geo-card.blue { background: #f0f9ff; color: #0284c7; }
    .geo-card.purple { background: #f5f3ff; color: #7c3aed; }
    .geo-val { font-size: 1.5rem; font-weight: 700; line-height: 1; margin-bottom: 0.25rem; }
    .geo-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; opacity: 0.8; }
  </style>
</head>
<body class="py-4">
  <div class="container">
    
    <div class="main-card bg-white">
      <div class="p-4 border-bottom bg-white sticky-top">
        <div class="d-flex align-items-center">
            <a href="market_insights_area.php" class="btn btn-light rounded-circle btn-sm me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h5 class="fw-bold mb-0">Detailed Demand</h5>
                <small class="text-muted"><i class="bi bi-people-fill me-1"></i>Consumer Demographics</small>
            </div>
        </div>
      </div>

      <div class="p-4">
        
        <h6 class="fw-bold text-dark mb-3">Geographic Reach</h6>
        <div class="row g-2 mb-4">
            <div class="col-4">
                <div class="geo-card green">
                    <div class="geo-val">8.5k</div>
                    <div class="geo-label">1km Radius</div>
                </div>
            </div>
            <div class="col-4">
                <div class="geo-card blue">
                    <div class="geo-val">16.2k</div>
                    <div class="geo-label">3km Radius</div>
                </div>
            </div>
            <div class="col-4">
                <div class="geo-card purple">
                    <div class="geo-val">24.5k</div>
                    <div class="geo-label">5km Radius</div>
                </div>
            </div>
        </div>

        <div class="card border-0 bg-light p-4 rounded-4">
            <h6 class="fw-bold text-dark mb-4">Peak Halal Demand Times</h6>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between small fw-bold mb-1">
                    <span>Lunch (12 PM - 2 PM)</span>
                    <span class="text-success">85% Capacity</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between small fw-bold mb-1">
                    <span>Dinner (6 PM - 9 PM)</span>
                    <span class="text-primary">91% Capacity</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 91%"></div>
                </div>
            </div>

            <div class="mb-0">
                <div class="d-flex justify-content-between small fw-bold mb-1">
                    <span>Weekends</span>
                    <span style="color: #7c3aed">75% Capacity</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar" role="progressbar" style="width: 75%; background-color: #7c3aed;"></div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Data aggregated from local search trends and foot traffic.</p>
        </div>

      </div>
    </div>
  </div>
</body>
</html>