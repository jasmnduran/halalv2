<?php
require_once "includes/db.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login_customer.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 1. Fetch Restaurants (Owners)
$sql = "SELECT u.id, u.business_name, u.city, u.address,
        (SELECT status FROM halal_certification_applications WHERE email = u.email LIMIT 1) as cert_status,
        (SELECT AVG(rating) FROM reviews WHERE business_id = u.id) as avg_rating,
        (SELECT COUNT(*) FROM reviews WHERE business_id = u.id) as review_count
        FROM users u 
        WHERE u.role = 'owner'";

// Simple Search Filter
if (isset($_GET['q'])) {
    $search = $conn->real_escape_string($_GET['q']);
    $sql .= " AND (u.business_name LIKE '%$search%' OR u.city LIKE '%$search%')";
}

$res = $conn->query($sql);
$restaurants = $res->fetch_all(MYSQLI_ASSOC);

// 2. Fetch User's Reviews
$myReviewsSql = "SELECT r.id, r.rating, r.comment, r.created_at, u.business_name 
                 FROM reviews r 
                 JOIN users u ON r.business_id = u.id 
                 WHERE r.reviewer_id = $user_id 
                 ORDER BY r.created_at DESC";
$myReviews = $conn->query($myReviewsSql)->fetch_all(MYSQLI_ASSOC);

// Helper for Stars
function renderStars($rating) {
    $r = round($rating);
    $out = str_repeat('<i class="bi bi-star-fill text-warning"></i>', $r);
    $out .= str_repeat('<i class="bi bi-star text-muted opacity-25"></i>', 5 - $r);
    return $out;
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f6f8fa; font-family: 'Inter', sans-serif; }
        .rest-card { border: none; border-radius: 1rem; transition: transform 0.2s; background: white; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .rest-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .badge-status { position: absolute; top: 1rem; right: 1rem; }
    </style>
</head>
<body class="py-4">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Hello, <?= htmlspecialchars($user_name) ?>!</h4>
                <p class="text-muted small">Find your next Halal meal</p>
            </div>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>

        <form action="" method="GET" class="mb-5">
            <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                <span class="input-group-text bg-white border-0 ps-4"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-0" placeholder="Search restaurants or cities..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-success px-4 fw-bold">Search</button>
            </div>
        </form>

        <h5 class="fw-bold text-dark mb-3">Explore Restaurants</h5>
        <div class="row g-4 mb-5">
            <?php foreach ($restaurants as $rest): 
                $status = $rest['cert_status'] ?? 'Not Certified';
                $statusClass = match($status) {
                    'Approved' => 'bg-success',
                    'Pending' => 'bg-warning text-dark',
                    default => 'bg-secondary'
                };
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="rest-card p-3 position-relative">
                    <span class="badge <?= $statusClass ?> badge-status"><?= $status ?></span>
                    <div class="d-flex flex-column h-100">
                        <div class="bg-light rounded-3 mb-3 d-flex align-items-center justify-content-center" style="height: 140px;">
                            <i class="bi bi-shop fs-1 text-secondary opacity-25"></i>
                        </div>
                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($rest['business_name']) ?></h5>
                        <div class="small mb-2">
                            <?= renderStars($rest['avg_rating'] ?? 0) ?>
                            <span class="text-muted ms-1">(<?= $rest['review_count'] ?>)</span>
                        </div>
                        <p class="text-muted small mb-3 flex-grow-1">
                            <i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($rest['address'] . ', ' . $rest['city']) ?>
                        </p>
                        
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success btn-sm w-100 rounded-pill" onclick="openReviewModal('<?= htmlspecialchars($rest['business_name']) ?>')">Write Review</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($restaurants)): ?>
                <div class="col-12 text-center py-5 text-muted">
                    No restaurants found matching your criteria.
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($myReviews)): ?>
        <h5 class="fw-bold text-dark mb-3">Your Reviews</h5>
        <div class="row g-3">
            <?php foreach ($myReviews as $rev): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($rev['business_name']) ?></h6>
                            <small class="text-muted"><?= date('M d', strtotime($rev['created_at'])) ?></small>
                        </div>
                        <div class="mb-2"><?= renderStars($rev['rating']) ?></div>
                        <p class="small text-muted mb-0">"<?= htmlspecialchars($rev['comment']) ?>"</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="actions/submit_review.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="business" id="reviewBusiness">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Terrible</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="review" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="visibility" value="anonymous" id="anon">
                            <label class="form-check-label" for="anon">Post Anonymously</label>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-success px-4 rounded-pill">Post Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openReviewModal(name) {
            document.getElementById('reviewBusiness').value = name;
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        }
    </script>
</body>
</html>