<?php
// ---------------------------------------------------------
// MOCKED LOGIC (Originally from owner_dashboard_logic.php)
// Embedded here to ensure the file is standalone and runnable.
// ---------------------------------------------------------

// Simulate Session for the demo
if (!isset($_SESSION)) {
    session_start();
}

// Fallback/Sample Data
$owner = [
    'name' => 'Demo Owner',
    'location' => 'Davao City, Philippines',
    'profile_views' => 123,
    'rating' => 4.7,
    'market_score' => 85,
    'muslim_population' => 250000,
    'competition' => 12,
    'market_insight' => 'High demand for Halal-certified food in this area.',
    'certificate_status' => 'Valid',
    'certificate_expiry' => '2025-12-31',
    'halal_rating' => 5,
    'total_reviews' => 34,
    'unresolved_claims' => 1,
    'recent_feedback' => 'Great service and authentic food!',
    'premium' => false, // Set to true to see the unblurred analytics
    'starter_pack_progress' => 60,
    'modules' => [
        ['name' => 'Business Registration', 'complete' => true],
        ['name' => 'Halal Certification', 'complete' => false],
        ['name' => 'Menu Upload', 'complete' => true],
        ['name' => 'Staff Training', 'complete' => false],
    ],
    'activity_feed' => [
        'Responded to a customer review',
        'Updated business hours',
        'Uploaded new menu items',
    ],
];

// If session exists, override (simulating the real app behavior)
if (isset($_SESSION['owner']) && !empty($_SESSION['owner'])) {
    $owner = array_merge($owner, $_SESSION['owner']);
}

$analytics = [
    'daily' => 45,
    'monthly' => 1200,
    'yearly' => 14000,
    'peak_hours' => '12:00 PM - 2:00 PM',
    'retention' => '78%',
    'referral' => '22%',
    'growth' => '+12% YoY',
    'recommendations' => 'Offer lunch promos to boost weekday sales.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Dashboard - Halal Keeps</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Ported from style.css */
            --primary-green: #0d8c4c;
            --secondary-green: #16a765;
            --light-green: #e8f5e9;
            --card-bg: #ffffff;
            --bs-body-bg: #f6f8fa;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
        }

        /* Branding Overrides */
        .text-brand { color: var(--primary-green) !important; }
        .bg-brand { background-color: var(--primary-green) !important; }
        .border-brand { border-color: var(--primary-green) !important; }
        .btn-brand {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
            box-shadow: 0 4px 6px rgba(13, 140, 76, 0.2);
            transition: all 0.2s;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(13, 140, 76, 0.3);
        }

        /* Card Styling */
        .dashboard-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            background: var(--card-bg);
            border-top: 4px solid transparent; /* Placeholder for hover effect */
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-top-color: var(--primary-green);
        }

        /* Premium Blur Effect */
        .premium-blur-container { position: relative; overflow: hidden; }
        .premium-blur-content { filter: blur(6px); user-select: none; pointer-events: none; opacity: 0.7; }
        .premium-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(2px);
        }
        .premium-badge {
            background: #facc15;
            color: #fff;
            padding: 0.25rem 0.6rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Modules List */
        .module-item {
            transition: background-color 0.2s;
        }
        .module-item.completed {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        .module-item.pending {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        /* Promo Card UI (from original inline styles) */
        .promo-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary-green);
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.2s;
        }
        .promo-card:hover { transform: scale(1.01); }
        .promo-img {
            width: 72px; height: 72px;
            object-fit: cover;
            border-radius: 0.75rem;
            background: #f8f9fa;
        }
    </style>
</head>
<body class="py-4">
    <div class="container">
        
        <header class="dashboard-card p-4 mb-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3 w-100">
                <div class="position-relative">
                    <img src="logo.jpg" alt="Logo" class="rounded-circle border border-2 border-brand p-1" style="width: 64px; height: 64px; object-fit: cover;">
                </div>
                <div>
                    <h1 class="h4 fw-bold text-dark mb-1">
                        Welcome, <?= htmlspecialchars($owner['name'] ?? '') ?>
                        <a href="edit_profile_owner.php" class="text-brand ms-2" title="Edit Profile">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </h1>
                    <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                        <i class="bi bi-geo-alt-fill text-brand"></i>
                        <?= htmlspecialchars($owner['location'] ?? '') ?>
                    </div>
                    <a href="business_profile_builder.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-building-add me-1"></i> Build Profile
                    </a>
                </div>
            </div>
            
            <div class="d-flex flex-column align-items-end gap-2 w-100 w-md-auto">
                <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-md-end">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-eye me-1"></i> <?= htmlspecialchars($owner['profile_views'] ?? '') ?> Views
                    </span>
                    <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-star-fill me-1"></i> <?= htmlspecialchars($owner['rating'] ?? '') ?>/5
                    </span>
                </div>
                <a href="welcome.php" class="btn btn-outline-danger btn-sm px-4 rounded-pill mt-1">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </header>

        <div class="mb-4">
            <?php if (isset($_GET['submitted']) && $_GET['submitted'] == '1'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-5 border-success rounded-3" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                        <div>
                            <strong>Application Submitted!</strong> Your Halal Certification application is under review.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="alert alert-info border-0 border-start border-5 border-info shadow-sm rounded-3 d-flex align-items-center gap-3" role="alert">
                <div class="bg-info bg-opacity-25 p-2 rounded-circle text-info-emphasis">
                    <i class="bi bi-chat-quote-fill fs-5"></i>
                </div>
                <div>
                    New review received! <a href="#" class="alert-link">View feedback</a>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6">
                <div class="dashboard-card p-4">
                    <h2 class="h5 fw-bold text-dark mb-3">Halal Market Potential</h2>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="display-6 fw-bold"><?= htmlspecialchars($owner['market_score'] ?? '') ?></span>
                        </div>
                        <div>
                            <div class="text-uppercase text-muted small fw-bold tracking-wide">Market Score</div>
                            <div class="text-muted small">Based on population & competition</div>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-3">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><i class="bi bi-people me-2"></i>Muslim Population</span>
                            <span class="fw-semibold"><?= htmlspecialchars(number_format($owner['muslim_population'] ?? 0)) ?></span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><i class="bi bi-shop me-2"></i>Nearby Competitors</span>
                            <span class="fw-semibold"><?= htmlspecialchars($owner['competition'] ?? '') ?></span>
                        </li>
                    </ul>
                    
                    <div class="alert alert-light border border-secondary border-opacity-10 rounded-3 mb-0">
                        <i class="bi bi-lightbulb-fill text-warning me-2"></i>
                        <span class="small fw-medium"><?= htmlspecialchars($owner['market_insight'] ?? '') ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-card p-4">
                    <h2 class="h5 fw-bold text-dark mb-3">Halal Status Tracking</h2>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="badge bg-success bg-opacity-10 text-success fs-6 fw-normal px-3 py-2 border border-success border-opacity-25">
                            <i class="bi bi-patch-check-fill me-1"></i> Valid
                        </div>
                        <span class="text-muted small">Expires: <?= htmlspecialchars($owner['certificate_expiry'] ?? '') ?></span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center h-100">
                                <div class="text-warning fw-bold fs-4 mb-1">
                                    <?= htmlspecialchars($owner['halal_rating'] ?? '') ?><span class="fs-6 text-muted">/5</span>
                                </div>
                                <div class="small text-muted">Halal Rating</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center h-100">
                                <div class="text-dark fw-bold fs-4 mb-1">
                                    <?= htmlspecialchars($owner['total_reviews'] ?? '') ?>
                                </div>
                                <div class="small text-muted">Total Reviews</div>
                            </div>
                        </div>
                    </div>

                    <?php if (($owner['unresolved_claims'] ?? 0) > 0): ?>
                        <div class="d-flex align-items-center justify-content-between p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3 mb-3">
                            <div class="text-danger fw-semibold">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= htmlspecialchars($owner['unresolved_claims']) ?> Unresolved Claim(s)
                            </div>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#claimsModal" onclick="loadClaimsReview(event)">Resolve</button>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2">
                        <a href="certification_progress.php<?= isset($_GET['id']) ? '?id='.htmlspecialchars($_GET['id']) : '' ?>" class="btn btn-brand">
                            <i class="bi bi-file-earmark-text me-2"></i> View Certification Progress
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-card p-4 mb-4 <?= !($owner['premium'] ?? false) ? 'premium-blur-container' : '' ?>">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="h5 fw-bold text-dark mb-0">Business Analytics</h2>
                <span class="premium-badge">Premium</span>
            </div>

            <div class="<?= !($owner['premium'] ?? false) ? 'premium-blur-content' : '' ?>">
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-success bg-opacity-10 text-center border border-success border-opacity-10">
                            <div class="display-6 fw-bold text-success mb-1"><?= htmlspecialchars($analytics['daily'] ?? '') ?></div>
                            <div class="text-muted small">Avg. Daily Muslim Customers</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-primary bg-opacity-10 text-center border border-primary border-opacity-10">
                            <div class="display-6 fw-bold text-primary mb-1"><?= htmlspecialchars($analytics['monthly'] ?? '') ?></div>
                            <div class="text-muted small">Monthly Muslim Customers</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-warning bg-opacity-10 text-center border border-warning border-opacity-10">
                            <div class="display-6 fw-bold text-warning mb-1"><?= htmlspecialchars($analytics['yearly'] ?? '') ?></div>
                            <div class="text-muted small">Yearly Projection</div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Performance Metrics</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Peak Hours</span>
                                <span class="fw-semibold text-dark"><?= htmlspecialchars($analytics['peak_hours'] ?? '') ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Customer Retention</span>
                                <span class="fw-semibold text-primary"><?= htmlspecialchars($analytics['retention'] ?? '') ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>YoY Growth</span>
                                <span class="fw-semibold text-success"><?= htmlspecialchars($analytics['growth'] ?? '') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">AI Recommendations</h6>
                        <div class="p-3 bg-light rounded-3 border">
                            <i class="bi bi-stars text-warning me-2"></i>
                            <span class="fst-italic text-muted"><?= htmlspecialchars($analytics['recommendations'] ?? '') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!($owner['premium'] ?? false)): ?>
                <div class="premium-overlay rounded-4">
                    <div class="bg-white p-4 rounded-4 shadow-lg text-center border-top border-4 border-warning" style="max-width: 400px;">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-lock-fill display-4"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Unlock Premium Insights</h4>
                        <p class="text-muted mb-4 small">Upgrade your plan to access detailed analytics, customer demographics, and AI-driven growth recommendations.</p>
                        <a href="#" class="btn btn-warning fw-bold w-100 text-dark">Upgrade Now</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-7">
                <div class="dashboard-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 fw-bold text-dark mb-0">
                            <a href="halal_starter_pack.php" class="text-decoration-none text-dark hover-text-brand">Halal Starter Pack</a>
                        </h2>
                        <span class="badge bg-secondary"><?= htmlspecialchars($owner['starter_pack_progress'] ?? '') ?>% Done</span>
                    </div>

                    <div class="progress mb-4" style="height: 10px;">
                        <div class="progress-bar bg-brand" role="progressbar" style="width: <?= htmlspecialchars($owner['starter_pack_progress'] ?? '') ?>%"></div>
                    </div>

                    <div class="row g-3">
                        <?php foreach (($owner['modules'] ?? []) as $mod): ?>
                            <div class="col-md-6">
                                <div class="module-item p-3 rounded-3 border <?= ($mod['complete'] ?? false) ? 'completed border-success border-opacity-25' : 'pending border-light' ?> d-flex align-items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <?php if ($mod['complete'] ?? false): ?>
                                            <i class="bi bi-check-circle-fill fs-5"></i>
                                        <?php else: ?>
                                            <i class="bi bi-circle fs-5 text-muted"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="fw-medium small"><?= htmlspecialchars($mod['name'] ?? '') ?></span>
                                        <?php if (!($mod['complete'] ?? false)): ?>
                                            <a href="#" class="text-brand text-decoration-none small fw-bold mt-1">Continue &rarr;</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="dashboard-card p-4 h-100">
                    <h2 class="h5 fw-bold text-dark mb-3">Quick Actions</h2>
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-success py-2 text-start px-3 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addPromoModal">
                            <i class="bi bi-plus-circle-fill me-3 fs-5"></i>
                            <span>Add Menu / Promo</span>
                        </button>
                        <a href="applicant.html" class="btn btn-outline-warning text-dark py-2 text-start px-3 d-flex align-items-center">
                            <i class="bi bi-award-fill me-3 fs-5"></i>
                            <span>Start Halal Certification</span>
                        </a>
                        <a href="#" class="btn btn-outline-primary py-2 text-start px-3 d-flex align-items-center">
                            <i class="bi bi-chat-left-text-fill me-3 fs-5"></i>
                            <span>Respond to Reviews</span>
                        </a>
                    </div>

                    <h6 class="fw-bold mt-4 mb-3">Recent Activity</h6>
                    <div class="border-start border-2 ps-3 border-secondary border-opacity-25">
                        <?php foreach (($owner['activity_feed'] ?? []) as $act): ?>
                            <div class="mb-3 position-relative">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-white" style="left: -17px; width: 10px; height: 10px; border-radius: 50%; border: 2px solid #adb5bd;"></div>
                                <p class="text-muted small mb-0"><?= htmlspecialchars($act ?? '') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="dashboard-card p-4">
                    <h5 class="fw-bold text-brand mb-3">Current Active Promos</h5>
                    <div id="promoList">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPromoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Promo/Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="promoForm">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Menu Name</label>
                            <input type="text" name="promo_name" class="form-control" placeholder="e.g. Chicken Biryani Special" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Describe the dish..." required></textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Price (PHP)</label>
                                <input type="text" name="price" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Date</label>
                                <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Upload Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-brand py-2">Publish Menu Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="claimsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold text-danger">Unresolved Claims</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="claimsModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-brand" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3 small">Fetching details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resolvedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg text-center p-3">
                <div class="modal-body">
                    <div class="mb-2 text-success">
                        <i class="bi bi-check-circle-fill display-1"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Claim Resolved</h5>
                    <button type="button" class="btn btn-success w-100 rounded-pill" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // 1. Claims Logic
        function loadClaimsReview(e) {
            e.preventDefault();
            // In a real app, this would fetch 'claims_review.php'
            // For this standalone demo, we mock the response:
            setTimeout(() => {
                const mockContent = `
                    <div class="card border-0 bg-light p-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 text-danger"><i class="bi bi-flag-fill fs-4"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Customer Claim #1024</h6>
                                <p class="text-muted small mb-2">"The chicken served was not cooked separately from non-halal items."</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-success" onclick="showClaimResolvedModal()">Accept & Resolve</button>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('claimsModalBody').innerHTML = mockContent;
            }, 500);
        }

        function showClaimResolvedModal() {
            const claimsModalEl = document.getElementById('claimsModal');
            const claimsModal = bootstrap.Modal.getInstance(claimsModalEl);
            claimsModal.hide();

            const resolvedModal = new bootstrap.Modal(document.getElementById('resolvedModal'));
            resolvedModal.show();
        }

        // Reload page after resolving to update stats (Mock behavior)
        document.getElementById('resolvedModal').addEventListener('hidden.bs.modal', function() {
            window.location.reload();
        });


        // 2. Promo/Menu Logic (Local Storage Mock)
        function getPromos() {
            return JSON.parse(localStorage.getItem('halal_promos') || '[]');
        }

        function setPromos(promos) {
            localStorage.setItem('halal_promos', JSON.stringify(promos));
        }

        function renderPromos() {
            const promos = getPromos();
            const list = document.getElementById('promoList');
            
            if (!promos.length) {
                list.innerHTML = `
                    <div class="text-center py-4 text-muted border border-dashed rounded-3">
                        <i class="bi bi-basket3 fs-3 d-block mb-2 opacity-50"></i>
                        No active promos. Add one to boost sales!
                    </div>`;
                return;
            }

            list.innerHTML = promos.map(p => `
                <div class="promo-card d-flex align-items-center gap-3">
                    <img src="${p.image || 'logo.jpg'}" alt="Food" class="promo-img border">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="fw-bold text-dark mb-0">${p.promo_name}</h6>
                            <span class="badge bg-success bg-opacity-10 text-success">${p.price}</span>
                        </div>
                        <small class="text-muted d-block mb-1">${p.date}</small>
                        <p class="text-secondary small mb-0 text-truncate" style="max-width: 300px;">${p.description}</p>
                    </div>
                    <button class="btn btn-sm btn-light text-danger" onclick="deletePromo('${p.promo_name}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `).join('');
        }

        // Add Promo Handler
        document.getElementById('promoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const newPromo = {
                promo_name: formData.get('promo_name'),
                description: formData.get('description'),
                price: formData.get('price'),
                date: formData.get('date'),
                image: 'logo.jpg' // Mock image
            };

            const promos = getPromos();
            promos.push(newPromo);
            setPromos(promos);
            
            renderPromos();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('addPromoModal'));
            modal.hide();
            e.target.reset();
        });

        // Helper to delete for demo
        window.deletePromo = function(name) {
            let promos = getPromos();
            promos = promos.filter(p => p.promo_name !== name);
            setPromos(promos);
            renderPromos();
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', renderPromos);
    </script>
</body>
</html>