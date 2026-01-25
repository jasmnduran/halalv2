<?php
// halalv2/api/applications.php
require_once '../includes/db.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

// 1. AUTHENTICATION & ROLE CHECK
if (!isset($_SESSION['user_id']) && !isset($_SESSION['certifier_id']) && !isset($_SESSION['auditor_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Only allow GET requests for this endpoint (Submission is handled by process_certification.php)
if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// 2. DETERMINE USER CONTEXT
$is_staff = isset($_SESSION['certifier_id']) || isset($_SESSION['auditor_id']);
$owner_email = null;

if (!$is_staff && isset($_SESSION['user_id'])) {
    // If it's a business owner, get their email to restrict data
    // Assuming role 'owner' stored in session, or re-verify from DB
    $uStmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $uStmt->bind_param("i", $_SESSION['user_id']);
    $uStmt->execute();
    $res = $uStmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $owner_email = $row['email'];
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
        exit;
    }
}

// 3. HANDLE DATA FETCHING
try {
    // Filter by ID if provided
    $appId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    $sql = "SELECT id, applicant_name, company_name, status, application_date, email, certification_type 
            FROM halal_certification_applications";
    
    $types = "";
    $params = [];

    // Apply Filters
    if ($appId > 0) {
        $sql .= " WHERE id = ?";
        $types .= "i";
        $params[] = $appId;
    } elseif ($owner_email) {
        // OWNERS: Can only see their own applications
        $sql .= " WHERE email = ?";
        $types .= "s";
        $params[] = $owner_email;
    } else {
        // STAFF: Can see all. Optional status filter
        if (isset($_GET['status'])) {
            $sql .= " WHERE status = ?";
            $types .= "s";
            $params[] = $_GET['status'];
        }
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $apps = $result->fetch_all(MYSQLI_ASSOC);

    // Optional: Include Documents if specific ID requested
    if ($appId > 0 && !empty($apps)) {
        $docStmt = $conn->prepare("SELECT document_type, status, file_path FROM application_documents WHERE application_id = ?");
        $docStmt->bind_param("i", $appId);
        $docStmt->execute();
        $apps[0]['documents'] = $docStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    echo json_encode(['success' => true, 'applications' => $apps]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>