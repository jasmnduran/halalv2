<?php
// halalv2/actions/register-certifier.php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize & Collect Inputs
    $org_name = trim($_POST['org_name'] ?? '');
    
    // Combine names if your form splits them, or just use one
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $representative_name = $first_name . ' ' . $last_name;

    $accreditation_id = trim($_POST['license_number'] ?? ''); // Maps Form 'license_number' to DB 'accreditation_id'
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $office_address = trim($_POST['office_address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');

    // 2. Validation: Check for Empty Fields
    if (empty($org_name) || empty($email) || empty($password) || empty($accreditation_id)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit;
    }

    // 3. Validation: Check for Duplicates (Email OR License Number)
    // This prevents the SQL crash if the license is already taken
    $checkSql = "SELECT id FROM certifiers WHERE email = ? OR accreditation_id = ?";
    $check = $conn->prepare($checkSql);

    if (!$check) {
        // This confirms the table is missing or SQL is wrong
        die("Database Error: Table 'certifiers' likely missing. Error: " . $conn->error);
    }

    $check->bind_param("ss", $email, $accreditation_id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('Email or Accreditation ID already registered.'); window.history.back();</script>";
        exit;
    }
    $check->close();

    // 4. Insert New Certifier
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $status = 'pending'; // Default status requires Admin Approval

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
        // 5. SUCCESS: Redirect to the PHP login page, NOT the .html file
        echo "<script>
                alert('Registration successful! Your account is pending approval. Please log in once approved.');
                window.location.href = '../login_certifier.php'; 
              </script>";
    } else {
        // Log the actual error for the developer, show generic message to user
        error_log("Certifier Registration Error: " . $stmt->error);
        echo "<script>alert('System Error: Could not register account. Please try again later.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>