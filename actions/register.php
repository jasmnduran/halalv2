<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize and Collect Inputs
    $first_name = trim($_POST['first_name']);
    $middle_initial = trim($_POST['middle_initial']);
    $last_name = trim($_POST['last_name']);
    $age = intval($_POST['age']);
    $gender = trim($_POST['gender']);
    
    $business_name = trim($_POST['business_name']); // Required for dashboard
    $barangay = trim($_POST['barangay']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Validate Email Uniqueness
    $checkStmt = $conn->prepare("SELECT id FROM business_owners WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        echo "<script>alert('Email already registered.'); window.history.back();</script>";
        exit();
    }
    $checkStmt->close();

    // 3. Hash Password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insert (Ensure 'business_name' column exists in your DB!)
    $sql = "INSERT INTO business_owners 
            (first_name, middle_initial, last_name, age, gender, business_name, barangay, city, province, email, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    
    // Bind: s=string, i=integer
    // ss s i s s s s s s s (11 params)
    $stmt->bind_param("sssisssssss", 
        $first_name, 
        $middle_initial, 
        $last_name, 
        $age, 
        $gender, 
        $business_name, 
        $barangay, 
        $city, 
        $province, 
        $email, 
        $password_hash
    );

    if ($stmt->execute()) {
        // Auto-login session variables
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;
        $_SESSION['user_role'] = 'owner';
        $_SESSION['business_name'] = $business_name;

        header('Location: ../login_owner.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>