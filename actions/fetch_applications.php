<?php
require_once "../includes/db.php";
session_start();

$certifier_id = $_SESSION["certifier_id"];

$sql = "SELECT application_id, company_name, submission_date, status 
        FROM applications 
        WHERE certifier_id = ? 
        ORDER BY submission_date DESC 
        LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certifier_id);
$stmt->execute();
$result = $stmt->get_result();

$applications = [];
while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
}

echo json_encode($applications);

$stmt->close();
$conn->close();
?>
