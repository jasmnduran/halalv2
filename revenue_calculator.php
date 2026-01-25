<?php
// halalv2/revenue_calculator.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Revenue Calculator - Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5fcf7; font-family: sans-serif; }
    .calc-card { 
        background: #fff; 
        border-left: 6px solid #219653; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
        border-radius: 16px; 
        padding: 40px; 
        max-width: 500px; 
        margin: 50px auto; 
    }
    .calc-label { font-weight: 600; color: #444; margin-bottom: 8px; }
    .calc-input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px; }
    .calc-btn { 
        width: 100%; padding: 12px; 
        background: #219653; color: white; 
        border: none; border-radius: 8px; font-weight: bold; 
        transition: background 0.2s;
    }
    .calc-btn:hover { background: #196f3d; }
    .calc-result { 
        margin-top: 20px; padding: 20px; 
        background: #e8f5e9; border-radius: 8px; 
        text-align: center; color: #219653; font-weight: bold; font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="calc-card">
      <div class="d-flex align-items-center mb-4">
        <a href="owner_dashboard.php" class="text-decoration-none text-success fs-4 me-3">&larr;</a>
        <h4 class="mb-0 fw-bold text-success">Revenue Calculator</h4>
      </div>
      
      <form id="calcForm">
        <div class="calc-label">Avg. Daily Customers</div>
        <input type="number" id="customers" class="calc-input" placeholder="e.g. 50" required min="1">
        
        <div class="calc-label">Avg. Spend per Customer (₱)</div>
        <input type="number" id="spend" class="calc-input" placeholder="e.g. 150" required min="1">
        
        <div class="calc-label">Days Open per Month</div>
        <input type="number" id="days" class="calc-input" placeholder="e.g. 26" required max="31" min="1">
        
        <button type="submit" class="calc-btn">Calculate Potential</button>
      </form>
      
      <div id="result" class="calc-result" style="display:none;"></div>
    </div>
  </div>

  <script>
    document.getElementById('calcForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const customers = parseFloat(document.getElementById('customers').value) || 0;
      const spend = parseFloat(document.getElementById('spend').value) || 0;
      const days = parseFloat(document.getElementById('days').value) || 0;
      
      const revenue = customers * spend * days;
      const resultDiv = document.getElementById('result');
      
      resultDiv.style.display = 'block';
      resultDiv.innerHTML = `
        <small class="text-muted text-uppercase">Estimated Monthly Revenue</small><br>
        ₱${revenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
      `;
    });
  </script>
</body>
</html>