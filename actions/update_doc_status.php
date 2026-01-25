<?php
// halalv2/actions/update_doc_status.php
require_once "../includes/db.php";
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["certifier_id"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$doc_id = intval($_POST['doc_id'] ?? 0);
$status = $_POST['status'] ?? '';

// Validate status enum from schema
if (!in_array($status, ['compliant', 'non_compliant', 'pending'])) {
    echo json_encode(["success" => false, "message" => "Invalid status"]);
    exit;
}

if ($doc_id > 0) {
    $stmt = $conn->prepare("UPDATE application_documents SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $doc_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
}
?>