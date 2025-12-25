<?php
// Dummy claims data
$claims = [
    [
        'id' => 1,
        'customer' => 'Fatima Ali',
        'date' => '2024-06-01',
        'description' => 'Food was not served as described.',
        'status' => 'Unresolved',
        'blockchain_tx' => '0x123abc456def789...',
    ],
    [
        'id' => 2,
        'customer' => 'Omar Syed',
        'date' => '2024-06-02',
        'description' => 'Possible cross-contamination.',
        'status' => 'Unresolved',
        'blockchain_tx' => '0x987zyx654wvu321...',
    ],
];
?>
<div class="modal-body main-card" style="background:#f6f8fa;">
  <div class="section-title mb-4 d-flex align-items-center justify-content-between">
    <span><span style="font-size:1.2em;">&#128221;</span> Unresolved Claims</span>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div id="claimsList">
  <?php foreach ($claims as $claim): ?>
    <div class="claim-row" data-claim-id="<?= $claim['id'] ?>">
      <div class="mb-1"><span class="claim-label">Customer:</span> <b><?= htmlspecialchars($claim['customer']) ?></b></div>
      <div class="mb-1"><span class="claim-label">Date:</span> <?= htmlspecialchars($claim['date']) ?></div>
      <div class="mb-1"><span class="claim-label">Description:</span> <?= htmlspecialchars($claim['description']) ?></div>
      <div class="mb-1"><span class="claim-label">Status:</span> <span class="text-danger claim-status">Unresolved</span></div>
      <div class="mb-1">
        <span class="claim-label">Blockchain:</span>
        <a href="https://mumbai.polygonscan.com/tx/<?= urlencode($claim['blockchain_tx']) ?>" target="_blank" class="blockchain-link">
          View on Blockchain
        </a>
      </div>
      <button type="button" class="btn btn-resolve" data-bs-toggle="modal" data-bs-target="#resolvedModal">Resolve</button>
      <div style="clear:both;"></div>
    </div>
  <?php endforeach; ?>
  <?php if (empty($claims)): ?>
    <div class="text-muted text-center py-4">No unresolved claims at this time.</div>
  <?php endif; ?>
  </div>
</div>
<!-- Claim Resolved Modal -->
<div class="modal fade" id="resolvedModal" tabindex="-1" aria-labelledby="resolvedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resolvedModalLabel">Claim Resolved</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <span style="font-size:2em; color:#219653;">&#10003;</span>
        <div class="mt-2">Claim resolved successfully.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<style>
  .main-card { max-width: 700px; margin: 0 auto; border-radius: var(--border-radius); box-shadow: var(--shadow); overflow: hidden; background: var(--card-bg); padding: 2rem; border-top: 4px solid var(--primary-green); }
  .section-title { color: var(--primary-green); font-weight: 700; font-size: 1.3em; margin-bottom: 1.5rem; }
  .claim-row { background: #f9f9f9; border-radius: 12px; box-shadow: 0 1px 6px rgba(44,62,80,0.06); border-left: 5px solid var(--primary-green); margin-bottom: 22px; padding: 1.2rem 1.2rem 1.2rem 1.5rem; position: relative; }
  .claim-label { color: #6c757d; min-width: 120px; display: inline-block; }
  .blockchain-link { color: var(--primary-green); font-weight: 500; }
  .btn-resolve { background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); color: #fff; font-weight: 600; border-radius: 8px; padding: 8px 24px; font-size: 1em; float: right; margin-top: 10px; box-shadow: 0 2px 8px rgba(44,62,80,0.07); border: none; transition: all 0.3s ease; }
  .btn-resolve:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4); }
  .claim-status { font-weight: 600; }
  @media (max-width: 600px) {
    .main-card { margin: 0; border-radius: 0; padding: 1rem; }
    .section-title { font-size: 1.1em; }
    .claim-row { padding: 1rem 0.7rem 1rem 1rem; }
  }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // jQuery Mobile initialization
  $(document).ready(function() {
    // Initialize jQuery Mobile
    $.mobile.initializePage();
    
    // Enhanced mobile interactions
    $('.btn-resolve, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly claim resolution
    $('.btn-resolve').on('click', function() {
      $.mobile.showPageLoadingMsg();
      setTimeout(function() {
        $.mobile.hidePageLoadingMsg();
      }, 1000);
    });
  });
</script> 