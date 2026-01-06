<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("Please enter email and password.");
    }

    // Check Certifiers Table
    $stmt = $conn->prepare("SELECT id, organization_name, representative_name, password_hash, status FROM certifiers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $certifier = $result->fetch_assoc();

        if (password_verify($password, $certifier['password_hash'])) {
            
            if ($certifier['status'] !== 'active' && $certifier['status'] !== 'approved') {
                // Optional: Block pending accounts
                // die("Your account is still pending approval.");
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