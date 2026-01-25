<?php
require_once "../includes/db.php";
session_start();
header('Content-Type: application/json');

// FIXED: Check for auditor_id
if (!isset($_SESSION['auditor_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized: Auditors only."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $app_id = intval($_POST['app_id'] ?? 0);
    $verdict = $_POST['final_verdict'] ?? ''; 
    
    if ($app_id <= 0 || !in_array($verdict, ['Approved', 'Rejected'])) {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
        exit;
    }

    // Capture Auditor ID in the JSON report
    $inspection_data = json_encode([
        'materials' => ['status' => $_POST['check_materials']??0, 'remarks' => $_POST['rem_materials']??''],
        'storage' => ['status' => $_POST['check_storage']??0, 'remarks' => $_POST['rem_storage']??''],
        'process' => ['status' => $_POST['check_process']??0, 'remarks' => $_POST['rem_process']??''],
        'waste' => ['status' => $_POST['check_waste']??0, 'remarks' => $_POST['rem_waste']??''],
        'auditor_id' => $_SESSION['auditor_id'], // Storing WHO did the audit
        'auditor_name' => $_SESSION['auditor_name'],
        'audit_date' => date('Y-m-d H:i:s')
    ]);

    // Update DB
    $stmt = $conn->prepare("UPDATE halal_certification_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $verdict, $app_id);

    if ($stmt->execute()) {
        // Save Report
        $delStmt = $conn->prepare("DELETE FROM application_details WHERE application_id = ? AND detail_type = 'audit_report'");
        $delStmt->bind_param("i", $app_id);
        $delStmt->execute();

        $detailStmt = $conn->prepare("INSERT INTO application_details (application_id, detail_type, detail_value) VALUES (?, 'audit_report', ?)");
        $detailStmt->bind_param("is", $app_id, $inspection_data);
        $detailStmt->execute();

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed."]);
    }

    $stmt->close();
    $conn->close();
}
?>