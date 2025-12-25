<?php
session_start();
include 'includes/db.php';

$applicationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($applicationId <= 0 && isset($_SESSION['last_application_id'])) {
    $applicationId = (int)$_SESSION['last_application_id'];
}
$application = null;

// Determine current owner's email if available
$ownerEmail = isset($_SESSION['owner']['email']) ? $_SESSION['owner']['email'] : null;

// Helper: fetch one application by id
function fetchApplicationById(mysqli $conn, int $id) {
    $app = null;
    $stmt = $conn->prepare("SELECT id, applicant_name, company_name, application_type, certification_type, status, created_at, email FROM halal_certification_applications WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $app = $result->fetch_assoc();
        $stmt->close();
    }
    return $app;
}

// Helper: fetch recent applications for an email
function fetchRecentApplications(mysqli $conn, ?string $email, int $limit = 10) {
    if (!$email) { return []; }
    $rows = [];
    $stmt = $conn->prepare("SELECT id, company_name, application_type, certification_type, status, created_at FROM halal_certification_applications WHERE email = ? ORDER BY created_at DESC, id DESC LIMIT ?");
    if ($stmt) {
        $stmt->bind_param("si", $email, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) { $rows[] = $row; }
        $stmt->close();
    }
    return $rows;
}

// Try to load by explicit id first
if ($applicationId > 0) {
    $application = fetchApplicationById($conn, $applicationId);
}

// If no id or not found, load latest for current owner
if (!$application && $ownerEmail) {
    $recent = fetchRecentApplications($conn, $ownerEmail, 1);
    if (!empty($recent)) {
        $applicationId = (int)$recent[0]['id'];
        $application = fetchApplicationById($conn, $applicationId);
    }
}

// If still none, fall back to latest application overall (admin/dev fallback)
if (!$application) {
    $res = $conn->query("SELECT id, applicant_name, company_name, application_type, certification_type, status, created_at, email FROM halal_certification_applications ORDER BY created_at DESC, id DESC LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $application = $res->fetch_assoc();
        $applicationId = (int)$application['id'];
    }
}

// Also load a list of recent applications for side listing
$recentApplications = [];
if ($ownerEmail) {
    $recentApplications = fetchRecentApplications($conn, $ownerEmail, 8);
} else {
    $resList = $conn->query("SELECT id, company_name, application_type, certification_type, status, created_at FROM halal_certification_applications ORDER BY created_at DESC, id DESC LIMIT 8");
    if ($resList) { while ($row = $resList->fetch_assoc()) { $recentApplications[] = $row; } }
}

// Map DB status to flowchart stage
$status = $application['status'] ?? 'pending';
$currentStage = 'Application';
switch ($status) {
    case 'pending':
        $currentStage = 'Application';
        break;
    case 'under_review':
        $currentStage = 'Technical Review';
        break;
    case 'in_progress':
        $currentStage = 'Audit Inspection';
        break;
    case 'approved':
        $currentStage = 'Compliance';
        break;
    case 'rejected':
        $currentStage = 'Non-Compliance';
        break;
    default:
        $currentStage = 'Application';
}

// Flowchart stages
$stages = [
    'Application',
    'Technical Review',
    'Audit Inspection',
    'Laboratory Analysis',
    'Fatwa Recommendations',
    'Compliance',
    'Monitoring'
];

function stageIndex($stages, $stage) { $i = array_search($stage, $stages, true); return $i === false ? 0 : $i; }
$currentIdx = stageIndex($stages, $currentStage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Certification Progress - Halal Keeps</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <style>
        .progress-container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .stage-card { background: var(--card-bg); border-radius: var(--border-radius); box-shadow: var(--shadow); padding: 20px; border-top: 4px solid var(--primary-green); }
        .flow-steps { display: grid; grid-template-columns: repeat(7, minmax(120px, 1fr)); gap: 12px; overflow-x: auto; }
        .step { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 12px; padding: 14px; text-align: center; font-weight: 600; color: #555; position: relative; }
        .step.completed { background: #e7f9ef; border-color: var(--secondary-green); color: var(--primary-green); }
        .step.current { background: var(--light-green); border-color: var(--primary-green); color: var(--primary-green); box-shadow: 0 0 0 3px rgba(13, 140, 76, 0.1); }
        .step small { display:block; font-weight: 500; color:#777; }
        .legend { display:flex; gap:12px; flex-wrap:wrap; }
        .legend .badge { font-weight:600; }
        @media (max-width: 992px) { .flow-steps { grid-template-columns: repeat(3, minmax(160px, 1fr)); } }
        @media (max-width: 576px) { .flow-steps { grid-template-columns: repeat(2, minmax(160px, 1fr)); } }
    </style>
    <script>
        function goBackToDashboard() { window.location.href = 'owner_dashboard.php?submitted=1&id=' + (<?= json_encode($applicationId) ?> || ''); }
    </script>
    <script>
        // Optional: polling for status updates (demo: 30s)
        // setInterval(() => { location.reload(); }, 30000);
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="progress-container container">
        <img src="logo.jpg" alt="Halal Keeps Logo" class="logo mb-3">
        <h1 class="text-center">Certification Progress</h1>
        <p class="subtitle text-center">Track your application through each stage</p>

        <div class="stage-card mb-3">
            <?php if (!$application): ?>
                <div class="alert alert-warning mb-0">No application found. Please submit an application first.</div>
            <?php else: ?>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div><strong>Application ID:</strong> #<?= htmlspecialchars($application['id']) ?></div>
                        <div><strong>Applicant:</strong> <?= htmlspecialchars($application['applicant_name']) ?></div>
                        <div><strong>Company:</strong> <?= htmlspecialchars($application['company_name']) ?></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div><strong>Type:</strong> <?= htmlspecialchars(ucfirst($application['application_type'])) ?></div>
                        <div><strong>Certification:</strong> <?= htmlspecialchars(ucfirst($application['certification_type'])) ?></div>
                        <div><strong>Status:</strong> <span class="badge bg-success-subtle text-success-emphasis"><?= htmlspecialchars(ucfirst($status)) ?></span></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="stage-card">
            <h2 class="h5 fw-bold text-dark mb-3">Progress</h2>
            <div class="flow-steps">
                <?php foreach ($stages as $index => $label):
                    $class = '';
                    if ($index < $currentIdx) { $class = 'completed'; }
                    elseif ($index === $currentIdx) { $class = 'current'; }
                ?>
                    <div class="step <?= $class ?>">
                        <div class="mb-1">Step <?= $index + 1 ?></div>
                        <div><?= htmlspecialchars($label) ?></div>
                        <?php if ($label === 'Audit Inspection'): ?>
                            <small>With/Without NCR</small>
                        <?php elseif ($label === 'Laboratory Analysis'): ?>
                            <small>Sampling & Results</small>
                        <?php elseif ($label === 'Fatwa Recommendations'): ?>
                            <small>Ulama Decision</small>
                        <?php elseif ($label === 'Compliance'): ?>
                            <small>Award of Certificate</small>
                        <?php elseif ($label === 'Monitoring'): ?>
                            <small>Follow-up</small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="legend mt-3">
                <span class="badge bg-success-subtle text-success-emphasis">Current</span>
                <span class="badge bg-secondary-subtle text-secondary-emphasis">Pending</span>
                <span class="badge bg-primary-subtle text-primary-emphasis">Completed</span>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="owner_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <?php if ($application): ?>
                    <a class="btn" href="actions/print_application.php?id=<?= (int)$application['id'] ?>">Download Summary</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($recentApplications)): ?>
        <div class="stage-card mt-3">
            <h2 class="h6 fw-bold text-dark mb-2">Your Recent Applications</h2>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Company</th>
                            <th scope="col">Type</th>
                            <th scope="col">Certification</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentApplications as $row): ?>
                            <tr>
                                <td>#<?= (int)$row['id'] ?></td>
                                <td><?= htmlspecialchars($row['company_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars(ucfirst($row['application_type'] ?? '')) ?></td>
                                <td><?= htmlspecialchars(ucfirst($row['certification_type'] ?? '')) ?></td>
                                <td><span class="badge bg-secondary-subtle text-secondary-emphasis"><?= htmlspecialchars(ucfirst($row['status'] ?? '')) ?></span></td>
                                <td class="text-end"><a href="certification_progress.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-primary">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>


