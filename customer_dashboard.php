<?php
require_once "includes/db.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login_customer.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 1. Fetch Restaurants (Owners) using Prepared Statement
$search_term = "%%"; // Default: match all
$params = [];
$types = "";

$sql = "SELECT u.id, u.business_name, u.city, u.address,
        (SELECT status FROM halal_certification_applications WHERE email = u.email LIMIT 1) as cert_status,
        (SELECT AVG(rating) FROM reviews WHERE business_id = u.id) as avg_rating,
        (SELECT COUNT(*) FROM reviews WHERE business_id = u.id) as review_count
        FROM users u 
        WHERE u.role = 'owner'";

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $sql .= " AND (u.business_name LIKE ? OR u.city LIKE ?)";
    $search_input = "%" . $_GET['q'] . "%";
    $params[] = $search_input;
    $params[] = $search_input;
    $types = "ss";
}

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$restaurants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


// 2. Fetch User's Reviews (Prepared Statement)
$reviewStmt = $conn->prepare("SELECT r.id, r.rating, r.comment, r.created_at, u.business_name 
                 FROM reviews r 
                 JOIN users u ON r.business_id = u.id 
                 WHERE r.reviewer_id = ? 
                 ORDER BY r.created_at DESC");
$reviewStmt->bind_param("i", $user_id);
$reviewStmt->execute();
$myReviews = $reviewStmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
    <title>Customer Dashboard - Halal Keeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f6f8fa; font-family: sans-serif; }
        .rest-card { border: none; border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
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
            <div class="input-group input-group-lg shadow-sm">
                <input type="text" name="q" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-success">Search</button>
            </div>
        </form>

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
                <div class="rest-card p-3 position-relative h-100">
                    <span class="badge <?= $statusClass ?> badge-status"><?= htmlspecialchars($status) ?></span>
                    <h5 class="fw-bold mt-4"><?= htmlspecialchars($rest['business_name']) ?></h5>
                    <div class="small mb-2">
                        <?= renderStars($rest['avg_rating'] ?? 0) ?>
                        <span class="text-muted">(<?= $rest['review_count'] ?>)</span>
                    </div>
                    <p class="text-muted small">
                        <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($rest['address'] . ', ' . $rest['city']) ?>
                    </p>
                    <button class="btn btn-outline-success btn-sm w-100" onclick="openReviewModal('<?= htmlspecialchars($rest['business_name']) ?>')">Write Review</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openReviewModal(name) {
            // Note: In a real app, use ID, not name.
            document.getElementById('reviewBusiness').value = name; 
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        }
    </script>
</body>
</html>