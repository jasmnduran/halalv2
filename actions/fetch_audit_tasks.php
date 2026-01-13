<?php
require_once "../includes/db.php";
session_start();

header('Content-Type: application/json');

try {
    // 1. Fetch Stats
    // Assuming 'inspection_scheduled' is the status for ready-to-audit apps
    // 'Approved' or 'Rejected' counts as completed
    $statsSql = "SELECT 
        SUM(CASE WHEN status = 'inspection_scheduled' THEN 1 ELSE 0 END) as scheduled,
        SUM(CASE WHEN status IN ('Approved', 'Rejected') AND updated_at >= CURDATE() THEN 1 ELSE 0 END) as completed
        FROM halal_certification_applications";
    
    $statsRes = $conn->query($statsSql);
    $stats = $statsRes->fetch_assoc();

    // 2. Fetch Tasks
    $tasksSql = "SELECT id, company_name, business_address, contact_person, telephone 
                 FROM halal_certification_applications 
                 WHERE status = 'inspection_scheduled' 
                 ORDER BY first_audit_date ASC";
    
    $tasksRes = $conn->query($tasksSql);
    $tasks = [];
    while($row = $tasksRes->fetch_assoc()) {
        $tasks[] = $row;
    }

    echo json_encode([
        'stats' => [
            'scheduled' => (int)$stats['scheduled'],
            'completed' => (int)$stats['completed']
        ],
        'tasks' => $tasks
    ]);

} catch (Exception $e) {
    echo json_encode(['stats' => ['scheduled'=>0,'completed'=>0], 'tasks' => []]);
}

$conn->close();
?>