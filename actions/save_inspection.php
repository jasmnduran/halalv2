<?php
require_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $certifier_id = $_SESSION["certifier_id"];
    $company_name = $_POST["company_name"];
    $contact_person = $_POST["contact_person"];
    $address = $_POST["address"];
    $contact_no = $_POST["contact_no"];
    $audit_date = $_POST["audit_date"];
    $auditor_notes = $_POST["auditor_notes"];
    $documents = json_decode($_POST["documents"], true);

    $stmtApp = $conn->prepare("INSERT INTO applications (company_name, contact_person, address, contact_no, status, certifier_id) VALUES (?, ?, ?, ?, 'Reviewing', ?)");
    $stmtApp->bind_param("ssssi", $company_name, $contact_person, $address, $contact_no, $certifier_id);
    $stmtApp->execute();
    $application_id = $stmtApp->insert_id;
    $stmtApp->close();

    
    $stmtAudit = $conn->prepare("INSERT INTO audit_inspections (application_id, certifier_id, audit_date, notes) VALUES (?, ?, ?, ?)");
    $stmtAudit->bind_param("iiss", $application_id, $certifier_id, $audit_date, $auditor_notes);
    $stmtAudit->execute();
    $audit_id = $stmtAudit->insert_id;
    $stmtAudit->close();

    $stmtDoc = $conn->prepare("INSERT INTO document_checklist (audit_id, document_no, document_name, status, remarks) VALUES (?, ?, ?, ?, ?)");
    foreach ($documents as $doc) {
        $stmtDoc->bind_param("iisss", $audit_id, $doc['id'], $doc['name'], $doc['status'], $doc['remarks']);
        $stmtDoc->execute();
    }
    $stmtDoc->close();

    echo json_encode(["success" => true, "message" => "Inspection saved successfully."]);
}
?>
