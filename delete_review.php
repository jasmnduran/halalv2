<?php
require_once "includes/db.php"; // Adjust path as needed
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    
    // Auth Check
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
        die("Unauthorized");
    }

    $review_id = intval($_POST['review_id']);
    $user_id = $_SESSION['user_id'];

    // Delete only if the review belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ? AND reviewer_id = ?");
    $stmt->bind_param("ii", $review_id, $user_id);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
}

// Redirect back to dashboard
header('Location: customer_dashboard.php');
exit;
?>