<?php
// halalv2/includes/db.php

$host = 'localhost';
$db   = 'halalkeeps';
$user = 'root';
$pass = ''; // Ensure this matches your local environment

// Enable internal error reporting but hide from output
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Log error internally (error_log) and show generic message to user
    error_log("Database Connection Error: " . $e->getMessage());
    die(json_encode([
        "success" => false, 
        "message" => "Service temporarily unavailable. Please try again later."
    ]));
}
?>