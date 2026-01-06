<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect Data
    $first_name = trim($_POST['first_name']);
    $middle_initial = trim($_POST['middle_initial']);
    $last_name = trim($_POST['last_name']);
    $gender = trim($_POST['gender']);
    
    // Construct Full Name for display purposes
    $full_name = $first_name . ($middle_initial ? ' ' . $middle_initial . '. ' : ' ') . $last_name;
    
    // Location Data
    $barangay = trim($_POST['barangay']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    $address = $barangay; // Mapping barangay to generic address field

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Check for Duplicates
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('Email already registered.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    // 3. Insert User
    $role = 'customer';
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    // Ensure your 'users' table has 'middle_initial' and 'gender' columns!
    $sql = "INSERT INTO users (name, middle_initial, gender, email, password, role, address, city, province) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    
    // Bind Params: sssssssss (9 strings)
    $stmt->bind_param("sssssssss", 
        $full_name, 
        $middle_initial, 
        $gender, 
        $email, 
        $hashed_pass, 
        $role, 
        $address, 
        $city, 
        $province
    );

    if ($stmt->execute()) {
        // Auto Login
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $full_name;
        $_SESSION['user_role'] = $role;
        
        header("Location: ../customer_dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>