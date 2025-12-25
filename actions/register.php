<?php 
include '../includes/db.php'; 
$first_name = $_POST['first_name'];
$middle_initial = $_POST['middle_initial'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$email = $_POST['email']; 
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$stmt = $conn->prepare("INSERT INTO business_owners (first_name, middle_initial, last_name, age, gender, barangay, city, province, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
$stmt->bind_param("sssissssss", $first_name, $middle_initial, $last_name, $age, $gender, $barangay, $city, $province, $email, $password); 
if ($stmt->execute()) { 
    header('Location: ../login_owner.php');
    exit;
} else { 
    echo "Error: " . $stmt->error; 
} 
?> 
