<?php
// ---------------------------------------------------------
// LOGIC (Originally from customer_dashboard.php)
// Embedded here to ensure the file is standalone and runnable.
// ---------------------------------------------------------

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Mock user if not logged in (for demo purposes)
if (!$user) {
    $user = [
        'name' => 'Demo User',
        'first_name' => 'Demo',
        'city' => 'Davao City',
        'profile_views' => 15,
        'rating' => 5.0
    ];
}

// Mock Database of Reviews (Simulating reviews.json)
$reviews = [
    [
        'business' => 'Seafood Paradise',
        'rating' => 5,
        'review' => 'Amazing fresh seafood! Highly recommended for family dinners.',
        'reviewer' => 'Jane Doe',
        'date' => '2024-01-15 12:30:00',
        'visibility' => 'public'
    ],
    [
        'business' => 'Seafood Paradise',
        'rating' => 4,
        'review' => 'Great ambiance, but the waiting time was a bit long on weekends.',
        'reviewer' => 'John Smith',
        'date' => '2024-01-20 19:15:00',
        'visibility' => 'public'
    ],
    [
        'business' => 'Halal Kitchen',
        'rating' => 4,
        'review' => 'Good food but waiting time was a bit long.',
        'reviewer' => 'Anonymous',
        'date' => '2024-02-10 18:45:00',
        'visibility' => 'anonymous'
    ],
    [
        'business' => 'Al-Amin Restaurant',
        'rating' => 5,
        'review' => 'The best chicken biryani in town! Authentic taste.',
        'reviewer' => 'Fatima',
        'date' => '2024-03-05 13:00:00',
        'visibility' => 'public'
    ]
];

// Handle review deletion (Mock)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review_id'])) {
    // In a real app, delete from JSON/DB here
    header('Location: customer_dashboard.php');
    exit;
}

// Handle review edit/submit (Mock)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['business'], $_POST['rating'], $_POST['review'])) {
    // In a real app, save to JSON/DB here
    header('Location: customer_dashboard.php');
    exit;
}

// Prepare user reviews for the header section
$userReviews = array_filter($reviews, function($r) use ($user) {
    if (!$user) return false;
    $first = $user['first_name'] ?? '';
    $full = $user['name'] ?? '';
    if ($r['reviewer'] === 'Anonymous' && ($first === 'Anonymous' || $full === 'Anonymous')) return true;
    return ($r['reviewer'] === $first || $r['reviewer'] === $full);
});

// Helper for stars
function renderStars($rating) {
    $full = str_repeat('<i class="bi bi-star-fill"></i>', $rating);
    $empty = str_repeat('<i class="bi bi-star"></i>', 5 - $rating);
    return '<span class="text-warning small">' . $full . $empty . '</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Halal Keeps</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
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

        /* Branding Utilities */
        .text-brand { color: var(--primary-green) !important; }
        .bg-brand { background-color: var(--primary-green) !important; }
        .border-brand { border-color: var(--primary-green) !important; }
        
        .btn-brand {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
            box-shadow: 0 4px 6px rgba(13, 140, 76, 0.2);
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(13, 140, 76, 0.3);
        }

        /* Dashboard Card */
        .dashboard-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            background: var(--card-bg);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        /* Restaurant Card Specifics */
        .rest-card-img {
            height: 140px;
            width: 100%;
            object-fit: cover;
            border-radius: 0.75rem;
            background-color: #f1f3f5;
        }
        .badge-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Review Item */
        .review-item {
            border-left: 4px solid var(--primary-green);
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 1rem;
        }

        /* Search Bar */
        .search-container {
            position: relative;
        }
        .search-input {
            border-radius: 50px;
            padding-left: 3rem;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            height: 50px;
        }
        .search-input:focus {
            box-shadow: 0 4px 12px rgba(13, 140, 76, 0.15);
            border-color: var(--primary-green);
        }
        .search-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        .btn-map-trigger {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid #dee2e6;
            color: var(--primary-green);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        .btn-map-trigger:hover {
            background: var(--light-green);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="py-4">
    <div class="container">
        
        <header class="dashboard-card p-4 mb-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 bg-white">
            <div class="d-flex align-items-center gap-3 w-100">
                <div class="position-relative">
                    <img src="logo.jpg" alt="Logo" class="rounded-circle border border-2 border-brand p-1" style="width: 64px; height: 64px; object-fit: cover;">
                </div>
                <div>
                    <h1 class="h4 fw-bold text-dark mb-1">
                        Welcome, <?= htmlspecialchars($user['name'] ?? 'Guest') ?>
                        <a href="edit_profile.php" class="text-brand ms-2" title="Edit Profile">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </h1>
                    <?php if (!empty($user['city'])): ?>
                    <div class="d-flex align-items-center gap-2 text-muted small mb-0">
                        <i class="bi bi-geo-alt-fill text-brand"></i>
                        <?= htmlspecialchars($user['city']) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="d-flex flex-column align-items-end gap-2 w-100 w-md-auto">
                <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-md-end">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-eye me-1"></i> <?= htmlspecialchars($user['profile_views'] ?? '0') ?> Views
                    </span>
                    <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-star-fill me-1"></i> <?= htmlspecialchars($user['rating'] ?? '0') ?>/5
                    </span>
                </div>
                <a href="welcome.php" class="btn btn-outline-danger btn-sm px-4 rounded-pill mt-1">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </header>

        <div class="row g-3 mb-5 align-items-center">
            <div class="col-auto">
                <button class="btn-map-trigger" onclick="showMapModal()" title="View Nearby Map">
                    <i class="bi bi-map-fill fs-5"></i>
                </button>
            </div>
            <div class="col flex-grow-1">
                <div class="search-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Search for restaurants, cuisines, or dishes...">
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-brand rounded-pill px-4 py-2 fw-medium" style="height: 50px;">Search</button>
            </div>
        </div>

        <?php if ($user): ?>
            <div class="mb-5">
                <h5 class="fw-bold text-dark mb-3 px-1 border-start border-4 border-brand ps-2">Your Recent Reviews</h5>
                <?php if (empty($userReviews)): ?>
                    <div class="p-4 text-center bg-white rounded-4 border border-dashed">
                        <p class="text-muted mb-0">You haven't left any reviews yet. Visit a restaurant to share your experience!</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($userReviews as $i => $r): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="review-item h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-brand mb-0"><?= htmlspecialchars($r['business']) ?></h6>
                                    <?= renderStars($r['rating']) ?>
                                </div>
                                <p class="text-muted small mb-2 flex-grow-1">"<?= nl2br(htmlspecialchars($r['review'])) ?>"</p>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-light">
                                    <small class="text-secondary" style="font-size: 0.75rem;"><?= htmlspecialchars(date('M d, Y', strtotime($r['date']))) ?></small>
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm text-primary py-0" onclick="editReview(<?= $i ?>)">Edit</button>
                                        <button class="btn btn-light btn-sm text-danger py-0" onclick="deleteReview(<?= $i ?>)">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <h5 class="fw-bold text-dark mb-3 px-1 border-start border-4 border-brand ps-2">Explore Halal Establishments</h5>
        <div class="row g-4">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="dashboard-card p-3 position-relative">
                    <span class="badge bg-success badge-status">
                        <i class="bi bi-patch-check-fill me-1"></i> Halal Verified
                    </span>
                    <div class="d-flex flex-column h-100">
                        <img src="logo.jpg" alt="Al-Amin" class="rest-card-img mb-3">
                        <h3 class="h5 fw-bold mb-1">Al-Amin Restaurant</h3>
                        <div class="mb-2">
                            <?= renderStars(4) ?> <span class="text-muted small">(45 reviews)</span>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i>Makati City</span>
                            <span class="badge bg-light text-dark border">2.5 km</span>
                        </div>
                        
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">Dine-In</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">Take-Out</span>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill" onclick="showRestaurantDetails({
                                name: 'Al-Amin Restaurant',
                                owner: 'Fatima A. Rahman',
                                location: 'Makati City',
                                image: 'logo.jpg',
                                rating: 4,
                                reviews: 45,
                                accreditation: 100,
                                acc_list: ['DTI registered', 'BIR certified', 'Mayor\'s Permit'],
                                menu_dates: ['2024-06-01', '2024-06-02'],
                                type: 'Halal Verified',
                                type_class: 'bg-success',
                                review_link: '#'
                            })">Details</button>
                            <button class="btn btn-brand btn-sm flex-grow-1 rounded-pill" onclick="openReviewModal('Al-Amin Restaurant')">Review</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="dashboard-card p-3 position-relative">
                    <span class="badge bg-warning text-dark badge-status">
                        <i class="bi bi-clock-history me-1"></i> Pending
                    </span>
                    <div class="d-flex flex-column h-100">
                        <img src="logo.jpg" alt="Halal Kitchen" class="rest-card-img mb-3">
                        <h3 class="h5 fw-bold mb-1">Halal Kitchen</h3>
                        <div class="mb-2">
                            <?= renderStars(4) ?> <span class="text-muted small">(23 reviews)</span>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i>Quezon City</span>
                            <span class="badge bg-light text-dark border">1.8 km</span>
                        </div>
                        
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">Dine-In</span>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill" onclick="showRestaurantDetails({
                                name: 'Halal Kitchen',
                                owner: 'Ayesha M. Syed',
                                location: 'Quezon City',
                                image: 'logo.jpg',
                                rating: 4,
                                reviews: 23,
                                accreditation: 50,
                                acc_list: ['DTI registered', 'BIR certified'],
                                menu_dates: ['2024-06-01', '2024-06-02'],
                                type: 'Pending',
                                type_class: 'bg-warning text-dark',
                                review_link: '#'
                            })">Details</button>
                            <button class="btn btn-brand btn-sm flex-grow-1 rounded-pill" onclick="openReviewModal('Halal Kitchen')">Review</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="dashboard-card p-3 position-relative">
                    <span class="badge bg-info text-dark badge-status">
                        <i class="bi bi-droplet-fill me-1"></i> Non-Pork
                    </span>
                    <div class="d-flex flex-column h-100">
                        <img src="logo.jpg" alt="Seafood" class="rest-card-img mb-3">
                        <h3 class="h5 fw-bold mb-1">Seafood Paradise</h3>
                        <div class="mb-2">
                            <?= renderStars(5) ?> <span class="text-muted small">(67 reviews)</span>
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i>Manila</span>
                            <span class="badge bg-light text-dark border">3.2 km</span>
                        </div>
                        
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">Dine-In</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">Take-Out</span>
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill" onclick="showRestaurantDetails({
                                name: 'Seafood Paradise',
                                owner: 'John D. Cruz',
                                location: 'Manila',
                                image: 'logo.jpg',
                                rating: 5,
                                reviews: 67,
                                accreditation: 80,
                                acc_list: ['DTI registered', 'Mayor\'s Permit'],
                                menu_dates: ['2024-06-01', '2024-06-02'],
                                type: 'Non-Pork',
                                type_class: 'bg-info text-dark',
                                review_link: '#'
                            })">Details</button>
                            <button class="btn btn-brand btn-sm flex-grow-1 rounded-pill" onclick="openReviewModal('Seafood Paradise')">Review</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="mapModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                <div class="modal-header border-0 bg-white pb-0">
                    <h5 class="modal-title fw-bold">Nearby Halal Establishments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Halal</span>
                        <span class="badge bg-info text-dark"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Seafood</span>
                        <span class="badge bg-warning text-dark"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Non-Pork</span>
                    </div>
                    <div id="halalMap" style="height: 400px; width: 100%; border-radius: 1rem; background: #eee;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="restaurantDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Restaurant Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-4">
                        <img id="rest-img" src="" alt="Restaurant" class="rounded-3 shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <h4 class="fw-bold mb-1" id="rest-name"></h4>
                        <span id="rest-type" class="badge rounded-pill px-3 py-2"></span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded text-center">
                                <small class="text-muted d-block">Owner</small>
                                <strong id="rest-owner" class="text-dark"></strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded text-center">
                                <small class="text-muted d-block">Location</small>
                                <strong id="rest-location" class="text-dark"></strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <button class="btn btn-outline-dark btn-sm rounded-pill" id="rest-view-reviews-btn">
                            <i class="bi bi-chat-quote-fill me-1"></i> See All Reviews
                        </button>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <label class="fw-bold text-secondary small text-uppercase">Accreditation Progress</label>
                            <span id="rest-accreditation-text" class="fw-bold text-brand small"></span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div id="rest-accreditation-bar" class="progress-bar bg-brand" role="progressbar" style="width: 0%"></div>
                        </div>
                        <ul id="rest-accreditation-list" class="list-unstyled mt-2 small text-muted ps-3 border-start"></ul>
                    </div>

                    <div class="d-grid gap-2">
                        <div class="input-group">
                            <select id="rest-menu-date" class="form-select bg-light border-0">
                                </select>
                            <button class="btn btn-outline-primary" type="button" id="rest-view-menu-btn">View Menu</button>
                        </div>
                        <button class="btn btn-brand rounded-pill" id="rest-rate-btn">Rate & Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold">Daily Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="menuModalBody">
                    </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-light w-100" data-bs-target="#restaurantDetailsModal" data-bs-toggle="modal">Back to Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewReviewsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold">Community Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 bg-light" id="viewReviewsBody" style="max-height: 60vh; overflow-y: auto;">
                    </div>
                <div class="modal-footer border-0 bg-light">
                    <button class="btn btn-secondary w-100" data-bs-target="#restaurantDetailsModal" data-bs-toggle="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="reviewEditId" value="">
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">BUSINESS</label>
                            <input type="text" name="business" id="reviewBusiness" class="form-control bg-light" readonly required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">RATING</label>
                            <select name="rating" class="form-select text-warning fw-bold" required>
                                <option value="5" class="text-dark">★★★★★ - Excellent</option>
                                <option value="4" class="text-dark">★★★★☆ - Good</option>
                                <option value="3" class="text-dark">★★★☆☆ - Average</option>
                                <option value="2" class="text-dark">★★☆☆☆ - Poor</option>
                                <option value="1" class="text-dark">★☆☆☆☆ - Terrible</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">YOUR EXPERIENCE</label>
                            <textarea name="review" class="form-control" rows="4" placeholder="Tell us about the food, service, and ambiance..." required></textarea>
                        </div>

                        <div class="bg-light p-3 rounded-3 mb-3">
                            <label class="d-block small text-muted fw-bold mb-2">POST AS</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visPublic" value="public" checked>
                                    <label class="form-check-label" for="visPublic">My Name</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visAnon" value="anonymous">
                                    <label class="form-check-label" for="visAnon">Anonymous</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand px-4">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Data injected from PHP
        const allReviews = <?php echo json_encode($reviews); ?>;

        // 1. Map Logic
        let map = null;
        function showMapModal() {
            const modalEl = document.getElementById('mapModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            modalEl.addEventListener('shown.bs.modal', function () {
                if (!map) {
                    map = L.map('halalMap').setView([14.5547, 121.0244], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                    const createIcon = (emoji, color) => L.divIcon({
                        className: '',
                        html: `<div style="background:${color}; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:1.2rem; border:2px solid white; box-shadow:0 2px 5px rgba(0,0,0,0.3);">${emoji}</div>`,
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });
                    L.marker([14.5547, 121.0244], {icon: createIcon('🕌', '#198754')}).addTo(map).bindPopup('<b>Al-Amin Restaurant</b><br>Halal Verified');
                    L.marker([14.5794, 120.9721], {icon: createIcon('🐟', '#0dcaf0')}).addTo(map).bindPopup('<b>Seafood Paradise</b><br>Non-Pork / Seafood');
                    L.marker([14.6760, 121.0437], {icon: createIcon('🍳', '#ffc107')}).addTo(map).bindPopup('<b>Halal Kitchen</b><br>Pending Certification');
                } else { map.invalidateSize(); }
            });
        }

        // 2. Menu Data
        const restaurantMenus = {
            'Al-Amin Restaurant': { '2024-06-01': [{ name: 'Chicken Biryani', price: '₱180', desc: 'Spiced rice with chicken' }, { name: 'Beef Kebab', price: '₱150', desc: 'Grilled beef skewers' }], '2024-06-02': [{ name: 'Mutton Curry', price: '₱200', desc: 'Slow-cooked mutton in curry' }] },
            'Halal Kitchen': { '2024-06-01': [{ name: 'Halal Burger', price: '₱120', desc: 'Beef patty, lettuce, tomato' }] },
            'Seafood Paradise': { '2024-06-01': [{ name: 'Grilled Prawns', price: '₱250', desc: 'Fresh prawns, grilled' }] }
        };

        let currentRestaurantName = '';

        function showRestaurantDetails(data) {
            currentRestaurantName = data.name;

            // Populate Modal Info
            document.getElementById('rest-img').src = data.image;
            document.getElementById('rest-name').textContent = data.name;
            document.getElementById('rest-owner').textContent = data.owner;
            document.getElementById('rest-location').textContent = data.location;
            const typeBadge = document.getElementById('rest-type');
            typeBadge.textContent = data.type;
            typeBadge.className = 'badge rounded-pill px-3 py-2 ' + data.type_class;

            document.getElementById('rest-accreditation-bar').style.width = data.accreditation + '%';
            document.getElementById('rest-accreditation-text').textContent = data.accreditation + '%';
            document.getElementById('rest-accreditation-list').innerHTML = data.acc_list.map(item => `<li><i class="bi bi-check-lg text-success me-1"></i> ${item}</li>`).join('');
            document.getElementById('rest-menu-date').innerHTML = data.menu_dates.map(d => `<option value="${d}">${d}</option>`).join('');

            // "Rate & Review" Button
            document.getElementById('rest-rate-btn').onclick = function() {
                bootstrap.Modal.getInstance(document.getElementById('restaurantDetailsModal')).hide();
                openReviewModal(data.name);
            };

            // NEW: "See All Reviews" Button
            document.getElementById('rest-view-reviews-btn').onclick = function() {
                // Hide details, show reviews
                bootstrap.Modal.getInstance(document.getElementById('restaurantDetailsModal')).hide();
                openViewReviewsModal(data.name);
            };

            const detailModal = new bootstrap.Modal(document.getElementById('restaurantDetailsModal'));
            detailModal.show();
        }

        // 3. View Menu Logic
        document.getElementById('rest-view-menu-btn').addEventListener('click', function() {
            const date = document.getElementById('rest-menu-date').value;
            const menu = (restaurantMenus[currentRestaurantName] && restaurantMenus[currentRestaurantName][date]) || [];
            const body = document.getElementById('menuModalBody');
            body.innerHTML = menu.length ? '<div class="list-group list-group-flush">' + menu.map(item => `
                <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <div><h6 class="fw-bold mb-0">${item.name}</h6><small class="text-muted">${item.desc}</small></div>
                    <span class="badge bg-light text-success border border-success">${item.price}</span>
                </div>`).join('') + '</div>' : '<div class="p-4 text-center text-muted">No menu available for this date.</div>';
            
            bootstrap.Modal.getInstance(document.getElementById('restaurantDetailsModal')).hide();
            new bootstrap.Modal(document.getElementById('menuModal')).show();
        });

        // 4. View Reviews Logic (NEW)
        function openViewReviewsModal(businessName) {
            // Filter reviews for this business
            const businessReviews = allReviews.filter(r => r.business === businessName);
            const container = document.getElementById('viewReviewsBody');
            
            if (businessReviews.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-chat-square-text fs-1 opacity-25 mb-2"></i>
                        <p class="mb-0">No reviews yet.</p>
                        <small>Be the first to share your experience!</small>
                    </div>`;
            } else {
                container.innerHTML = businessReviews.map(r => `
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">${r.reviewer}</h6>
                                    <small class="text-muted" style="font-size:0.75rem">${new Date(r.date).toLocaleDateString()}</small>
                                </div>
                                <div class="text-warning small">
                                    ${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}
                                </div>
                            </div>
                            <p class="card-text text-secondary small mb-0">"${r.review}"</p>
                        </div>
                    </div>
                `).join('');
            }
            
            new bootstrap.Modal(document.getElementById('viewReviewsModal')).show();
        }

        // 5. Write Review Logic
        function openReviewModal(businessName) {
            document.getElementById('reviewBusiness').value = businessName;
            document.getElementById('reviewForm').reset();
            document.getElementById('reviewEditId').value = ''; 
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        }

        // Mock Delete
        window.deleteReview = function(id) {
            if(confirm('Delete this review?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `<input type="hidden" name="delete_review_id" value="${id}">`;
                document.body.appendChild(form);
                form.submit();
            }
        };

        // Mock Edit
        window.editReview = function(id) {
            document.getElementById('reviewEditId').value = id;
            document.getElementById('reviewBusiness').value = "Mock Business (Edit Mode)";
            document.querySelector('#reviewForm textarea').value = "This is the review content to edit...";
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        };

    </script>
</body>
</html>