<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

$response = [
    'is_logged_in' => false,
    'user' => null
];

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT id, name, email, role, business_name, address FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $response['is_logged_in'] = true;
        $response['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'business' => $user['business_name'] ?? null,
            'location' => $user['address'] ?? '' // Removed 'Davao City' hardcode
        ];
    }
    $stmt->close();
} 
elseif (isset($_SESSION['certifier_id'])) {
    $response['is_logged_in'] = true;
    $response['user'] = [
        'id' => $_SESSION['certifier_id'],
        'name' => $_SESSION['certifier_name'],
        'role' => 'certifier',
        'organization' => $_SESSION['certifier_org']
    ];
}

echo json_encode($response);
$conn->close();
?>