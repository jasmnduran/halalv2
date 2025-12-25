<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Revenue Calculator - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .calc-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .calc-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .calc-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .calc-input {
      width: 100%;
      padding: 14px 18px;
      border: 2px solid var(--input-border);
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #fafafa;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    .calc-input:focus {
      outline: none;
      border-color: var(--primary-green);
      background: white;
      box-shadow: 0 0 0 3px rgba(13, 140, 76, 0.1);
    }

    .calc-btn {
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
      margin-bottom: 20px;
    }

    .calc-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }

    .result-card {
      background: linear-gradient(135deg, var(--light-green), #f0f8f0);
      border-radius: var(--border-radius);
      padding: 25px;
      text-align: center;
      border: 2px solid var(--primary-green);
    }

    .result-card h3 {
      color: var(--primary-green);
      font-size: 1.3rem;
      margin-bottom: 15px;
    }

    @media (max-width: 768px) {
      .calc-card {
        padding: 25px 20px;
      }

      .calc-card h2 {
        font-size: 1.3rem;
      }
    }
  </style>
  <style>
    .calc-card { background: #fff; border-left: 6px solid #219653; box-shadow: 0 2px 16px rgba(44,62,80,0.13); border-radius: 24px; padding: 36px 32px 32px 32px; max-width: 500px; margin: 32px auto; }
    .calc-label { font-weight: 600; color: #222; margin-bottom: 6px; }
    .calc-input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0; margin-bottom: 18px; font-size: 1.1em; }
    .calc-btn { width: 100%; border-radius: 8px; font-size: 1.1em; font-weight: 700; padding: 12px 0; background: #219653; color: #fff; border: none; margin-bottom: 18px; transition: background 0.2s; }
    .calc-btn:hover { background: #17643a; }
    .calc-result { background: #f5fcf7; border-radius: 12px; padding: 18px; font-size: 1.2em; color: #219653; font-weight: 700; text-align: center; margin-top: 12px; }
    .back-link { text-decoration:none; color:#219653; font-size:1.5rem; margin-right:16px; transition:color 0.2s; }
    .back-link:hover { color:#17643a; }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    function calculateRevenue(e) {
      e.preventDefault();
      var customers = parseFloat(document.getElementById('customers').value) || 0;
      var spend = parseFloat(document.getElementById('spend').value) || 0;
      var days = parseFloat(document.getElementById('days').value) || 0;
      var revenue = customers * spend * days;
      document.getElementById('result').innerHTML =
        'Estimated Monthly Revenue: <br><span style="font-size:1.3em;">₱' + revenue.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + '</span>';
    }
  </script>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo mb-2 mt-3" style="display:block;margin-left:auto;margin-right:auto;">
    <div class="calc-card">
      <div class="d-flex align-items-center mb-4">
        <a href="halal_starter_pack_details.php" class="back-link">&#8592;</a>
        <span class="details-title mb-0" style="color:#219653; font-size:1.3em; font-weight:800;">Revenue Calculator</span>
      </div>
      <form onsubmit="calculateRevenue(event)">
        <div class="calc-label">Average Daily Customers</div>
        <input type="number" id="customers" class="calc-input" min="0" placeholder="e.g. 50" required>
        <div class="calc-label">Average Spend per Customer (₱)</div>
        <input type="number" id="spend" class="calc-input" min="0" step="0.01" placeholder="e.g. 150.00" required>
        <div class="calc-label">Days Open per Month</div>
        <input type="number" id="days" class="calc-input" min="0" max="31" placeholder="e.g. 26" required>
        <button type="submit" class="calc-btn">Calculate Revenue</button>
      </form>
      <div id="result" class="calc-result"></div>
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
    $('.calc-btn, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly form handling
    $('.calc-input').on('focus', function() {
      $(this).addClass('ui-focus');
    }).on('blur', function() {
      $(this).removeClass('ui-focus');
    });
    
    // Revenue calculation
    $('form').on('submit', function(e) {
      e.preventDefault();
      var customers = parseFloat($('#customers').val()) || 0;
      var spend = parseFloat($('#spend').val()) || 0;
      var days = parseFloat($('#days').val()) || 0;
      
      if (customers > 0 && spend > 0 && days > 0) {
        var revenue = customers * spend * days;
        $('#result').html('Estimated Monthly Revenue: <br><span style="font-size:1.3em;">₱' + revenue.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + '</span>');
      } else {
        $.mobile.showPageLoadingMsg('error', 'Please fill in all fields', true);
        setTimeout(function() {
          $.mobile.hidePageLoadingMsg();
        }, 2000);
      }
    });
  });
</script>
</html> 