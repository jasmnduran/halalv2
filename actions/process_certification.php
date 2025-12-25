<?php
session_start();
include '../includes/db.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $applicant_name = $_POST['applicant_name'] ?? '';
        $company_name = $_POST['company_name'] ?? '';
        $business_address = $_POST['business_address'] ?? '';
        $mailing_address = $_POST['mailing_address'] ?? '';
        $ownership_type = $_POST['ownership_type'] ?? '';
        $contact_person = $_POST['contact_person'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $email = $_POST['email'] ?? '';
        $application_type = $_POST['application_type'] ?? '';
        $certification_type = $_POST['certification_type'] ?? '';
        $halal_seminar_date = $_POST['halal_seminar_date'] ?? '';
        $first_audit_date = $_POST['first_audit_date'] ?? '';
        $final_audit_date = $_POST['final_audit_date'] ?? '';
        $undertaking_agreement = isset($_POST['undertaking_agreement']) ? 1 : 0;
        $signature = $_POST['signature'] ?? '';
        $application_date = $_POST['application_date'] ?? '';

        // Validate required fields
        $required_fields = [
            'applicant_name', 'company_name', 'business_address', 'ownership_type',
            'contact_person', 'telephone', 'email', 'application_type', 'certification_type',
            'halal_seminar_date', 'first_audit_date', 'final_audit_date', 'signature', 'application_date'
        ];

        $missing_fields = [];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }

        if (!empty($missing_fields)) {
            throw new Exception('Please fill in all required fields: ' . implode(', ', $missing_fields));
        }

        if (!$undertaking_agreement) {
            throw new Exception('You must agree to the undertaking terms.');
        }

        // Handle file uploads
        $uploaded_documents = [];
        $upload_dir = '../uploads/certification_documents/';
        
        // Create upload directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Process uploaded files
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $filename = $file['name'];
                $temp_name = $file['tmp_name'];
                $upload_path = $upload_dir . time() . '_' . $filename;
                
                if (move_uploaded_file($temp_name, $upload_path)) {
                    $uploaded_documents[$key] = $upload_path;
                }
            }
        }

        // Insert application into database
        $stmt = $conn->prepare("
            INSERT INTO halal_certification_applications (
                applicant_name, company_name, business_address, mailing_address,
                ownership_type, contact_person, telephone, email, application_type,
                certification_type, halal_seminar_date, first_audit_date, final_audit_date,
                undertaking_agreement, signature, application_date, status, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
        ");

        // ✅ Added error checking
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // ✅ Corrected type string ("i" for integer undertaking_agreement)
        $stmt->bind_param("ssssssssssssisss",
            $applicant_name, $company_name, $business_address, $mailing_address,
            $ownership_type, $contact_person, $telephone, $email, $application_type,
            $certification_type, $halal_seminar_date, $first_audit_date, $final_audit_date,
            $undertaking_agreement, $signature, $application_date
        );

        if ($stmt->execute()) {
            $application_id = $conn->insert_id;
            
            // Store uploaded documents information
            if (!empty($uploaded_documents)) {
                foreach ($uploaded_documents as $doc_key => $doc_path) {
                    $doc_stmt = $conn->prepare("
                        INSERT INTO application_documents (application_id, document_type, file_path, uploaded_at)
                        VALUES (?, ?, ?, NOW())
                    ");
                    if (!$doc_stmt) {
                        die("Document insert prepare failed: " . $conn->error);
                    }
                    $doc_stmt->bind_param("iss", $application_id, $doc_key, $doc_path);
                    $doc_stmt->execute();
                    $doc_stmt->close();
                }
            }

            // Send confirmation email (optional)
            $subject = "Halal Certification Application Received";
            $message = "Dear $applicant_name,\n\n";
            $message .= "Your halal certification application has been received successfully.\n";
            $message .= "Application ID: #$application_id\n";
            $message .= "We will review your application and contact you within 5-7 business days.\n\n";
            $message .= "Thank you for choosing Halal Keeps!\n\n";
            $message .= "Best regards,\nHalal Keeps Team";

            // mail($email, $subject, $message);

            // Remember last submitted application in the session
            $_SESSION['last_application_id'] = $application_id;

            // Redirect back to owner dashboard with success modal
            header('Location: ../owner_dashboard.php?submitted=1&id=' . $application_id);
            exit;
        } else {
            throw new Exception('Failed to save application. Please try again.');
        }

    } catch (Exception $e) {
        $error_message = $e->getMessage();
        header('Location: ../halal_certification_application.php?error=' . urlencode($error_message));
        exit;
    }
} else {
    header('Location: ../halal_certification_application.php');
    exit;
}
?>
