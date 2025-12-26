<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/db.php';

try {
    $pdo = getPdo();
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'database_connection_failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    handleGetApplications($pdo);
    exit;
}

if ($method === 'POST') {
    handleUpsertApplication($pdo);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'method_not_allowed']);
exit;

function handleGetApplications(PDO $pdo): void
{
    $appCode = isset($_GET['app_code']) ? trim((string)$_GET['app_code']) : '';
    $status = isset($_GET['status']) ? trim((string)$_GET['status']) : '';
    $includeDocuments = isset($_GET['include_documents']) && $_GET['include_documents'] == '1';
    $includeSchedules = isset($_GET['include_schedules']) && $_GET['include_schedules'] == '1';

    if ($appCode !== '') {
        $stmt = $pdo->prepare('SELECT * FROM applications WHERE app_code = :code');
        $stmt->execute([':code' => $appCode]);
        $app = $stmt->fetch();
        if (!$app) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'application_not_found']);
            return;
        }

        if ($includeDocuments) {
            $stmt = $pdo->prepare('SELECT * FROM application_documents WHERE application_id = :id');
            $stmt->execute([':id' => $app['id']]);
            $app['documents'] = $stmt->fetchAll();
        }

        if ($includeSchedules) {
            $stmt = $pdo->prepare('SELECT * FROM inspection_schedules WHERE application_id = :id ORDER BY scheduled_date, scheduled_time');
            $stmt->execute([':id' => $app['id']]);
            $app['schedules'] = $stmt->fetchAll();
        }

        echo json_encode(['success' => true, 'application' => $app]);
        return;
    }

    $sql = 'SELECT * FROM applications';
    $params = [];
    if ($status !== '') {
        $sql .= ' WHERE status = :status';
        $params[':status'] = $status;
    }
    $sql .= ' ORDER BY submitted_at DESC, id DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $apps = $stmt->fetchAll();

    echo json_encode(['success' => true, 'applications' => $apps]);
}

function handleUpsertApplication(PDO $pdo): void
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'invalid_json']);
        return;
    }

    $appCode = isset($input['app_code']) ? trim((string)$input['app_code']) : '';
    if ($appCode === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'missing_app_code']);
        return;
    }

    $company = isset($input['company']) && is_array($input['company']) ? $input['company'] : [];

    $companyName = isset($company['name']) ? trim((string)$company['name']) : '';
    if ($companyName === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'missing_company_name']);
        return;
    }

    $companyAddress = isset($company['address']) ? (string)$company['address'] : null;
    $permitLicense = isset($company['permit']) ? (string)$company['permit'] : (isset($company['permitLicense']) ? (string)$company['permitLicense'] : null);
    $dateIssued = isset($company['dateIssued']) ? (string)$company['dateIssued'] : null;
    $validUntil = isset($company['validUntil']) ? (string)$company['validUntil'] : null;
    $telephone = isset($company['phone']) ? (string)$company['phone'] : null;
    $email = isset($company['email']) ? (string)$company['email'] : null;
    $manufacturingType = isset($input['manufacturing']) ? (string)$input['manufacturing'] : null;
    $status = isset($input['status']) ? (string)$input['status'] : 'new';

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT id FROM applications WHERE app_code = :code');
        $stmt->execute([':code' => $appCode]);
        $existing = $stmt->fetch();

        if ($existing) {
            $appId = (int)$existing['id'];
            $update = $pdo->prepare('UPDATE applications SET company_name = :company_name, company_address = :company_address, permit_license = :permit_license, date_issued = :date_issued, valid_until = :valid_until, telephone = :telephone, email = :email, manufacturing_type = :manufacturing_type, status = :status WHERE id = :id');
            $update->execute([
                ':company_name' => $companyName,
                ':company_address' => $companyAddress,
                ':permit_license' => $permitLicense,
                ':date_issued' => $dateIssued,
                ':valid_until' => $validUntil,
                ':telephone' => $telephone,
                ':email' => $email,
                ':manufacturing_type' => $manufacturingType,
                ':status' => $status,
                ':id' => $appId,
            ]);
        } else {
            $insert = $pdo->prepare('INSERT INTO applications (app_code, company_name, company_address, permit_license, date_issued, valid_until, telephone, email, manufacturing_type, status) VALUES (:app_code, :company_name, :company_address, :permit_license, :date_issued, :valid_until, :telephone, :email, :manufacturing_type, :status)');
            $insert->execute([
                ':app_code' => $appCode,
                ':company_name' => $companyName,
                ':company_address' => $companyAddress,
                ':permit_license' => $permitLicense,
                ':date_issued' => $dateIssued,
                ':valid_until' => $validUntil,
                ':telephone' => $telephone,
                ':email' => $email,
                ':manufacturing_type' => $manufacturingType,
                ':status' => $status,
            ]);
            $appId = (int)$pdo->lastInsertId();
        }

        if (isset($input['documents']) && is_array($input['documents'])) {
            foreach ($input['documents'] as $doc) {
                if (!is_array($doc)) {
                    continue;
                }
                $name = isset($doc['name']) ? trim((string)$doc['name']) : '';
                if ($name === '') {
                    continue;
                }
                $fileName = isset($doc['file_name']) ? (string)$doc['file_name'] : (isset($doc['file']) ? (string)$doc['file'] : null);
                $statusDoc = isset($doc['status']) ? (string)$doc['status'] : 'pending';
                $certStatus = isset($doc['certifier_status']) ? (string)$doc['certifier_status'] : null;
                $certRemarks = isset($doc['certifier_remarks']) ? (string)$doc['certifier_remarks'] : null;
                $inspVerification = isset($doc['inspector_verification']) ? (string)$doc['inspector_verification'] : null;
                $inspNotes = isset($doc['inspector_notes']) ? (string)$doc['inspector_notes'] : null;

                $stmtDoc = $pdo->prepare('SELECT id FROM application_documents WHERE application_id = :app_id AND name = :name');
                $stmtDoc->execute([':app_id' => $appId, ':name' => $name]);
                $existingDoc = $stmtDoc->fetch();
                if ($existingDoc) {
                    $upd = $pdo->prepare('UPDATE application_documents SET file_name = :file_name, status = :status, certifier_status = :certifier_status, certifier_remarks = :certifier_remarks, inspector_verification = :inspector_verification, inspector_notes = :inspector_notes WHERE id = :id');
                    $upd->execute([
                        ':file_name' => $fileName,
                        ':status' => $statusDoc,
                        ':certifier_status' => $certStatus,
                        ':certifier_remarks' => $certRemarks,
                        ':inspector_verification' => $inspVerification,
                        ':inspector_notes' => $inspNotes,
                        ':id' => $existingDoc['id'],
                    ]);
                } else {
                    $ins = $pdo->prepare('INSERT INTO application_documents (application_id, name, file_name, status, certifier_status, certifier_remarks, inspector_verification, inspector_notes) VALUES (:app_id, :name, :file_name, :status, :certifier_status, :certifier_remarks, :inspector_verification, :inspector_notes)');
                    $ins->execute([
                        ':app_id' => $appId,
                        ':name' => $name,
                        ':file_name' => $fileName,
                        ':status' => $statusDoc,
                        ':certifier_status' => $certStatus,
                        ':certifier_remarks' => $certRemarks,
                        ':inspector_verification' => $inspVerification,
                        ':inspector_notes' => $inspNotes,
                    ]);
                }
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'app_code' => $appCode, 'application_id' => $appId]);
    } catch (Throwable $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'save_failed']);
    }
}
