<?php
// ---------------------------------------------------------
// CLAIMS REVIEW MODULE
// ---------------------------------------------------------

session_start();

// Mock Data (Simulating Database Records)
$claims = [
    [
        'id' => 1,
        'customer' => 'Fatima Ali',
        'date' => '2024-06-01',
        'description' => 'Food was not served as described according to Halal menu.',
        'status' => 'Unresolved',
        'blockchain_tx' => '0x123abc456def789...',
        'priority' => 'High'
    ],
    [
        'id' => 2,
        'customer' => 'Omar Syed',
        'date' => '2024-06-02',
        'description' => 'Possible cross-contamination concern with non-halal items.',
        'status' => 'Unresolved',
        'blockchain_tx' => '0x987zyx654wvu321...',
        'priority' => 'Medium'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claims Review - Halal Keeps</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #0d8c4c;
            --secondary-green: #16a765;
            --bs-body-bg: #f5fcf7;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }
        body { background-color: var(--bs-body-bg); }

        .claims-container { max-width: 800px; margin: 0 auto; }
        
        .claim-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            border-left: 5px solid var(--primary-green);
            background: white;
        }
        
        .claim-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 140, 76, 0.1);
        }

        .btn-resolve {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(13, 140, 76, 0.2);
        }
        .btn-resolve:hover {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            color: white;
            transform: translateY(-1px);
        }
        
        .blockchain-link {
            font-family: monospace;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            color: var(--primary-green);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .blockchain-link:hover {
            background: #e8f5e9;
            color: #0a6d3a;
        }
    </style>
</head>
<body class="py-5">
    <div class="container claims-container">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Unresolved Claims
                </h3>
                <p class="text-muted mb-0">Review and resolve customer complaints</p>
            </div>
            <a href="owner_dashboard.php" class="btn btn-outline-secondary rounded-pill btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>

        <?php if (empty($claims)): ?>
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-check-lg fs-2"></i>
                </div>
                <h5 class="fw-bold text-dark">All Clear!</h5>
                <p class="text-muted mb-0">You have no unresolved claims at this time.</p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($claims as $claim): ?>
                    <div class="card claim-card p-4" id="claim-<?= $claim['id'] ?>">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($claim['customer']) ?></h5>
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="bi bi-calendar-event"></i>
                                    <?= htmlspecialchars($claim['date']) ?>
                                    <span class="mx-1">•</span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                        <?= htmlspecialchars($claim['status']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php if(isset($claim['priority']) && $claim['priority'] == 'High'): ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-fire me-1"></i>High Priority</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="bg-light p-3 rounded-3 mb-3 border">
                            <i class="bi bi-chat-quote-fill text-secondary me-2"></i>
                            <span class="text-dark fst-italic">"<?= htmlspecialchars($claim['description']) ?>"</span>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <a href="https://mumbai.polygonscan.com/tx/<?= urlencode($claim['blockchain_tx']) ?>" target="_blank" class="blockchain-link small">
                                <i class="bi bi-link-45deg fs-6"></i>
                                View on Blockchain
                            </a>
                            <button class="btn btn-resolve rounded-pill px-4 py-2 btn-sm fw-bold" onclick="openResolveModal(<?= $claim['id'] ?>)">
                                <i class="bi bi-check2-circle me-1"></i> Mark Resolved
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="modal fade" id="resolveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="mb-3 text-success">
                        <i class="bi bi-check-circle-fill display-1"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Resolve this Claim?</h3>
                    <p class="text-muted mb-4">This action will mark the claim as resolved and update the blockchain record. This cannot be undone.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success px-4 fw-bold" onclick="confirmResolution()">Yes, Resolve It</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedClaimId = null;

        function openResolveModal(id) {
            selectedClaimId = id;
            const modal = new bootstrap.Modal(document.getElementById('resolveModal'));
            modal.show();
        }

        function confirmResolution() {
            if (selectedClaimId) {
                // In a real app, you would make an AJAX call here to update the DB
                
                // For demo visuals, we animate removal
                const claimCard = document.getElementById('claim-' + selectedClaimId);
                if (claimCard) {
                    claimCard.style.transition = 'all 0.5s ease';
                    claimCard.style.opacity = '0';
                    claimCard.style.transform = 'translateX(50px)';
                    setTimeout(() => {
                        claimCard.remove();
                        // Check if list is empty
                        const container = document.querySelector('.d-flex.flex-column');
                        if (container && container.children.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 500);
                }
            }
            
            // Close modal
            const modalEl = document.getElementById('resolveModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        }
    </script>
</body>
</html>