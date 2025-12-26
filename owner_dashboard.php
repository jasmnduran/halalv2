<?php include 'owner_dashboard_logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Dashboard - Halal Keeps</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .blurred { filter: blur(4px); pointer-events: none; user-select: none; }
        .premium-badge { background: #facc15; color: #fff; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: bold; margin-left: 0.5rem; }
    </style>
</head>
<body class="bg-light min-vh-100">
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mb-4">
            <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                <img src="logo.jpg" alt="Logo" class="rounded-circle border border-2 border-success" style="height:56px;width:56px;" />
                <div>
                    <h1 class="h4 fw-bold text-dark d-flex align-items-center gap-2 mb-1">
                        Welcome, <?= htmlspecialchars($owner['name'] ?? '') ?>
                        <a href="edit_profile_owner.php" title="Edit Profile" class="ms-2 text-success text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="" style="height:20px;width:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3zm0 0v3h3" /></svg>
                        </a>
                    </h1>
                    <a href="business_profile_builder.php" class="d-inline-block mt-2 btn btn-primary btn-sm">
                        <svg class="" style="width:16px;height:16px;margin-right:4px;margin-top:-2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Build Your Business Profile
                    </a>
                    <p class="text-muted small d-flex align-items-center gap-2 mb-0">
                        <svg class="text-success" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0l-4.243 4.243M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <?= htmlspecialchars($owner['location'] ?? '') ?>
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-success bg-opacity-10 text-success-emphasis px-3 py-1 rounded-pill small fw-semibold">Profile Views: <?= htmlspecialchars($owner['profile_views'] ?? '') ?></span>
                <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-1 rounded-pill small fw-semibold">Rating: <?= htmlspecialchars($owner['rating'] ?? '') ?>/5</span>
                <button onclick="window.location.href='welcome.php'" class="btn btn-danger btn-sm ms-3">Logout</button>
            </div>
        </div>
        
        <!-- Notifications -->
        <div class="mb-4">
            <?php if (isset($_GET['submitted']) && $_GET['submitted'] == '1'): ?>
                <!-- Success Modal -->
                <div class="modal fade" id="submissionSuccessModal" tabindex="-1" aria-labelledby="submissionSuccessModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="submissionSuccessModalLabel">Application Submitted</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <?php if (isset($_GET['id'])): ?>
                                    <iframe src="certification_success.php?id=<?= htmlspecialchars($_GET['id']) ?>" style="width:100%;height:75vh;border:0;" title="Submission Success"></iframe>
                                <?php else: ?>
                                    <div class="p-4">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="text-success fs-3">✅</div>
                                            <div>
                                                <p class="mb-1">Your Halal Certification application was successfully submitted for review.</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modalEl = document.getElementById('submissionSuccessModal');
                        if (modalEl && typeof bootstrap !== 'undefined') {
                            var modal = new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    });

                    // Listen for close message from iframe
                    window.addEventListener('message', function(event) {
                        if (event.data === 'closeModal') {
                            var modalEl = document.getElementById('submissionSuccessModal');
                            if (modalEl && typeof bootstrap !== 'undefined') {
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) {
                                    modal.hide();
                                }
                            }
                        }
                    });
                </script>
            <?php endif; ?>
            <div class="alert alert-info d-flex align-items-center gap-3 border-start border-info border-4">
                <svg class="text-info" style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
                <span>New review received! <a href="#" class="text-decoration-underline ms-1">View now</a></span>
            </div>
        </div>
        
        <!-- Main Grid -->
        <div class="row g-4 mb-4">
            <!-- Halal Market Potential -->
            <div class="col-12 col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <h2 class="h5 fw-bold text-dark mb-2">Halal Market Potential</h2>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <span class="display-6 fw-bold text-success me-2"><?= htmlspecialchars($owner['market_score'] ?? '') ?></span>
                        <span class="text-muted">Market Score</span>
                    </div>
                    <p class="text-muted mb-2">Muslim Population: <span class="fw-semibold"><?= htmlspecialchars(number_format($owner['muslim_population'] ?? 0)) ?></span></p>
                    <p class="text-muted mb-2">Nearby Halal Restaurants: <span class="fw-semibold"><?= htmlspecialchars($owner['competition'] ?? '') ?></span></p>
                    <p class="text-dark mb-2">Insight: <span class="fw-semibold"><?= htmlspecialchars($owner['market_insight'] ?? '') ?></span></p>
                    <a href="market_overview.php" class="text-success text-decoration-underline small">View detailed market overview</a>
                </div>
            </div>
            
            <!-- Halal Status Tracking -->
            <div class="col-12 col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <h2 class="h5 fw-bold text-dark mb-2">Halal Status Tracking</h2>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-success bg-opacity-10 text-success-emphasis px-2 py-1 rounded small fw-semibold">Certificate: <?= htmlspecialchars($owner['certificate_status'] ?? '') ?></span>
                        <span class="small text-muted">(Expires: <?= htmlspecialchars($owner['certificate_expiry'] ?? '') ?>)</span>
                    </div>
                    <div class="mb-2">Halal Rating: <span class="fw-bold text-warning">⭐ <?= htmlspecialchars($owner['halal_rating'] ?? '') ?>/5</span></div>
                    <div class="mb-2">Total Reviews: <span class="fw-semibold"><?= htmlspecialchars($owner['total_reviews'] ?? '') ?></span></div>
                    <div class="mb-2">Unresolved Claims: <span class="fw-semibold text-danger"><?= htmlspecialchars($owner['unresolved_claims'] ?? '') ?></span></div>
                    <div class="mb-2">Recent Feedback: <span class="fst-italic text-muted">"<?= htmlspecialchars($owner['recent_feedback'] ?? '') ?>"</span></div>
                    <div class="d-flex gap-2 mt-2">
                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#claimsModal" onclick="loadClaimsReview(event)">Resolve Claims</a>
                        <?php if (isset($_GET['id'])): ?>
                            <a href="certification_progress.php?id=<?= htmlspecialchars($_GET['id']) ?>" class="btn btn-success btn-sm">View Certification Progress</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Premium Analytics Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4 position-relative">
            <div class="d-flex align-items-center mb-3">
                <h2 class="h5 fw-bold text-dark mb-0">Business Analytics</h2>
                <span class="premium-badge">Premium</span>
            </div>
            <?php if (!($owner['premium'] ?? false)): ?>
                <div class="blurred">
            <?php endif; ?>
            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
                        <div class="display-6 fw-bold text-success mb-1"><?= htmlspecialchars($analytics['daily'] ?? '') ?></div>
                        <div class="text-muted small">Avg. Muslim Customers/Day</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                        <div class="display-6 fw-bold text-primary mb-1"><?= htmlspecialchars($analytics['monthly'] ?? '') ?></div>
                        <div class="text-muted small">Monthly Muslim Customers</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                        <div class="display-6 fw-bold text-warning mb-1"><?= htmlspecialchars($analytics['yearly'] ?? '') ?></div>
                        <div class="text-muted small">Yearly Muslim Customers</div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="mb-2">Peak Hours: <span class="fw-semibold text-success"><?= htmlspecialchars($analytics['peak_hours'] ?? '') ?></span></div>
                    <div class="mb-2">Retention Rate: <span class="fw-semibold text-primary"><?= htmlspecialchars($analytics['retention'] ?? '') ?></span></div>
                    <div class="mb-2">Referral Rate: <span class="fw-semibold text-warning"><?= htmlspecialchars($analytics['referral'] ?? '') ?></span></div>
                    <div class="mb-2">Growth: <span class="fw-semibold text-success"><?= htmlspecialchars($analytics['growth'] ?? '') ?></span></div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-2 fw-semibold">Recommendations:</div>
                    <div class="text-muted small">- <?= htmlspecialchars($analytics['recommendations'] ?? '') ?></div>
                </div>
            </div>
            <?php if (!($owner['premium'] ?? false)): ?>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-80 rounded-4" style="z-index: 10;">
                    <div class="text-dark fw-bold fs-5 mb-2">Unlock Premium Analytics</div>
                    <div class="text-muted mb-3 text-center">Upgrade to premium to access detailed analytics and insights for your business growth.</div>
                    <a href="#" class="btn btn-warning fw-semibold">Upgrade Now</a> <!-- TODO: Update link -->
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Halal Starter Pack -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center mb-3">
                <h2 class="h5 fw-bold text-dark mb-0"><a href="halal_starter_pack.php" class="text-dark text-decoration-none">Halal Starter Pack</a></h2>
                <span class="ms-2 small text-muted">Progress: <?= htmlspecialchars($owner['starter_pack_progress'] ?? '') ?>%</span>
            </div>
            <div class="progress mb-3" style="height: 12px;">
                <div class="progress-bar bg-success" style="width: <?= htmlspecialchars($owner['starter_pack_progress'] ?? '') ?>%"></div>
            </div>
            <div class="row g-2 mb-2">
                <?php foreach (($owner['modules'] ?? []) as $mod): ?>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 <?= ($mod['complete'] ?? false) ? 'bg-success bg-opacity-10 text-success-emphasis' : 'bg-light text-muted' ?>">
                            <span><?= ($mod['complete'] ?? false) ? '✔️' : '⏳' ?></span>
                            <span><?= htmlspecialchars($mod['name'] ?? '') ?></span>
                            <?php if (!($mod['complete'] ?? false)): ?><a href="#" class="ms-auto text-success text-decoration-underline small">Continue</a><?php endif; ?> <!-- TODO: Update link -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-2 small text-primary">New resources available! <a href="halal_starter_pack.php" class="text-decoration-underline">View now</a></div> <!-- TODO: Update link -->
        </div>
        
        <!-- Recent Activity & Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <h2 class="h5 fw-bold text-dark mb-2">Recent Activity</h2>
                    <ul class="list-unstyled text-muted">
                        <?php foreach (($owner['activity_feed'] ?? []) as $act): ?>
                            <li class="mb-1">• <?= htmlspecialchars($act ?? '') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="bg-white rounded-4 shadow-sm p-4 d-flex flex-column gap-2 h-100">
                    <h2 class="h5 fw-bold text-dark mb-2">Quick Actions</h2>
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#addPromoModal">Add Menu</button>
                    <a href="#" class="btn btn-primary">Respond to Review</a> <!-- TODO: Update link -->
                    <a href="applicant.html" class="btn btn-warning">Halal Certification</a> <!-- TODO: Update link -->
                     <a href="certification_progress.php<?php
                        if (isset($_GET['id'])) { echo '?id=' . htmlspecialchars($_GET['id']); }
                        else if (isset($_SESSION) && isset($_SESSION['last_application_id'])) { echo '?id=' . (int)$_SESSION['last_application_id']; }
                     ?>" class="btn btn-warning">Certification Progress</a>
                  </div>
            </div>
        </div>
    </div>
    
    <!-- Claims Review Modal -->
    <div class="modal fade" id="claimsModal" tabindex="-1" aria-labelledby="claimsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="claimsModalLabel">Unresolved Claims</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="claimsModalBody" style="background:#f6f8fa;">
            <div class="text-center py-5">
              <div class="spinner-border text-success" role="status"></div>
            </div>
          </div>
        </div>
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
    <!-- Add Promo/Menu Modal -->
    <div class="modal fade" id="addPromoModal" tabindex="-1" aria-labelledby="addPromoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoModalLabel">Add Promo/Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="promoForm" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Menu Name</label>
                <input type="text" name="promo_name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2" required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" name="price" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Upload Food Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Add Promo/Menu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Current Promos/Menus Section -->
    <div class="d-flex justify-content-center">
      <div class="card mt-4 mb-4" style="max-width:700px; width:100%;">
        <div class="fw-bold mb-3" style="font-size:1.1em; color:#198754;">Current Promos/Menus</div>
        <div id="promoList">
          <!-- Promos will be rendered here -->
        </div>
      </div>
    </div>
    <style>
        .promo-card-ui {
          background: #fff;
          border-radius: 16px;
          box-shadow: 0 2px 12px rgba(44,62,80,0.07);
          border-left: 6px solid #219653;
          padding: 18px 24px;
          margin-bottom: 18px;
          display: flex;
          align-items: flex-start;
          gap: 18px;
        }
        .promo-img-ui {
          width: 80px;
          height: 80px;
          object-fit: cover;
          border-radius: 12px;
          border: 1.5px solid #e5e7eb;
          background: #f5fcf7;
        }
        .promo-info-ui {
          flex: 1;
        }
        .promo-title-ui {
          font-size: 1.15em;
          font-weight: 700;
          color: #219653;
          margin-bottom: 2px;
        }
        .promo-date-ui {
          color: #888;
          font-size: 0.98em;
          margin-bottom: 6px;
        }
        .promo-desc-ui {
          color: #444;
          margin-bottom: 8px;
        }
        .promo-price-ui {
          font-weight: 700;
          color: #219653;
          font-size: 1.08em;
        }
      </style>
    <!-- Bootstrap JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // jQuery Mobile initialization
      $(document).ready(function() {
        // Initialize jQuery Mobile
        $.mobile.initializePage();
        
        // Enhanced mobile interactions
        $('.btn, button').on('touchstart', function() {
          $(this).addClass('ui-btn-active');
        }).on('touchend', function() {
          $(this).removeClass('ui-btn-active');
        });
        
        // Mobile-friendly form handling
        $('input, select, textarea').on('focus', function() {
          $(this).addClass('ui-focus');
        }).on('blur', function() {
          $(this).removeClass('ui-focus');
        });
      });
    </script>
    <script>
function loadClaimsReview(e) {
  e.preventDefault();
  fetch('claims_review.php')
    .then(response => response.text())
    .then(html => {
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;
      const mainCard = tempDiv.querySelector('.main-card');
      document.getElementById('claimsModalBody').innerHTML = mainCard ? mainCard.outerHTML : html;
    });
}
    </script>
    <script>
      // Remove the event that shows the resolved modal on close
      // document.getElementById('claimsModal').addEventListener('hidden.bs.modal', function() {
      //   var resolvedModal = new bootstrap.Modal(document.getElementById('resolvedModal'));
      //   resolvedModal.show();
      // });

      // Instead, only show the resolved modal after a claim is actually resolved
      // You should call this function after resolving a claim
      function showClaimResolvedModal() {
        var resolvedModal = new bootstrap.Modal(document.getElementById('resolvedModal'));
        resolvedModal.show();
      }

      // After clicking OK on the claim resolved modal, reload the dashboard to reflect changes
      document.getElementById('resolvedModal').addEventListener('hidden.bs.modal', function() {
        window.location.reload();
      });
    </script>
    <script>
      // Store promos in localStorage for demo (replace with backend in production)
      function getPromos() {
        return JSON.parse(localStorage.getItem('promos') || '[]');
      }
      function setPromos(promos) {
        localStorage.setItem('promos', JSON.stringify(promos));
      }
      function renderPromos() {
        const promos = getPromos();
        const promoList = document.getElementById('promoList');
        if (!promos.length) {
          promoList.innerHTML = '<div class="text-muted mb-3">No promos/menus added yet.</div>';
        } else {
          promoList.innerHTML = promos.map(promo => `
            <div class="promo-card-ui">
              <img src="${promo.image || 'logo.jpg'}" alt="Food" class="promo-img-ui">
              <div class="promo-info-ui">
                <div class="promo-title-ui">${promo.promo_name}</div>
                <div class="promo-date-ui">Date: ${promo.date}</div>
                <div class="promo-desc-ui">${promo.description}</div>
                <div class="promo-price-ui">Price: ${promo.price}</div>
              </div>
            </div>
          `).join('');
        }
      }
      document.getElementById('promoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const promo = {
          promo_name: formData.get('promo_name'),
          description: formData.get('description'),
          price: formData.get('price'),
          date: formData.get('date'),
          image: 'logo.jpg'
        };
        // Handle image preview (demo: just use logo.jpg)
        const promos = getPromos();
        promos.push(promo);
        setPromos(promos);
        renderPromos();
        var modal = bootstrap.Modal.getInstance(document.getElementById('addPromoModal'));
        modal.hide();
        form.reset();
      });
      renderPromos();
    </script>
</body>
</html> 