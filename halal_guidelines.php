<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basic Halal Guidelines - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .guideline-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .guideline-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .guideline-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .guideline-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 15px;
    }

    .guideline-card ul {
      color: #333;
      line-height: 1.7;
      padding-left: 20px;
    }

    .guideline-card li {
      margin-bottom: 8px;
    }

    .back-btn {
      text-align: center;
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .guideline-card {
        padding: 25px 20px;
      }

      .guideline-card h2 {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo mb-2 mt-3" style="display:block;margin-left:auto;margin-right:auto;">
    <div class="starter-details-card" style="box-shadow:0 2px 12px rgba(44,62,80,0.10); border-left:6px solid #219653; padding:32px 28px 28px 28px;">
      <div class="d-flex align-items-center mb-4">
        <a href="halal_starter_pack_details.php" style="text-decoration:none; color:#219653; font-size:2rem; margin-right:16px;">&#8592;</a>
        <h1 class="h4 fw-bold mb-0" style="color:#219653; font-size:1.5em;">Basic Halal Guidelines</h1>
      </div>
      <div class="card mb-4" style="background:#f5fcf7; border-radius:18px;">
        <div class="fw-bold mb-2" style="font-size:1.12em;">These fundamental guidelines will help your business become Halal-Friendly, even before pursuing full certification.</div>
        <ul class="starter-list mb-3">
          <li style="font-size:1.07em;">What is Halal?</li>
          <li style="font-size:1.07em;">Prohibited Ingredients</li>
          <li style="font-size:1.07em;">Kitchen Setup Basics</li>
          <li style="font-size:1.07em;">Staff Training Essentials</li>
          <li style="font-size:1.07em;">Menu Development</li>
        </ul>
        <div class="card mb-3" style="background:#e9f7ef; border-radius:14px;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span style="color:#219653;font-size:1.5em;">&#9432;</span>
            <span class="fw-semibold">Halal-Friendly Designation</span>
          </div>
          <div class="text-muted small mb-2">
            Businesses that implement these basic guidelines can apply for a Halal-Friendly designation on the Halal Keeps platform. This makes it easier to connect with halal-seeking customers. If you are fully certified, you make efforts to accommodate Halal dietary needs.
          </div>
        </div>
        <div class="text-center mt-3">
          <a href="#" class="btn btn-success" style="font-size:1.15em; min-width:240px; padding:14px 0; font-weight:600; border-radius:8px; transition:background 0.2s;">&#128190; Download Full Guidelines</a>
        </div>
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
    
    // Mobile-friendly enhancements
    $('.btn').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Smooth scrolling for mobile
    $('a[href^="#"]').on('click', function(e) {
      e.preventDefault();
      var target = $(this.getAttribute('href'));
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 500);
      }
    });
  });
</script>
</html> 