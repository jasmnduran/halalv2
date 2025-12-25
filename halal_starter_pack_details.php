<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halal Starter Pack Details - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .details-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .details-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .details-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .details-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .details-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 15px;
    }

    .details-card ul {
      color: #333;
      line-height: 1.7;
      padding-left: 20px;
    }

    .details-card li {
      margin-bottom: 8px;
    }

    @media (max-width: 768px) {
      .details-card {
        padding: 25px 20px;
      }

      .details-card h2, .details-card h3 {
        font-size: 1.3rem;
      }
    }
  </style>
  <style>
    .starter-details-card { background: #fff; border-left: 6px solid #219653; box-shadow: 0 2px 16px rgba(44,62,80,0.13); border-radius: 24px; padding: 36px 32px 32px 32px; max-width: 700px; margin: 0 auto 32px auto; }
    .starter-green-card { background:#219653; color:#fff; border-radius:18px; margin-bottom:28px; box-shadow:0 2px 8px rgba(44,62,80,0.08); }
    .starter-list { margin-left: 0; padding-left: 0; }
    .starter-list li { display:flex; align-items:center; margin-bottom:14px; font-size:1.09em; }
    .starter-list li span.icon { color:#2563eb; font-size:1.3em; margin-right:12px; }
    .inside-card { background:#f5fcf7; border-radius:18px; box-shadow:0 1px 6px rgba(44,62,80,0.06); padding:20px 18px; }
    .details-title { color:#219653; font-size:1.4em; font-weight:800; margin-bottom:4px; }
    .details-sub { color:#4b5563; font-size:1.08em; margin-bottom:18px; }
    .back-link { text-decoration:none; color:#219653; font-size:2rem; margin-right:18px; transition:color 0.2s; }
    .back-link:hover { color:#17643a; }
  </style>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo mb-2 mt-3" style="display:block;margin-left:auto;margin-right:auto;">
    <div class="starter-details-card">
      <div class="d-flex align-items-center mb-4">
        <a href="halal_starter_pack.php" class="back-link">&#8592;</a>
        <span class="details-title mb-0">Halal Starter Pack</span>
      </div>
      <div class="starter-green-card card mb-4">
        <div class="text-center p-4">
          <div style="font-size:2.7em; background:#fff; color:#219653; border-radius:50%; width:54px; height:54px; display:inline-flex; align-items:center; justify-content:center; margin-bottom:8px;">&#128218;</div>
          <div class="fs-4 fw-bold">Halal Starter Pack</div>
          <div>For businesses in non-Muslim majority areas</div>
        </div>
      </div>
      <div class="details-sub text-center">This comprehensive guide helps businesses implement basic halal practices even before pursuing full certification. Perfect for restaurants, cafes, and food suppliers in areas with low Muslim populations.</div>
      <ul class="starter-list mb-4">
        <li><span class="icon">&#10003;</span>Easy-to-implement guidelines</li>
        <li><span class="icon">&#10003;</span>Ingredient sourcing recommendations</li>
        <li><span class="icon">&#10003;</span>Kitchen setup to avoid cross-contamination</li>
        <li><span class="icon">&#10003;</span>Staff training materials</li>
        <li><span class="icon">&#10003;</span>Path to full certification</li>
      </ul>
      <div class="inside-card">
        <div class="fw-bold mb-2">What's Inside</div>
        <ul style="margin-bottom:0;">
          <li><a href="halal_guidelines.php" class="link">Basic Halal Guidelines</a> <span class="text-muted small">- Fundamental principles of halal food preparation and handling.</span></li>
          <li class="mt-2"><span class="fw-semibold">Halal-Friendly Designation</span> <span class="text-muted small">- How to use and display the "Halal-Friendly" badge for your business.</span></li>
          <li class="mt-2"><span class="fw-semibold">Implementation Timeline</span> <span class="text-muted small">- Steps and timeline for adopting halal practices.</span></li>
        </ul>
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
    
    // Mobile-friendly navigation
    $('a').on('click', function() {
      $.mobile.showPageLoadingMsg();
    });
  });
</script>
</html> 