<?php 
session_start(); 
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$reviews = file_exists('reviews.json') ? json_decode(file_get_contents('reviews.json'), true) : [];
// Handle review deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review_id'])) {
  $delete_id = intval($_POST['delete_review_id']);
  $file = 'reviews.json';
  $reviews = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
  if (isset($reviews[$delete_id])) {
    unset($reviews[$delete_id]);
    $reviews = array_values($reviews); // reindex
    file_put_contents($file, json_encode($reviews, JSON_PRETTY_PRINT));
  }
  header('Location: customer_dashboard.php');
  exit;
}
// Handle review edit/submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['business'], $_POST['rating'], $_POST['review'])) {
  $file = 'reviews.json';
  $reviews = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
  $edit_id = isset($_POST['edit_id']) && $_POST['edit_id'] !== '' ? intval($_POST['edit_id']) : null;
  $business = $_POST['business'];
  $rating = intval($_POST['rating']);
  $review = trim($_POST['review']);
  $visibility = $_POST['visibility'] ?? 'public';
  // Use both first name and full name for reviewer
  $reviewer = ($visibility === 'anonymous') ? 'Anonymous' : (
    isset($_SESSION['user']['first_name']) ? $_SESSION['user']['first_name'] : (isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Anonymous')
  );
  $data = [
    'business' => $business,
    'rating' => $rating,
    'review' => $review,
    'reviewer' => $reviewer,
    'visibility' => $visibility,
    'date' => date('Y-m-d H:i:s')
  ];
  if ($edit_id !== null && isset($reviews[$edit_id])) {
    $reviews[$edit_id] = $data;
  } else {
    $reviews[] = $data;
  }
  file_put_contents($file, json_encode($reviews, JSON_PRETTY_PRINT));
  header('Location: customer_dashboard.php');
  exit;
}
function display_reviews($business, $reviews, $user) {
  $out = '';
  $found = false;
  foreach ($reviews as $r) {
    // Exclude user's own reviews
    if ($r['business'] === $business && !($r['reviewer'] === ($user['first_name'] ?? '') || ($r['reviewer'] === 'Anonymous' && ($user['first_name'] ?? '') === 'Anonymous'))) {
      $found = true;
      $out .= '<div class="review" style="border:1px solid #eee;padding:8px 12px;margin-bottom:6px;border-radius:6px;">';
      $out .= '<strong>' . htmlspecialchars($r['reviewer']) . '</strong> <span style="color:#b59f3b;">' . str_repeat('★', $r['rating']) . str_repeat('☆', 5-$r['rating']) . '</span> <span style="font-size:0.9em;color:#888;">' . htmlspecialchars($r['date']) . '</span><br>';
      $out .= nl2br(htmlspecialchars($r['review'])) . '</div>';
    }
  }
  if (!$found) $out = '<div style="color:#888;font-size:0.95em;">No community reviews yet.</div>';
  return $out;
}
// Prepare user reviews for the header section
$userReviews = array_filter($reviews, function($r) use ($user) {
  if (!$user) return false;
  $first = $user['first_name'] ?? '';
  $full = $user['name'] ?? '';
  if ($r['reviewer'] === 'Anonymous' && ($first === 'Anonymous' || $full === 'Anonymous')) return true;
  return ($r['reviewer'] === $first || $r['reviewer'] === $full);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .shadow-sm { box-shadow: 0 4px 24px rgba(0,0,0,0.08) !important; }
    .card { border-radius: 1.25rem !important; box-shadow: 0 2px 12px rgba(44,62,80,0.07) !important; border: none; }
    .badge-green { background: #22c55e !important; color: #fff !important; }
    .badge-yellow { background: #facc15 !important; color: #fff !important; }
    .badge-blue { background: #2563eb !important; color: #fff !important; }
    .btn-blue { background: #2563eb; color: #fff; border-radius: 0.5rem; border: none; padding: 0.5rem 1rem; font-weight: 500; }
    .btn-blue:hover { background: #1746a2; color: #fff; }
    .flex { display: flex; gap: 24px; flex-wrap: wrap; }
    @media (max-width: 900px) { .flex { flex-direction: column; gap: 16px; } }
    .main-header-card { background: #fff; border-radius: 1.25rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 1.5rem 2rem 1rem 2rem; margin-bottom: 2rem; }
  </style>
</head>
<body>
  <div class="container py-4">
    <div class="main-header-card d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-4">
      <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border border-2 border-success" style="height:56px;width:56px;" />
        <div>
          <h1 class="h4 fw-bold text-dark d-flex align-items-center gap-2 mb-1" style="margin-bottom:4px;">
            Welcome, <?= htmlspecialchars($user['name'] ?? 'Guest User') ?>
            <a href="edit_profile.php" title="Edit Profile" class="ms-2 text-success text-decoration-none">
              <svg xmlns="http://www.w3.org/2000/svg" style="height:20px;width:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3zm0 0v3h3" /></svg>
            </a>
          </h1>
          <?php if (!empty($user['city'])): ?>
          <p class="text-muted small d-flex align-items-center gap-2 mb-0">
            <svg class="text-success" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0l-4.243 4.243M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <?= htmlspecialchars($user['city']) ?>
          </p>
          <?php endif; ?>
        </div>
      </div>
      <div class="d-flex gap-2 align-items-center mt-3 mt-md-0">
        <span class="badge bg-success bg-opacity-10 text-success-emphasis px-3 py-1 rounded-pill small fw-semibold">Profile Views: <?= htmlspecialchars($user['profile_views'] ?? '0') ?></span>
        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-1 rounded-pill small fw-semibold">Rating: <?= htmlspecialchars($user['rating'] ?? '0') ?>/5</span>
        
        <button onclick="window.location.href='welcome.php'" class="btn btn-danger btn-sm ms-3" style="width:auto; min-width:80px; padding:6px 18px; font-size:1rem;">Logout</button>
      </div>
    </div>
    <div class="row g-4 mt-4 mb-4">
      <div style="flex:2; display: flex; flex-direction:column; gap:2px;">
        <label style="margin-bottom:4px;">Search Restaurants</label>
        <div style="display: flex; flex-direction: row; align-items: flex-start; gap: 8px;">
          <button title="Use GPS location" onclick="showMapModal()" style="height:40px; width:40px; min-width:40px; padding:0; display:flex; align-items:center; justify-content:center; font-size:1.2em; border-radius:6px; border:1px solid #ccc; background:#fff;">
            📍
          </button>
          <input type="text" placeholder="Search by restaurant name..." style="width:100%; height:40px;">
        </div>
      </div>
      <div style="align-self:end; display: flex; align-items: end; height: 100%;">
       <button class="btn btn-success btn-sm" style="min-width: 20px;">Search</button>
      </div>
    </div>
    <?php if ($user): ?>
      <div class="card" style="margin: 24px 0;">
        <h2 class="h5 fw-bold text-success mb-2">Your Reviews</h2>
        <?php
          // The userReviews array is already prepared above, so we can use it directly.
          if (count($userReviews) === 0) {
            echo '<div style="color:#888;">You have not left any reviews yet.</div>';
          } else {
            foreach ($userReviews as $i => $r) {
              echo '<div style="background:#fff;border-radius:10px;padding:18px 20px 14px 14px;margin-bottom:18px;box-shadow:0 2px 8px rgba(44,62,80,0.07);border-left:5px solid #219653;position:relative;">';
              echo '<div class="d-flex justify-content-between align-items-center mb-1">';
              echo '<div><strong style="color:#219653;font-size:1.1em;">' . htmlspecialchars($r['business']) . '</strong> ';
              echo '<span style="color:#b59f3b;">' . str_repeat('★', $r['rating']) . str_repeat('☆', 5-$r['rating']) . '</span></div>';
              echo '<span style="font-size:0.93em;color:#888;">' . htmlspecialchars($r['date']) . '</span>';
              echo '</div>';
              echo '<div style="font-size:1.05em; color:#222; margin-bottom:6px;">' . nl2br(htmlspecialchars($r['review'])) . '</div>';
              echo '<div class="d-flex gap-2 align-items-center">';
              echo '<span class="badge bg-secondary" style="font-size:0.85em;">' . htmlspecialchars($r['business']) . '</span>';
              echo '<button class="btn btn-outline-primary btn-xs px-2 py-1" style="font-size:0.85em;" onclick="editReview(' . $i . ')">Edit</button>';
              echo '<button class="btn btn-outline-danger btn-xs px-2 py-1" style="font-size:0.85em;" onclick="deleteReview(' . $i . ')">Delete</button>';
              echo '</div>';
              echo '</div>';
            }
          }
        ?>
      </div>
    <?php endif; ?>
    <div class="row g-4">
      <div class="card shadow-sm rounded-4 p-4 col-12 col-md-4 h-100">
        <h2>Al-Amin Restaurant <span class="badge badge-green">Halal Verified</span></h2>
        <div style="color:#b59f3b;">★★★★☆ <span style="color:var(--gray);font-size:0.9em;">(45 reviews)</span></div>
        <div>Location: Makati City</div>
        <div>Distance: 2.5 km</div>
        <div class="mt-2">
          <span class="badge badge-yellow">Dine-In</span>
          <span class="badge badge-blue">Take-Out</span>
        </div>
        <div class="mt-2">
          <span class="badge">Price: ₱₱₱</span>
          <span class="badge">Delivery: 30 min</span>
        </div>
        <div class="flex mt-2">
          <button class="btn-blue" style="flex:1;" onclick="showRestaurantDetails({
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
            type_badge: 'badge-green',
            review_link: 'review.php?business=Al-Amin Restaurant'
          })">View Details</button>
          <button class="btn-blue" style="flex:1;" onclick="openReviewModal('Al-Amin Restaurant')">Leave Review</button>
        </div>
      </div>
      <div class="card shadow-sm rounded-4 p-4 col-12 col-md-4 h-100">
        <h2>Halal Kitchen <span class="badge badge-yellow">Pending</span></h2>
        <div style="color:#b59f3b;">★★★★☆ <span style="color:var(--gray);font-size:0.9em;">(23 reviews)</span></div>
        <div>Location: Quezon City</div>
        <div>Distance: 1.8 km</div>
        <div class="mt-2">
          <span class="badge badge-yellow">Dine-In</span>
        </div>
        <div class="mt-2">
          <span class="badge">Price: ₱₱</span>
          <span class="badge">Delivery: 25 min</span>
        </div>
        <div class="flex mt-2">
          <button class="btn-blue" style="flex:1;" onclick="showRestaurantDetails({
            name: 'Halal Kitchen',
            owner: 'Ayesha M. Syed',
            location: 'Quezon City',
            image: 'logo.jpg',
            rating: 4,
            reviews: 23,
            accreditation: 50,
            acc_list: ['DTI registered', 'BIR certified', 'Mayor\'s Permit'],
            menu_dates: ['2024-06-01', '2024-06-02'],
            type: 'Pending',
            type_badge: 'badge-yellow',
            review_link: 'review.php?business=Halal Kitchen'
          })">View Details</button>
          <button class="btn-blue" style="flex:1;" onclick="openReviewModal('Halal Kitchen')">Leave Review</button>
        </div>
      </div>
      <div class="card shadow-sm rounded-4 p-4 col-12 col-md-4 h-100">
        <h2>Seafood Paradise <span class="badge badge-blue">Non-Pork</span></h2>
        <div style="color:#b59f3b;">★★★★★ <span style="color:var(--gray);font-size:0.9em;">(67 reviews)</span></div>
        <div>Location: Manila</div>
        <div>Distance: 3.2 km</div>
        <div class="mt-2">
          <span class="badge badge-yellow">Dine-In</span>
          <span class="badge badge-blue">Take-Out</span>
        </div>
        <div class="mt-2">
          <span class="badge">Price: ₱₱₱₱</span>
          <span class="badge">Delivery: 40 min</span>
        </div>
        <div class="flex mt-2">
          <button class="btn-blue" style="flex:1;" onclick="showRestaurantDetails({
            name: 'Seafood Paradise',
            owner: 'John D. Cruz',
            location: 'Manila',
            image: 'logo.jpg',
            rating: 5,
            reviews: 67,
            accreditation: 80,
            acc_list: ['DTI registered', 'BIR certified', 'Mayor\'s Permit'],
            menu_dates: ['2024-06-01', '2024-06-02'],
            type: 'Non-Pork',
            type_badge: 'badge-blue',
            review_link: 'review.php?business=Seafood Paradise'
          })">View Details</button>
          <button class="btn-blue" style="flex:1;" onclick="openReviewModal('Seafood Paradise')">Leave Review</button>
        </div>
        <div style="margin-top:8px;">
          <strong>Community Reviews:</strong>
          <?= display_reviews('Seafood Paradise', $reviews, $user) ?>
        </div>
      </div>
    </div>
  </div>
</body>
<!-- Map Modal and Scripts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Bootstrap JS (if not already included) -->
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
    
    // Mobile-friendly search
    $('input[type="text"]').on('focus', function() {
      $(this).addClass('ui-focus');
    }).on('blur', function() {
      $(this).removeClass('ui-focus');
    });
  });
</script>
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title fw-bold" id="mapModalLabel">Nearby Establishments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-white" style="height:480px;">
        <div class="mb-3 d-flex align-items-center gap-3">
          <span class="badge bg-success">Halal</span>
          <span class="badge bg-primary">Seafood</span>
          <span class="badge bg-warning text-dark">Non-Pork</span>
        </div>
        <div id="halalMap" style="height:380px; width:100%; border-radius: 0.75rem; border: 1px solid #e5e7eb;"></div>
      </div>
    </div>
  </div>
</div>
<!-- Restaurant Details Modal -->
<div class="modal fade" id="restaurantDetailsModal" tabindex="-1" aria-labelledby="restaurantDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:600px;">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title fw-bold" id="restaurantDetailsModalLabel">Restaurant Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-white" style="padding: 1.5rem 2rem;">
        <div class="row g-4 align-items-center flex-column flex-md-row">
          <div class="col-12 col-md-4 d-flex justify-content-center mb-3 mb-md-0">
            <img id="rest-img" src="logo.jpg" alt="Restaurant Image" class="rounded border border-2 img-fluid" style="max-width:160px;max-height:120px;width:100%;object-fit:cover;">
          </div>
          <div class="col-12 col-md-8">
            <h2 class="h4 fw-bold mb-1 text-success" id="rest-name">Store Name</h2>
            <div class="mb-1"><span class="fw-semibold">Owner:</span> <span id="rest-owner"></span></div>
            <div class="mb-1"><span class="fw-semibold">Location:</span> <span id="rest-location"></span></div>
            <span id="rest-type" class="badge px-2 py-1 mb-2"></span>
            <div class="mb-2 mt-2">
              <span id="rest-rating-stars" style="color:#b59f3b;font-size:1.2em;"></span>
              <span id="rest-rating-text" style="font-size:1.1em;color:#444;"></span>
              <a id="rest-view-reviews" href="#" class="ms-2 small">view all reviews</a>
            </div>
            <div class="mb-2">
              <label class="fw-semibold mb-1">Accreditation Progress</label>
              <div class="progress mb-1" style="height:16px;max-width:300px;">
                <div id="rest-accreditation-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span id="rest-accreditation-text" class="small"></span>
              <ul id="rest-accreditation-list" class="mb-0 mt-1 small"></ul>
            </div>
            <div class="mb-3 d-flex flex-column flex-sm-row align-items-stretch gap-2">
              <div class="d-flex align-items-center gap-2 flex-grow-1">
                <label class="fw-semibold mb-0">List of Menu:</label>
                <select id="rest-menu-date" class="form-select form-select-sm" style="width:auto;display:inline-block;"></select>
              </div>
              <button class="btn btn-outline-info btn-sm w-100 w-sm-auto" id="rest-view-menu-btn" type="button">View Menu</button>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
              <button class="btn btn-outline-warning btn-sm w-100 w-sm-auto" id="rest-rate-btn">Rate ★</button>
              <button class="btn btn-outline-success btn-sm w-100 w-sm-auto">Dine-In</button>
              <button class="btn btn-outline-primary btn-sm w-100 w-sm-auto">Next</button>
              <button class="btn btn-outline-secondary btn-sm w-100 w-sm-auto" data-bs-dismiss="modal">Back</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Menu Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content" style="border-radius: 1rem;">
      <div class="modal-header bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title fw-bold" id="menuModalLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-white" id="menuModalBody" style="padding: 1.5rem;">
        <!-- Menu content will be injected here -->
      </div>
    </div>
  </div>
</div>
<!-- Review Modal Popup -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 1.25rem;">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">Leave a Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="reviewForm" method="post">
        <div class="modal-body" style="background: #f7faf7;">
          <input type="hidden" name="edit_id" id="reviewEditId" value="">
          <div class="mb-3">
            <label class="form-label">Business Name</label>
            <input type="text" name="business" id="reviewBusiness" class="form-control" value="" readonly required>
          </div>
          <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select star-select" required>
              <option value="">&#9734; &#9734; &#9734; &#9734; &#9734; (Select rating)</option>
              <option value="5">&#9733; &#9733; &#9733; &#9733; &#9733; - Excellent</option>
              <option value="4">&#9733; &#9733; &#9733; &#9733; &#9734; - Good</option>
              <option value="3">&#9733; &#9733; &#9733; &#9734; &#9734; - Average</option>
              <option value="2">&#9733; &#9733; &#9734; &#9734; &#9734; - Poor</option>
              <option value="1">&#9733; &#9734; &#9734; &#9734; &#9734; - Very Poor</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Your Review</label>
            <textarea name="review" class="form-control" rows="4" placeholder="Share your experience..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Reviewer Visibility</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="visibility" id="visPublic" value="public" checked>
              <label class="form-check-label" for="visPublic">Show my name</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="visibility" id="visAnon" value="anonymous">
              <label class="form-check-label" for="visAnon">Submit as anonymous</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Submit Review</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function showMapModal() {
  var modal = new bootstrap.Modal(document.getElementById('mapModal'));
  modal.show();
  setTimeout(function() {
    if (!window._mapInitialized) {
      var map = L.map('halalMap').setView([14.5547, 121.0244], 13); // Makati sample
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);
      // Sample markers with colored icons and different locations
      var halalIcon = L.icon({ iconUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/images/marker-icon.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/images/marker-shadow.png', shadowSize: [41, 41] });
      var seafoodIcon = L.divIcon({ className: '', html: '<div style="background:#0d6efd;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2em;">🐟</div>', iconSize: [24,24], iconAnchor: [12,24] });
      var nonPorkIcon = L.divIcon({ className: '', html: '<div style="background:#ffc107;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#212529;font-size:1.2em;">🥗</div>', iconSize: [24,24], iconAnchor: [12,24] });
      // Halal - Makati
      L.marker([14.5547, 121.0244], {icon: halalIcon}).addTo(map).bindPopup('<b>Al-Amin Restaurant</b><br><span style="color:#198754;font-weight:bold;">&#10004; Halal</span>');
      // Seafood - Manila Bay
      L.marker([14.5794, 120.9721], {icon: seafoodIcon}).addTo(map).bindPopup('<b>Seafood Paradise</b><br><span style="color:#0d6efd;font-weight:bold;">&#128031; Seafood</span>');
      // Non-Pork - Quezon City
      L.marker([14.6760, 121.0437], {icon: nonPorkIcon}).addTo(map).bindPopup('<b>Non-Pork Diner</b><br><span style="color:#ffc107;font-weight:bold;">🥗 Non-Pork</span>');
      window._mapInitialized = true;
    }
  }, 300);
}

// Sample menu data for demonstration
const restaurantMenus = {
  'Al-Amin Restaurant': {
    '2024-06-01': [
      { name: 'Chicken Biryani', price: '₱180', desc: 'Spiced rice with chicken' },
      { name: 'Beef Kebab', price: '₱150', desc: 'Grilled beef skewers' },
      { name: 'Lassi', price: '₱60', desc: 'Yogurt drink' }
    ],
    '2024-06-02': [
      { name: 'Mutton Curry', price: '₱200', desc: 'Slow-cooked mutton in curry' },
      { name: 'Roti', price: '₱30', desc: 'Flatbread' }
    ]
  },
  'Halal Kitchen': {
    '2024-06-01': [
      { name: 'Halal Burger', price: '₱120', desc: 'Beef patty, lettuce, tomato' },
      { name: 'Fries', price: '₱50', desc: 'Crispy potato fries' }
    ],
    '2024-06-02': [
      { name: 'Chicken Shawarma', price: '₱100', desc: 'Wrap with chicken, veggies' }
    ]
  },
  'Seafood Paradise': {
    '2024-06-01': [
      { name: 'Grilled Prawns', price: '₱250', desc: 'Fresh prawns, grilled' },
      { name: 'Fish Curry', price: '₱180', desc: 'Spicy fish curry' }
    ],
    '2024-06-02': [
      { name: 'Seafood Platter', price: '₱350', desc: 'Assorted seafood' }
    ]
  }
};

let currentRestaurant = '';

function showRestaurantDetails(data) {
  document.getElementById('rest-img').src = data.image;
  document.getElementById('rest-name').textContent = data.name;
  document.getElementById('rest-owner').textContent = data.owner;
  document.getElementById('rest-location').textContent = data.location;
  var typeBadge = document.getElementById('rest-type');
  typeBadge.textContent = data.type;
  typeBadge.className = 'badge px-2 py-1 ' + data.type_badge;
  // Rating stars
  var stars = '★★★★★☆☆☆☆☆'.slice(5-data.rating, 10-data.rating);
  document.getElementById('rest-rating-stars').textContent = stars;
  document.getElementById('rest-rating-text').textContent = ` (${data.rating}/5, ${data.reviews} reviews)`;
  document.getElementById('rest-view-reviews').href = data.review_link;
  // Accreditation
  document.getElementById('rest-accreditation-bar').style.width = data.accreditation + '%';
  document.getElementById('rest-accreditation-bar').setAttribute('aria-valuenow', data.accreditation);
  document.getElementById('rest-accreditation-text').textContent = data.accreditation + '% complete';
  var accList = document.getElementById('rest-accreditation-list');
  accList.innerHTML = '';
  data.acc_list.forEach(function(item) {
    var li = document.createElement('li');
    li.textContent = item;
    accList.appendChild(li);
  });
  // Menu dates
  var menuSel = document.getElementById('rest-menu-date');
  menuSel.innerHTML = '';
  data.menu_dates.forEach(function(date) {
    var opt = document.createElement('option');
    opt.value = date;
    opt.textContent = date;
    menuSel.appendChild(opt);
  });
  // Store current restaurant for menu
  currentRestaurant = data.name;
  // Rate button
  document.getElementById('rest-rate-btn').onclick = function() {
    window.location.href = data.review_link;
  };
  // View Menu button
  document.getElementById('rest-view-menu-btn').onclick = function() {
    showMenuModal();
  };
  var modal = new bootstrap.Modal(document.getElementById('restaurantDetailsModal'));
  modal.show();
}

function showMenuModal() {
  var menuSel = document.getElementById('rest-menu-date');
  var date = menuSel.value;
  var menu = (restaurantMenus[currentRestaurant] && restaurantMenus[currentRestaurant][date]) || [];
  var body = document.getElementById('menuModalBody');
  if (menu.length === 0) {
    body.innerHTML = '<div class="text-muted">No menu available for this date.</div>';
  } else {
    var html = '<ul class="list-group">';
    menu.forEach(function(item) {
      html += `<li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div><strong>${item.name}</strong><br><span class="text-muted small">${item.desc}</span></div>
        <span class="fw-bold">${item.price}</span>
      </li>`;
    });
    html += '</ul>';
    body.innerHTML = html;
  }
  var menuModal = new bootstrap.Modal(document.getElementById('menuModal'));
  menuModal.show();
}

function openReviewModal(businessName) {
  document.getElementById('reviewBusiness').value = businessName;
  document.getElementById('reviewForm').reset();
  var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
  reviewModal.show();
}

function editReview(index) {
  // Fetch review data from PHP array (rendered as JS object)
  var reviews = <?php echo json_encode($reviews); ?>;
  var r = reviews[index];
  if (!r) return;
  document.getElementById('reviewBusiness').value = r.business;
  document.getElementById('reviewForm').reset();
  document.querySelector('#reviewForm [name=rating]').value = r.rating;
  document.querySelector('#reviewForm [name=review]').value = r.review;
  if (r.visibility === 'anonymous') {
    document.getElementById('visAnon').checked = true;
  } else {
    document.getElementById('visPublic').checked = true;
  }
  document.getElementById('reviewEditId').value = index;
  var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
  reviewModal.show();
}
function deleteReview(index) {
  if (!confirm('Delete this review?')) return;
  var form = document.createElement('form');
  form.method = 'post';
  form.action = 'customer_dashboard.php';
  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'delete_review_id';
  input.value = index;
  form.appendChild(input);
  document.body.appendChild(form);
  form.submit();
}
</script>