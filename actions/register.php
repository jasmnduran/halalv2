<?php
// halalv2/actions/register.php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize Inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $middle_initial = trim($_POST['middle_initial'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    // $age = intval($_POST['age']); // REMOVED: Column does not exist in 'users' table
    $gender = trim($_POST['gender'] ?? '');
    
    $business_name = trim($_POST['business_name'] ?? '');
    $barangay = trim($_POST['barangay'] ?? ''); // Maps to 'address'
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate Required Fields
    if (empty($email) || empty($password) || empty($first_name)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    // 2. Validate Email Uniqueness (Check 'users' table)
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        echo "<script>alert('Email already registered.'); window.history.back();</script>";
        exit();
    }
    $checkStmt->close();

    // 3. Hash Password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insert into 'users' table
    // Mapping: name = first_name, address = barangay, role = 'owner'
    $sql = "INSERT INTO users 
            (name, middle_initial, last_name, gender, business_name, address, city, province, email, password, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'owner')";
            
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssssss", 
        $first_name, 
        $middle_initial, 
        $last_name, 
        $gender, 
        $business_name, 
        $barangay, 
        $city, 
        $province, 
        $email, 
        $password_hash
    );

    if ($stmt->execute()) {
        // Login the user immediately
        session_regenerate_id(true);
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_role'] = 'owner';
        $_SESSION['owner'] = [
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'business_name' => $business_name
        ];

        header('Location: ../login_owner.php'); // Or redirect directly to dashboard
        exit;
    } else {
        error_log("Registration Error: " . $stmt->error);
        echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>