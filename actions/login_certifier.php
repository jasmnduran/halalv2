<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter email and password.'); window.history.back();</script>";
        exit;
    }

    // Check Certifiers Table
    $stmt = $conn->prepare("SELECT id, organization_name, representative_name, password_hash, status FROM certifiers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $certifier = $result->fetch_assoc();

        if (password_verify($password, $certifier['password_hash'])) {
            
            // FIXED: Enforce Account Status Check
            if ($certifier['status'] !== 'active' && $certifier['status'] !== 'approved') {
                 echo "<script>alert('Your account is currently " . htmlspecialchars($certifier['status']) . ". Please wait for admin approval.'); window.history.back();</script>";
                 exit;
            }

            session_regenerate_id(true);
            $_SESSION['certifier_id'] = $certifier['id'];
            $_SESSION['certifier_org'] = $certifier['organization_name'];
            $_SESSION['certifier_name'] = $certifier['representative_name'];
            
            header("Location: ../halal_certifying_body.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>