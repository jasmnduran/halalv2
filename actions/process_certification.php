<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

try {
    $conn->begin_transaction();

    // 1. Prepare Application Data
    $undertaking = isset($_POST['undertaking_agreement']) ? 1 : 0;
    
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
    if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

    $stmt->bind_param("sssssssssssssiss", 
        $_POST['applicant_name'], $_POST['company_name'], $_POST['business_address'], 
        $_POST['mailing_address'], $_POST['ownership_type'], $_POST['contact_person'], 
        $_POST['telephone'], $_POST['email'], $_POST['application_type'], 
        $_POST['certification_type'], $_POST['halal_seminar_date'], 
        $_POST['first_audit_date'], $_POST['final_audit_date'], 
        $undertaking, $_POST['signature'], $_POST['application_date']
    );

    if (!$stmt->execute()) throw new Exception("Database error: " . $stmt->error);
    $app_id = $conn->insert_id;

    // 2. Secure File Uploads
    $uploadDir = "../uploads/documents/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true); // 0755 is safer than 0777

    // Allowed MIME types and Extensions
    $allowedTypes = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    $docStmt = $conn->prepare("INSERT INTO application_documents (application_id, document_type, file_path) VALUES (?, ?, ?)");

    foreach ($_FILES as $key => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            
            // Security Checks
            if ($file['size'] > $maxFileSize) {
                throw new Exception("File too large: " . $file['name']);
            }
            
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            if (!array_key_exists($mime, $allowedTypes)) {
                throw new Exception("Invalid file type for " . $file['name'] . ". Only PDF and Images allowed.");
            }

            // Generate Safe Filename
            $ext = $allowedTypes[$mime];
            $safeName = $app_id . "_" . uniqid() . "." . $ext;
            $destination = $uploadDir . $safeName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $docType = ucfirst(str_replace("_", " ", $key)); 
                $webPath = "uploads/documents/" . $safeName;
                
                $docStmt->bind_param("iss", $app_id, $docType, $webPath);
                $docStmt->execute();
            } else {
                throw new Exception("Failed to move uploaded file.");
            }
        }
    }

    // 3. Save Additional Details
    $detailStmt = $conn->prepare("INSERT INTO application_details (application_id, detail_type, detail_value) VALUES (?, ?, ?)");
    $dynamicFields = ['product_list', 'establishment_capacity', 'abattoir_capacity', 'product_categories', 'establishment_type', 'animal_types'];
    
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
    error_log("Application Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>