<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect form data
    $org_name = trim($_POST['org_name']);
    $representative_name = trim($_POST['first_name']) . ' ' . trim($_POST['last_name']); // Combine names
    $accreditation_id = trim($_POST['license_number']); // Mapping license to ID
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    
    // Address fields
    $office_address = trim($_POST['office_address']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);

    // 2. Check for Duplicates in CERTIFIERS table (Not users)
    $check = $conn->prepare("SELECT id FROM certifiers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        die("<script>alert('Email already registered as a certifier.'); window.history.back();</script>");
    }
    $check->close();

    // 3. Insert into CERTIFIERS Table
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $status = 'pending';

    // Ensure this matches your database_final.sql schema exactly
    $stmt = $conn->prepare("INSERT INTO certifiers 
        (organization_name, representative_name, accreditation_id, email, phone, password_hash, office_address, city, province, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssss", 
        $org_name, 
        $representative_name, 
        $accreditation_id, 
        $email, 
        $phone, 
        $password_hash, 
        $office_address, 
        $city, 
        $province, 
        $status
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please login via the Certifier Portal.');
                window.location.href = '../login_certifier.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>