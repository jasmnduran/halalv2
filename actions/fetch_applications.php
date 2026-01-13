<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["certifier_id"])) {
    echo json_encode([]);
    exit();
}

try {
    // Select fields from the new table
    $sql = "SELECT 
                id, 
                company_name, 
                application_date, 
                status 
            FROM halal_certification_applications 
            ORDER BY created_at DESC 
            LIMIT 20";

    $result = $conn->query($sql);
    $applications = [];

    while ($row = $result->fetch_assoc()) {
        // Map to the format the frontend expects
        $applications[] = [
            "application_id" => $row['id'],
            "company_name" => $row['company_name'],
            "submission_date" => $row['application_date'], // YYYY-MM-DD
            "status" => ucfirst($row['status']) // Capitalize status
        ];
    }

    echo json_encode($applications);

} catch (Exception $e) {
    echo json_encode([]);
}

$conn->close();
?>