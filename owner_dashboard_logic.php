<?php
// halalv2/owner_dashboard_logic.php
require_once "includes/db.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Auth Check
if (!isset($_SESSION['owner_id'])) {
    header("Location: login_owner.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];
$owner_email = $_SESSION['owner']['email'];

// Initialize default/fallback structure
$owner = [
    'name' => $_SESSION['owner']['name'] ?? 'Owner',
    'location' => $_SESSION['owner']['location'] ?? '',
    
    // Default Metrics
    'profile_views' => 0, // No table for this yet
    'rating' => 0,
    'total_reviews' => 0,
    'unresolved_claims' => 0,
    'certificate_status' => 'Not Applied',
    'certificate_expiry' => 'N/A',
    'starter_pack_progress' => 0,
    
    // Static/Placeholder Market Data (No tables exist for these yet)
    'market_score' => 85,
    'muslim_population' => 15000,
    'competition' => 12,
    'market_insight' => 'High potential area based on recent searches.',
    'activity_feed' => []
];

try {
    // 2. Fetch Reviews Stats
    $reviewStmt = $conn->prepare("SELECT COUNT(*) as total, AVG(rating) as avg_rating FROM reviews WHERE business_id = ?");
    $reviewStmt->bind_param("i", $owner_id);
    $reviewStmt->execute();
    $revRes = $reviewStmt->get_result()->fetch_assoc();
    
    if ($revRes) {
        $owner['total_reviews'] = $revRes['total'];
        $owner['rating'] = number_format((float)$revRes['avg_rating'], 1);
    }

    // 3. Fetch Unresolved Claims
    $claimStmt = $conn->prepare("SELECT COUNT(*) as pending FROM customer_claims WHERE business_id = ? AND status = 'unresolved'");
    $claimStmt->bind_param("i", $owner_id);
    $claimStmt->execute();
    $claimRes = $claimStmt->get_result()->fetch_assoc();
    $owner['unresolved_claims'] = $claimRes['pending'] ?? 0;

    // 4. Fetch Certification Status (Linked by Email)
    // Note: Schema links Apps to Users via Email
    $certStmt = $conn->prepare("SELECT status, final_audit_date, created_at FROM halal_certification_applications WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    $certStmt->bind_param("s", $owner_email);
    $certStmt->execute();
    $certRes = $certStmt->get_result()->fetch_assoc();

    if ($certRes) {
        $owner['certificate_status'] = $certRes['status']; // e.g., 'Pending', 'Approved'
        // Mocking expiry as 1 year from final audit, or N/A
        $owner['certificate_expiry'] = $certRes['final_audit_date'] ? date('Y-m-d', strtotime($certRes['final_audit_date'] . ' +1 year')) : 'N/A';
        
        // Calculate Pseudo-Progress based on status
        $statusScores = [
            'Pending' => 25,
            'Under Review' => 50,
            'Inspection Scheduled' => 75,
            'Approved' => 100,
            'Rejected' => 0
        ];
        $owner['starter_pack_progress'] = $statusScores[$certRes['status']] ?? 20;
    }

    // 5. Generate Activity Feed (Real Data)
    // Combine recent reviews and claims into a timeline
    $feed = [];
    
    // Get recent reviews
    $recRevStmt = $conn->prepare("SELECT created_at, 'New Review Received' as type FROM reviews WHERE business_id = ? ORDER BY created_at DESC LIMIT 3");
    $recRevStmt->bind_param("i", $owner_id);
    $recRevStmt->execute();
    $res = $recRevStmt->get_result();
    while($row = $res->fetch_assoc()) $feed[] = $row;

    // Get recent claims
    $recClaimStmt = $conn->prepare("SELECT created_at, 'New Customer Claim' as type FROM customer_claims WHERE business_id = ? ORDER BY created_at DESC LIMIT 3");
    $recClaimStmt->bind_param("i", $owner_id);
    $recClaimStmt->execute();
    $res = $recClaimStmt->get_result();
    while($row = $res->fetch_assoc()) $feed[] = $row;

    // Sort combined feed
    usort($feed, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    // Format for display
    foreach (array_slice($feed, 0, 5) as $item) {
        $owner['activity_feed'][] = $item['type'] . " - " . date('M d', strtotime($item['created_at']));
    }

    if (empty($owner['activity_feed'])) {
        $owner['activity_feed'][] = "Welcome to your dashboard!";
    }

} catch (Exception $e) {
    error_log("Dashboard Logic Error: " . $e->getMessage());
    // Fail gracefully, keeping default values
}

// 6. Analytics (Placeholder - Requires 'transactions' table or similar)
$analytics = [
    'daily' => 0,
    'monthly' => 0,
    'yearly' => 0,
    'peak_hours' => 'Data unavailable',
    'recommendations' => 'Complete your Halal Certification to see market insights.'
];
?>