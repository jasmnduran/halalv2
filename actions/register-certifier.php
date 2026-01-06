<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect form data
    $first_name = trim($_POST['first_name']);
    $middle_initial = trim($_POST['middle_initial']);
    $last_name = trim($_POST['last_name']);
    $age = intval($_POST['age']);
    $gender = trim($_POST['gender']);
    
    $org_name = trim($_POST['org_name']);
    $license_number = trim($_POST['license_number']);
    $years_experience = intval($_POST['years_experience']);
    $certifications = trim($_POST['certifications']);
    
    $office_address = trim($_POST['office_address']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    // 2. Validate Uniqueness
    $check = $conn->prepare("SELECT id FROM certifying_bodies WHERE email = ? OR license_number = ?");
    $check->bind_param("ss", $email, $license_number);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('Email or License Number already registered.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    // 3. Hash Password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insert into `certifying_bodies`
    $sql = "INSERT INTO certifying_bodies 
        (first_name, middle_initial, last_name, age, gender, org_name, license_number, years_experience, certifications, office_address, city, province, email, phone, password_hash)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Bind Params: 
    // sssis ssi sssssss (15 params)
    // age and years_exp are integers (i)
    $stmt->bind_param("sssisssisssssss",
        $first_name, $middle_initial, $last_name, $age, $gender,
        $org_name, $license_number, $years_experience, $certifications,
        $office_address, $city, $province, $email, $phone, $password_hash
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please login.');
                window.location.href = '../login_certifier.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>