<?php
$host = 'localhost';
$db   = 'halalkeeps';
$user = 'root';
$pass = ''; // Set your database password here

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false, 
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Set charset to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");
?>