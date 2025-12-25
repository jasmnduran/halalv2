<?php 
header('Content-Type: application/json'); 
include '../includes/db.php'; 
$id = $_GET['id'] ?? 0; 
$result = $conn->query("SELECT id, name, email FROM users WHERE 
id=$id"); 
if ($result->num_rows > 0) { 
echo json_encode($result->fetch_assoc()); 
} else { 
echo json_encode(["error" => "User not found."]); 
} 
?> 

