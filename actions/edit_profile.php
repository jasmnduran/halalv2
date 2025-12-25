<?php 
session_start(); 
include '../includes/db.php'; 
$name = $_POST['name']; 
$email = $_POST['email']; 
$id = $_SESSION['user']['id']; 
$stmt = $conn->prepare("UPDATE users SET name=?, email=? 
WHERE id=?"); 
$stmt->bind_param("ssi", $name, $email, $id); 
$stmt->execute(); 
$_SESSION['user']['name'] = $name; 
$_SESSION['user']['email'] = $email; 
header("Location: ../dashboard.php"); 
?> 
