<?php
// Include the database logic we created earlier
require_once "owner_dashboard_logic.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Dashboard - Halal Keeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #0d8c4c;
            --secondary-green: #16a765;
            --light-green: #e8f5e9;
            --bs-body-bg: #f6f8fa;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }
        body { background-color: var(--bs-body-bg); }
        .dashboard-card {
            border: none; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            background: white; transition: transform 0.2s; height: 100%;
        }
        .dashboard-card:hover { transform: translateY(-3px); }
        .btn-brand {
            background: var(--primary-green); color: white; border: none;
        }
        .btn-brand:hover { background: var(--secondary-green); color: white; }
    </style>
</head>
<body class="py-4">
    <div class="container">
        
        <header class="dashboard-card p-4 mb-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="logo.jpg" class="rounded-circle border p-1" width="64" height="64">
                <div>
                    <h1 class="h4 fw-bold mb-1">Welcome, <?= htmlspecialchars($owner['name']) ?></h1>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="bi bi-geo-alt-fill text-success"></i> <?= htmlspecialchars($owner['location']) ?>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="bi bi-eye me-1"></i> <?= $owner['profile_views'] ?> Views
                </span>
                <span class="badge bg-warning text-dark border border-warning px-3 py-2 rounded-pill">
                    <i class="bi bi-star-fill me-1"></i> <?= $owner['rating'] ?>/5
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
            </div>
        </header>

        <?php if ($owner['unresolved_claims'] > 0): ?>
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center justify-content-between">
            <div>
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                You have <strong><?= $owner['unresolved_claims'] ?> unresolved claim(s)</strong>.
            </div>
            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#claimsModal">Review</button>
        </div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="dashboard-card p-4">
                    <h5 class="fw-bold text-dark mb-3">Certification Status</h5>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <?= htmlspecialchars($owner['certificate_status']) ?>
                        </span>
                        <small class="text-muted">Expires: <?= htmlspecialchars($owner['certificate_expiry']) ?></small>
                    </div>

                    <?php if ($owner['certificate_status'] == 'Not Applied'): ?>
                        <div class="alert alert-warning small">
                            <i class="bi bi-info-circle me-1"></i> You haven't applied for Halal Certification yet.
                        </div>
                        <a href="halal_certification_application.php" class="btn btn-brand w-100">Start Application</a>
                    <?php else: ?>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?= $owner['starter_pack_progress'] ?>%"></div>
                        </div>
                        <a href="certification_progress.php?status=<?= strtolower($owner['certificate_status']) ?>" class="small text-success text-decoration-none fw-bold">Track Progress &rarr;</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dashboard-card p-4">
                    <h5 class="fw-bold text-dark mb-3">Market Potential</h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <span class="h4 fw-bold mb-0"><?= $owner['market_score'] ?></span>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Market Score</div>
                            <div class="small"><?= htmlspecialchars($owner['market_insight']) ?></div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between small">
                        <span><i class="bi bi-people me-1"></i> Pop: <?= number_format($owner['muslim_population']) ?></span>
                        <span><i class="bi bi-shop me-1"></i> Comp: <?= $owner['competition'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-card p-4">
            <h5 class="fw-bold text-dark mb-3">Recent Activity</h5>
            <div class="list-group list-group-flush">
                <?php if (empty($owner['activity_feed'])): ?>
                    <div class="text-muted small py-2">No recent activity.</div>
                <?php else: ?>
                    <?php foreach ($owner['activity_feed'] as $activity): ?>
                        <div class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-dot text-success fs-3 me-2"></i>
                            <?= htmlspecialchars($activity) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="modal fade" id="claimsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Customer Claims</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <?php include 'claims_review.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>