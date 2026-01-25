<?php
// halalv2/actions/resolve_claim.php
require_once "../includes/db.php";
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['owner_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$claim_id = intval($_POST['claim_id'] ?? 0);
$owner_id = $_SESSION['owner_id'];

if ($claim_id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit;
}

// Ensure the claim belongs to the logged-in owner before updating
$stmt = $conn->prepare("UPDATE customer_claims SET status = 'resolved' WHERE id = ? AND business_id = ?");
$stmt->bind_param("ii", $claim_id, $owner_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Claim not found or already resolved."]);
}
?>