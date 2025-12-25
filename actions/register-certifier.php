<?php

include '../includes/db.php'; // your DB connection file


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $org_name = $_POST['org_name'];
    $license_number = $_POST['license_number'];
    $years_experience = $_POST['years_experience'];
    $certifications = $_POST['certifications'];
    $office_address = $_POST['office_address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // ✅ Hash the password correctly
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO certifying_bodies 
        (first_name, middle_initial, last_name, age, gender, org_name, license_number, years_experience, certifications, office_address, city, province, email, phone, password_hash)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssisssisssssss",
        $first_name, $middle_initial, $last_name, $age, $gender,
        $org_name, $license_number, $years_experience, $certifications,
        $office_address, $city, $province, $email, $phone, $password_hash
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = '../login_certifier.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
