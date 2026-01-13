<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

// Ensure certifier is logged in
if (!isset($_SESSION["certifier_id"])) {
    echo json_encode(["total" => 0, "pending" => 0, "approved" => 0, "rejected" => 0]);
    exit();
}

try {
    // Queries matching the new schema
    $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected
            FROM halal_certification_applications";

    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    // Ensure integers are returned (MySQL returns strings for SUM)
    $stats = [
        "total" => (int) ($data['total'] ?? 0),
        "pending" => (int) ($data['pending'] ?? 0),
        "approved" => (int) ($data['approved'] ?? 0),
        "rejected" => (int) ($data['rejected'] ?? 0)
    ];

    echo json_encode($stats);

} catch (Exception $e) {
    // Return zeros on error
    echo json_encode(["total" => 0, "pending" => 0, "approved" => 0, "rejected" => 0]);
}

$conn->close();
?>