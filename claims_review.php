<?php
// halalv2/claims_review.php
// NOTE: This file is a partial included in owner_dashboard.php
// Do not start session here if dashboard already starts it.
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "includes/db.php"; // Adjust path if necessary relative to dashboard

$owner_id = $_SESSION['owner_id'] ?? 0;

// Fetch Real Data
$stmt = $conn->prepare("SELECT c.id, c.claim_date, c.description, c.status, c.priority, c.blockchain_tx, 
                        u.name as customer_name 
                        FROM customer_claims c 
                        LEFT JOIN users u ON c.customer_id = u.id 
                        WHERE c.business_id = ? AND c.status = 'unresolved'
                        ORDER BY c.priority DESC, c.claim_date ASC");
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$claims = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="claims-list-container">
    <?php if (empty($claims)): ?>
        <div class="text-center py-5">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                <i class="bi bi-check-lg fs-2"></i>
            </div>
            <h5 class="fw-bold text-dark">All Clear!</h5>
            <p class="text-muted mb-0">You have no unresolved claims.</p>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($claims as $claim): ?>
                <div class="card border mb-3" id="claim-<?= $claim['id'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-0">
                                    <?= htmlspecialchars($claim['customer_name'] ?? 'Anonymous') ?>
                                </h6>
                                <small class="text-muted"><?= htmlspecialchars($claim['claim_date']) ?></small>
                            </div>
                            <?php if(strtolower($claim['priority']) == 'high'): ?>
                                <span class="badge bg-danger">High Priority</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= ucfirst($claim['priority']) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="bg-light p-2 rounded small fst-italic text-secondary mb-3">
                            "<?= htmlspecialchars($claim['description']) ?>"
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <?php if(!empty($claim['blockchain_tx'])): ?>
                            <a href="#" class="small text-decoration-none text-muted" title="Tx: <?= htmlspecialchars($claim['blockchain_tx']) ?>">
                                <i class="bi bi-link-45deg"></i> Blockchain Verified
                            </a>
                            <?php else: ?>
                                <span></span>
                            <?php endif; ?>
                            
                            <button class="btn btn-sm btn-success fw-bold" onclick="resolveClaim(<?= $claim['id'] ?>)">
                                <i class="bi bi-check2"></i> Resolve
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
async function resolveClaim(claimId) {
    if(!confirm("Mark this claim as resolved?")) return;

    try {
        const formData = new FormData();
        formData.append('claim_id', claimId);

        const res = await fetch('actions/resolve_claim.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await res.json();
        
        if (data.success) {
            // Remove element from DOM
            const el = document.getElementById(`claim-${claimId}`);
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
            
            // Optional: Update counter on dashboard if needed
        } else {
            alert(data.message || "Failed to resolve claim.");
        }
    } catch (e) {
        console.error(e);
        alert("An error occurred.");
    }
}
</script>