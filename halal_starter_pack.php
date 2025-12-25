<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halal Starter Pack - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    :root {
      --primary-green: #219653;
      --primary-blue: #2563eb;
      --light-bg: #f5fcf7;
      --card-bg: #fff;
      --shadow: 0 2px 12px rgba(44, 62, 80, 0.07);
    }
    body { background: var(--light-bg); }
    .starter-container { max-width: 800px; margin: 0 auto; padding: 32px 0; }
    .logo { display: block; margin: 0 auto 18px auto; width: 90px; }
    .starter-title { color: var(--primary-green); font-weight: 800; font-size: 2.1em; text-align: center; margin-bottom: 8px; }
    .starter-desc { text-align: center; color: #444; font-size: 1.1em; margin-bottom: 32px; }
    .search-box { background: #fff; border-radius: 20px; box-shadow: var(--shadow); padding: 28px 20px 18px 20px; margin-bottom: 32px; }
    .search-input { border: none; border-radius: 12px; padding: 16px; width: 100%; font-size: 1.1em; background: var(--light-bg); margin-bottom: 16px; box-sizing: border-box; }
    .search-btn { width: 100%; border-radius: 8px; font-size: 1.1em; font-weight: 700; padding: 12px 0; background: var(--primary-blue); color: #fff; border: none; margin-bottom: 8px; transition: background 0.2s; }
    .search-btn:hover { background: #174ea6; }
    .starter-card { background: #fff; border-radius: 18px; box-shadow: var(--shadow); padding: 32px 28px; border-left: 6px solid var(--primary-green); margin-bottom: 32px; }
    .starter-card-title { color: var(--primary-green); font-size: 1.3em; font-weight: 800; margin-bottom: 2px; }
    .starter-card-desc { color: #444; font-size: 1.08em; margin-bottom: 8px; }
    .starter-learn { color: var(--primary-blue); font-weight: 700; text-decoration: underline; margin-bottom: 12px; display: inline-block; }
    .starter-list { list-style: none; padding-left: 0; margin-bottom: 0; }
    .starter-list li { display: flex; align-items: center; margin-bottom: 12px; font-size: 1.08em; }
    .starter-list li .icon { color: var(--primary-green); font-size: 1.2em; margin-right: 10px; }
    .success-title { color: var(--primary-green); font-weight: 700; font-size: 1.2em; margin-top: 18px; margin-bottom: 6px; }
    .success-desc { color: #666; }
    .btn-back { margin-bottom: 18px; font-weight: 600; border-radius: 8px; border: 1.5px solid var(--primary-green); color: var(--primary-green); background: #fff; transition: background 0.2s, color 0.2s; }
    .btn-back:hover { background: var(--primary-green); color: #fff; }
  </style>
</head>
<body>
  <div class="starter-container">
    <a href="owner_dashboard.php" class="btn btn-back">&larr; Back to Dashboard</a>
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo">
    <div class="starter-title">Discover Halal Practices</div>
    <div class="starter-desc">Learn about Halal standards and connect with verified Halal businesses in your area.</div>
    <div class="search-box">
      <form class="mb-2" style="margin-bottom:0;">
        <input type="text" class="search-input" placeholder="Search for halal resources...">
        <button type="submit" class="search-btn">Search</button>
      </form>
    </div>
    <div class="starter-card">
      <div class="starter-card-title">Halal Starter Pack</div>
      <div class="starter-card-desc">Get our comprehensive guide for businesses in non-Muslim areas</div>
      <a href="halal_starter_pack_details.php" class="starter-learn">Learn More</a>
      <ul class="starter-list mt-3">
        <li><span class="icon">&#10003;</span>Easy-to-implement guidelines</li>
        <li><span class="icon">&#10003;</span>Ingredient sourcing recommendations</li>
        <li><span class="icon">&#10003;</span>Kitchen setup to avoid cross-contamination</li>
        <li><span class="icon">&#10003;</span>Staff training materials</li>
      </ul>
    </div>
    <div class="success-title">Success Stories</div>
    <div class="success-desc">Coming soon: See how other businesses have benefited from the Halal Starter Pack.</div>
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
    $('.search-btn, .btn').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly search
    $('.search-input').on('focus', function() {
      $(this).addClass('ui-focus');
    }).on('blur', function() {
      $(this).removeClass('ui-focus');
    });
    
    // Search functionality
    $('.search-btn').on('click', function() {
      var searchTerm = $('.search-input').val();
      if (searchTerm) {
        $.mobile.showPageLoadingMsg();
        // Simulate search - replace with actual search logic
        setTimeout(function() {
          $.mobile.hidePageLoadingMsg();
          alert('Searching for: ' + searchTerm);
        }, 1000);
      }
    });
  });
</script>
</html> 