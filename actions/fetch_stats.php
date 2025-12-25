<?php
require_once "../includes/db.php";
session_start();

$certifier_id = $_SESSION["certifier_id"];

$stats = [
    "total" => 0,
    "pending" => 0,
    "approved" => 0,
    "rejected" => 0
];

$sql = "SELECT 
            COUNT(*) AS total,
            SUM(status = 'Pending') AS pending,
            SUM(status = 'Approved') AS approved,
            SUM(status = 'Rejected') AS rejected
        FROM applications
        WHERE certifier_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certifier_id);
$stmt->execute();
$stmt->bind_result($total, $pending, $approved, $rejected);
$stmt->fetch();

$stats = [
    "total" => (int)$total,
    "pending" => (int)$pending,
    "approved" => (int)$approved,
    "rejected" => (int)$rejected
];

echo json_encode($stats);

$stmt->close();
$conn->close();
?>
