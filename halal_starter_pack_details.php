<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halal Starter Pack Details - Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-green: #0d8c4c;
      --secondary-green: #16a765;
      --light-green: #e8f5e9;
      --bs-body-bg: #f5fcf7;
      --bs-font-sans-serif: 'Inter', sans-serif;
    }
    body { background-color: var(--bs-body-bg); }

    .details-container { max-width: 800px; margin: 0 auto; }

    .hero-card {
        background: linear-gradient(135deg, var(--primary-green), #0a6d3a);
        color: white;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(13, 140, 76, 0.2);
    }

    .content-card {
        background: white;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-left: 6px solid var(--primary-green);
    }

    .feature-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light-green);
        color: var(--primary-green);
        border-radius: 50%;
        margin-right: 12px;
    }
  </style>
</head>
<body class="py-4">
  <div class="container details-container">
    
    <div class="mb-4">
        <a href="halal_starter_pack.php" class="btn btn-outline-success btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Overview
        </a>
    </div>

    <div class="text-center mb-4">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border mb-3" width="72" height="72">
    </div>

    <div class="hero-card p-4 p-md-5 text-center mb-4">
        <div class="bg-white text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 64px; height: 64px;">
            <i class="bi bi-book-half fs-2"></i>
        </div>
        <h1 class="fw-bold mb-2">Halal Starter Pack</h1>
        <p class="lead mb-0 opacity-90">For businesses in non-Muslim majority areas</p>
    </div>

    <div class="content-card p-4 mb-4">
        <p class="text-muted lead fs-6 mb-4">
            This comprehensive guide helps businesses implement basic halal practices even before pursuing full certification. 
            Perfect for restaurants, cafes, and food suppliers in areas with low Muslim populations.
        </p>
        
        <h5 class="fw-bold text-dark mb-3">What You Get</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                    <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                    <span>Easy-to-implement guidelines</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                    <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                    <span>Ingredient sourcing recommendations</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                    <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                    <span>Kitchen setup protocols</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                    <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                    <span>Staff training materials</span>
                </div>
            </div>
        </div>

        <div class="card bg-success bg-opacity-10 border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-success mb-3"><i class="bi bi-folder2-open me-2"></i>What's Inside</h5>
                <div class="list-group list-group-flush bg-transparent">
                    <a href="halal_guidelines.php" class="list-group-item bg-transparent border-success border-opacity-25 px-0 d-flex flex-column flex-sm-row align-items-start gap-2">
                        <i class="bi bi-file-earmark-text text-success mt-1"></i>
                        <div>
                            <span class="fw-bold text-dark text-decoration-underline">Basic Halal Guidelines</span>
                            <p class="small text-muted mb-0">Fundamental principles of halal food preparation and handling.</p>
                        </div>
                    </a>
                    <div class="list-group-item bg-transparent border-success border-opacity-25 px-0 d-flex flex-column flex-sm-row align-items-start gap-2">
                        <i class="bi bi-award text-success mt-1"></i>
                        <div>
                            <span class="fw-bold text-dark">Halal-Friendly Designation</span>
                            <p class="small text-muted mb-0">How to use and display the "Halal-Friendly" badge for your business.</p>
                        </div>
                    </div>
                    <div class="list-group-item bg-transparent border-0 px-0 d-flex flex-column flex-sm-row align-items-start gap-2">
                        <i class="bi bi-calendar-check text-success mt-1"></i>
                        <div>
                            <span class="fw-bold text-dark">Implementation Timeline</span>
                            <p class="small text-muted mb-0">Steps and timeline for adopting halal practices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>