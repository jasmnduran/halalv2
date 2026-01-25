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

    // Check the new 'auditors' table
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password_hash, status FROM auditors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $auditor = $result->fetch_assoc();

        if (password_verify($password, $auditor['password_hash'])) {
            
            if ($auditor['status'] !== 'active') {
                 echo "<script>alert('Your auditor account is inactive.'); window.history.back();</script>";
                 exit;
            }

            // Secure Session for AUDITOR role
            session_regenerate_id(true);
            $_SESSION['auditor_id'] = $auditor['id'];
            $_SESSION['auditor_name'] = $auditor['first_name'] . ' ' . $auditor['last_name'];
            $_SESSION['role'] = 'auditor'; // Distinct role
            
            header("Location: ../audit-team.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Auditor account not found.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>