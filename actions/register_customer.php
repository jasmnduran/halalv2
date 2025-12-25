<?php
include '../includes/db.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email, barangay, city, province, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $first_name, $last_name, $email, $barangay, $city, $province, $password);

if ($stmt->execute()) {
    header('Location: ../login_customer.php');
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?> 