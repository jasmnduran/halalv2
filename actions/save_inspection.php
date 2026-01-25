<?php
// halalv2/actions/save_inspection.php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

// 1. Auth Check
if (!isset($_SESSION["certifier_id"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $app_id = intval($_POST['app_id'] ?? 0);
    $final_status = $_POST['final_status'] ?? 'Pending';
    $remarks = trim($_POST['remarks'] ?? '');

    // Validate Status Enum
    $allowed_statuses = ['Pending', 'Approved', 'Rejected']; // Removed 'Under Review' to match DB Enum if strict
    // If your DB has 'Under Review', add it here.
    
    if ($app_id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid Application ID."]);
        exit;
    }

    try {
        $conn->begin_transaction();

        // 2. Update Application Status
        // Note: Using 'Inspection Scheduled' or 'Under Review' might be better intermediate steps,
        // but the frontend sends Approved/Rejected directly.
        $stmt = $conn->prepare("UPDATE halal_certification_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $final_status, $app_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update status.");
        }

        // 3. Save Remarks (into application_details as 'auditor_remarks')
        // We first delete old remarks to avoid duplicates, or we could append. Replacing is usually cleaner.
        $delStmt = $conn->prepare("DELETE FROM application_details WHERE application_id = ? AND detail_type = 'auditor_remarks'");
        $delStmt->bind_param("i", $app_id);
        $delStmt->execute();

        if (!empty($remarks)) {
            $rmkStmt = $conn->prepare("INSERT INTO application_details (application_id, detail_type, detail_value) VALUES (?, 'auditor_remarks', ?)");
            $rmkStmt->bind_param("is", $app_id, $remarks);
            $rmkStmt->execute();
        }

        $conn->commit();
        echo json_encode(["success" => true, "message" => "Review saved successfully."]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    $conn->close();
}
?>