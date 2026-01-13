<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $app_id = intval($_POST['app_id']);
    $verdict = $_POST['final_verdict']; // 'Approved' or 'Rejected'
    
    // In a real system, you would verify the session auditor here
    // if(!isset($_SESSION['auditor_id'])) die...

    // 1. Prepare Inspection Data (serialized for simple storage)
    $inspection_data = json_encode([
        'materials' => ['status' => $_POST['check_materials'], 'remarks' => $_POST['rem_materials']],
        'storage' => ['status' => $_POST['check_storage'], 'remarks' => $_POST['rem_storage']],
        'process' => ['status' => $_POST['check_process'], 'remarks' => $_POST['rem_process']],
        'waste' => ['status' => $_POST['check_waste'], 'remarks' => $_POST['rem_waste']],
        'auditor_date' => date('Y-m-d H:i:s')
    ]);

    // 2. Update Application Status
    $stmt = $conn->prepare("UPDATE halal_certification_applications SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $verdict, $app_id);

    if ($stmt->execute()) {
        // 3. Log Detailed Findings (Optional: Save to details table)
        $detailStmt = $conn->prepare("INSERT INTO application_details (application_id, detail_type, detail_value) VALUES (?, 'audit_report', ?)");
        $detailStmt->bind_param("is", $app_id, $inspection_data);
        $detailStmt->execute();

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed"]);
    }

    $stmt->close();
    $conn->close();
}
?>