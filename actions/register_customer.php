<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect Data
    $first_name = trim($_POST['first_name'] ?? '');
    $middle_initial = trim($_POST['middle_initial'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    
    // Construct Full Name for display purposes
    $full_name = $first_name . ($middle_initial ? ' ' . $middle_initial . '. ' : ' ') . $last_name;
    
    // Location Data
    $barangay = trim($_POST['barangay'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $address = $barangay; 

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password) || empty($first_name)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

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

    // FIXED: Added 'last_name' to the query matches schema
    $sql = "INSERT INTO users (name, middle_initial, last_name, gender, email, password, role, address, city, province) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    
    // Bind Params: 10 strings
    $stmt->bind_param("ssssssssss", 
        $full_name, 
        $middle_initial, 
        $last_name, 
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
        session_regenerate_id(true);
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $full_name;
        $_SESSION['user_role'] = $role;
        
        header("Location: ../customer_dashboard.php");
        exit();
    } else {
        // Log error internally, show generic to user
        error_log("Customer Register Error: " . $stmt->error);
        echo "<script>alert('An error occurred during registration.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>