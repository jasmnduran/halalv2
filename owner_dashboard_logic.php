<?php
// Use session data if available, otherwise fallback to sample data
if (isset($_SESSION['owner']) && !empty($_SESSION['owner'])) {
    $owner = $_SESSION['owner'];
} else {
    // Fallback sample data for business owner dashboard
    $owner = [
        'name' => 'Demo Owner',
        'location' => 'Demo City',
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
        'premium' => false,
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