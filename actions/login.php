<?php
// halalv2/actions/login.php
require_once '../includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?error=empty_fields");
        exit;
    }

    // 1. Query the unified 'users' table
    $stmt = $conn->prepare("SELECT id, name, last_name, email, password, role, city, business_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 2. Verify Password
        if (password_verify($password, $user['password'])) {
            // 3. Secure Session
            session_regenerate_id(true);
            
            // Common Session Data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // 4. Role-Specific Redirection and Session Setup
            if ($user['role'] === 'customer') {
                $_SESSION['customer_id'] = $user['id'];
                $_SESSION['user'] = [
                    'name' => $user['name'] . ' ' . $user['last_name'],
                    'first_name' => $user['name'],
                    'email' => $user['email'],
                    'city' => $user['city']
                ];
                header('Location: ../customer_dashboard.php');
                exit;

            } elseif ($user['role'] === 'owner') {
                $_SESSION['owner_id'] = $user['id'];
                $_SESSION['owner'] = [
                    'name' => $user['name'] . ' ' . $user['last_name'],
                    'business_name' => $user['business_name'],
                    'email' => $user['email'],
                    'location' => $user['city']
                    // Note: Additional static demo data (market_score, etc.) 
                    // should be fetched from real tables (e.g. market_insights) 
                    // rather than hardcoded in session if you want a real system.
                ];
                header('Location: ../owner_dashboard.php');
                exit;
            }
        }
    }

    // Login Failed
    echo "<script>alert('Invalid email or password.'); window.history.back();</script>";
    exit;
}
?>