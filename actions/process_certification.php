<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

// 1. Basic Validation
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

try {
    $conn->begin_transaction();

    // Prepare variables (Sanitization happens via bind_param)
    $undertaking = isset($_POST['undertaking_agreement']) ? 1 : 0;
    
    // 2. Insert Main Application (COMPLETE QUERY)
    $sql = "INSERT INTO halal_certification_applications 
        (
            applicant_name, company_name, business_address, mailing_address, 
            ownership_type, contact_person, telephone, email, 
            application_type, certification_type, 
            halal_seminar_date, first_audit_date, final_audit_date, 
            undertaking_agreement, signature, application_date, 
            status
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind 16 Parameters: 
    // s (string) x 13
    // i (integer) x 1 - for undertaking
    // s (string) x 2
    $stmt->bind_param("sssssssssssssiss", 
        $_POST['applicant_name'], 
        $_POST['company_name'], 
        $_POST['business_address'], 
        $_POST['mailing_address'], 
        $_POST['ownership_type'], 
        $_POST['contact_person'], 
        $_POST['telephone'], 
        $_POST['email'], 
        $_POST['application_type'], 
        $_POST['certification_type'],
        $_POST['halal_seminar_date'],
        $_POST['first_audit_date'],
        $_POST['final_audit_date'],
        $undertaking,               // Integer (1 or 0)
        $_POST['signature'],
        $_POST['application_date']
    );

    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }
    $app_id = $conn->insert_id;

    // 3. Handle File Uploads (Same as before)
    $uploadDir = "../uploads/documents/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $docStmt = $conn->prepare("INSERT INTO application_documents (application_id, document_type, file_path) VALUES (?, ?, ?)");

    foreach ($_FILES as $key => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $file['tmp_name'];
            $name = basename($file['name']);
            $safeName = $app_id . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $name);
            $destination = $uploadDir . $safeName;

            if (move_uploaded_file($tmp_name, $destination)) {
                $docType = ucfirst(str_replace("_", " ", $key)); 
                $webPath = "uploads/documents/" . $safeName;
                
                $docStmt->bind_param("iss", $app_id, $docType, $webPath);
                $docStmt->execute();
            }
        }
    }

    // 4. Save Additional Details (Same as before)
    $detailStmt = $conn->prepare("INSERT INTO application_details (application_id, detail_type, detail_value) VALUES (?, ?, ?)");
    
    $dynamicFields = ['product_list', 'establishment_capacity', 'abattoir_capacity'];
    foreach ($dynamicFields as $field) {
        if (!empty($_POST[$field])) {
            $detailStmt->bind_param("iss", $app_id, $field, $_POST[$field]);
            $detailStmt->execute();
        }
    }

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Application submitted successfully!", "id" => $app_id]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>