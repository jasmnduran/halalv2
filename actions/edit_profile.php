<?php
// halalv2/actions/edit_profile.php
require_once '../includes/db.php';
session_start();

// 1. Determine User Role & ID
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
} else {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Collect & Sanitize Inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $middle = trim($_POST['middle_initial'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $gender = $_POST['gender'] ?? '';
    
    // Construct Full Name for display/session
    $full_name = $first_name . ($middle ? ' ' . $middle . '. ' : ' ') . $last_name;
    
    // Address Fields
    $barangay = trim($_POST['barangay'] ?? ''); // Mapped to 'address'
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');
    
    // Note: Email usually shouldn't be editable without re-verification, 
    // but if required, add it here. The forms didn't have email inputs.

    // 3. Update Database
    $sql = "UPDATE users SET 
            name = ?, 
            middle_initial = ?, 
            last_name = ?, 
            gender = ?, 
            address = ?, 
            city = ?, 
            province = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", 
        $full_name, 
        $middle, 
        $last_name, 
        $gender, 
        $barangay, 
        $city, 
        $province, 
        $id
    );

    if ($stmt->execute()) {
        // 4. Update Session Data
        if ($_SESSION['user_role'] === 'customer') {
            $_SESSION['user_name'] = $full_name; // Update display name
            header("Location: ../customer_dashboard.php");
        } else {
            $_SESSION['owner']['name'] = $full_name;
            $_SESSION['owner']['location'] = $city;
            header("Location: ../owner_dashboard.php");
        }
        exit;
    } else {
        echo "Error updating profile: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>