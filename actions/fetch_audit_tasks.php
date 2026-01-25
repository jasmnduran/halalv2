<?php
require_once "../includes/db.php";
session_start();
header('Content-Type: application/json');

// FIXED: Check for auditor_id
if (!isset($_SESSION['auditor_id'])) {
    echo json_encode(['stats' => ['scheduled'=>0,'completed'=>0], 'tasks' => []]);
    exit;
}

try {
    // Logic remains the same, but access is now restricted to Auditors
    $statsSql = "SELECT 
        SUM(CASE WHEN status = 'Inspection Scheduled' THEN 1 ELSE 0 END) as scheduled,
        SUM(CASE WHEN status IN ('Approved', 'Rejected') AND updated_at >= CURDATE() THEN 1 ELSE 0 END) as completed
        FROM halal_certification_applications";
    
    $statsRes = $conn->query($statsSql);
    $stats = $statsRes->fetch_assoc();

    $tasksSql = "SELECT id, company_name, business_address, contact_person, telephone, first_audit_date 
                 FROM halal_certification_applications 
                 WHERE status = 'Inspection Scheduled' 
                 ORDER BY first_audit_date ASC";
    
    $tasksRes = $conn->query($tasksSql);
    $tasks = $tasksRes->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'stats' => [
            'scheduled' => (int)($stats['scheduled'] ?? 0),
            'completed' => (int)($stats['completed'] ?? 0)
        ],
        'tasks' => $tasks
    ]);

} catch (Exception $e) {
    echo json_encode(['stats' => ['scheduled'=>0,'completed'=>0], 'tasks' => []]);
}
$conn->close();
?>