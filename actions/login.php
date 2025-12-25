<?php
include '../includes/db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Determine login source by HTTP_REFERER
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

if (strpos($referer, 'login_customer.php') !== false) {
    // Customer login
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['id'];
            $_SESSION['user'] = [
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'city' => $user['city'] ?? '',
                'profile_views' => $user['profile_views'] ?? '0',
                'rating' => $user['rating'] ?? '0'
            ];
            header('Location: ../customer_dashboard.php');
            exit;
        }
    }
    
    // Fallback: Allow login even if no record exists
    // Create a temporary session for demo purposes
    $_SESSION['customer_id'] = 'demo_' . time();
    $_SESSION['user'] = [
        'name' => explode('@', $email)[0], // Use email prefix as name
        'first_name' => explode('@', $email)[0],
        'last_name' => 'User',
        'email' => $email,
        'city' => 'Demo City',
        'profile_views' => '0',
        'rating' => '0'
    ];
    header('Location: ../customer_dashboard.php');
    exit;
    
} elseif (strpos($referer, 'login_owner.php') !== false) {
    // Business owner login
    $stmt = $conn->prepare("SELECT * FROM business_owners WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['owner_id'] = $user['id'];
            $_SESSION['owner'] = [
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'location' => $user['city'] ?? '',
                'profile_views' => $user['profile_views'] ?? '0',
                'rating' => $user['rating'] ?? '0',
                'market_score' => $user['market_score'] ?? '85',
                'muslim_population' => $user['muslim_population'] ?? '15000',
                'competition' => $user['competition'] ?? '12',
                'market_insight' => $user['market_insight'] ?? 'High potential area',
                'certificate_status' => $user['certificate_status'] ?? 'Active',
                'certificate_expiry' => $user['certificate_expiry'] ?? '2025-12-31',
                'halal_rating' => $user['halal_rating'] ?? '4.5',
                'total_reviews' => $user['total_reviews'] ?? '23',
                'unresolved_claims' => $user['unresolved_claims'] ?? '2',
                'recent_feedback' => $user['recent_feedback'] ?? 'Great halal food!',
                'premium' => $user['premium'] ?? false,
                'starter_pack_progress' => $user['starter_pack_progress'] ?? '60',
                'modules' => [
                    ['name' => 'Basic Guidelines', 'complete' => true],
                    ['name' => 'Kitchen Setup', 'complete' => true],
                    ['name' => 'Staff Training', 'complete' => false],
                    ['name' => 'Certification Process', 'complete' => false]
                ],
                'activity_feed' => [
                    'New review received from Fatima Ali',
                    'Market insights updated',
                    'Halal certificate renewed'
                ]
            ];
            header('Location: ../owner_dashboard.php');
            exit;
        }
    }
    
    // Fallback: Allow login even if no record exists
    // Create a temporary session for demo purposes
    $_SESSION['owner_id'] = 'demo_' . time();
    $_SESSION['owner'] = [
        'name' => explode('@', $email)[0], // Use email prefix as name
        'first_name' => explode('@', $email)[0],
        'last_name' => 'Owner',
        'email' => $email,
        'location' => 'Demo City',
        'profile_views' => '0',
        'rating' => '0',
        'market_score' => '85',
        'muslim_population' => '15000',
        'competition' => '12',
        'market_insight' => 'High potential area',
        'certificate_status' => 'Active',
        'certificate_expiry' => '2025-12-31',
        'halal_rating' => '4.5',
        'total_reviews' => '23',
        'unresolved_claims' => '2',
        'recent_feedback' => 'Great halal food!',
        'premium' => false,
        'starter_pack_progress' => '60',
        'modules' => [
            ['name' => 'Basic Guidelines', 'complete' => true],
            ['name' => 'Kitchen Setup', 'complete' => true],
            ['name' => 'Staff Training', 'complete' => false],
            ['name' => 'Certification Process', 'complete' => false]
        ],
        'activity_feed' => [
            'New review received from Fatima Ali',
            'Market insights updated',
            'Halal certificate renewed'
        ]
    ];
    header('Location: ../owner_dashboard.php');
    exit;
    
} else {
    // Unknown login source - default to owner dashboard
    $_SESSION['owner_id'] = 'demo_' . time();
    $_SESSION['owner'] = [
        'name' => explode('@', $email)[0], // Use email prefix as name
        'first_name' => explode('@', $email)[0],
        'last_name' => 'Owner',
        'email' => $email,
        'location' => 'Demo City',
        'profile_views' => '0',
        'rating' => '0',
        'market_score' => '85',
        'muslim_population' => '15000',
        'competition' => '12',
        'market_insight' => 'High potential area',
        'certificate_status' => 'Active',
        'certificate_expiry' => '2025-12-31',
        'halal_rating' => '4.5',
        'total_reviews' => '23',
        'unresolved_claims' => '2',
        'recent_feedback' => 'Great halal food!',
        'premium' => false,
        'starter_pack_progress' => '60',
        'modules' => [
            ['name' => 'Basic Guidelines', 'complete' => true],
            ['name' => 'Kitchen Setup', 'complete' => true],
            ['name' => 'Staff Training', 'complete' => false],
            ['name' => 'Certification Process', 'complete' => false]
        ],
        'activity_feed' => [
            'New review received from Fatima Ali',
            'Market insights updated',
            'Halal certificate renewed'
        ]
    ];
    header('Location: ../owner_dashboard.php');
    exit;
}
?> 