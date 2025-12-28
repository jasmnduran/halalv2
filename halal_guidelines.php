<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halal Guidelines - Halal Keeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; }
        .guide-header { background: #fff; border-bottom: 1px solid #dee2e6; }
        .accordion-button:not(.collapsed) {
            background-color: #e8f5e9;
            color: #0d8c4c;
        }
        .accordion-button:focus { box-shadow: none; border-color: rgba(13,140,76,0.1); }
    </style>
</head>
<body>

    <div class="guide-header sticky-top py-3 shadow-sm">
        <div class="container d-flex align-items-center">
            <a href="halal_starter_pack_details.php" class="btn btn-light rounded-circle me-3"><i class="bi bi-arrow-left"></i></a>
            <h5 class="mb-0 fw-bold text-success">Basic Halal Guidelines</h5>
        </div>
    </div>

    <div class="container py-4" style="max-width: 800px;">
        <div class="alert alert-success border-0 bg-success bg-opacity-10 mb-4">
            <i class="bi bi-info-circle-fill me-2"></i>
            These guidelines outline the fundamental principles of Halal food preparation for businesses in non-Muslim majority areas.
        </div>

        <div class="accordion shadow-sm rounded-3 overflow-hidden" id="halalAccordion">
            
            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#c1" aria-expanded="true">
                        1. Permissible (Halal) vs. Prohibited (Haram)
                    </button>
                </h2>
                <div id="c1" class="accordion-collapse collapse show" data-bs-parent="#halalAccordion">
                    <div class="accordion-body text-secondary">
                        <p><strong>Halal (Permitted):</strong> Poultry, cattle, sheep, and goats slaughtered according to Islamic rites; seafood (fish, shrimp); vegetables, fruits, grains, and nuts (unless toxic/intoxicating).</p>
                        <p class="mb-0"><strong>Haram (Prohibited):</strong> Pork and pork by-products (lard, gelatin, ham, bacon); animals not slaughtered according to Islamic rites; alcohol and intoxicants; carnivorous animals and birds of prey.</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#c2">
                        2. Cross-Contamination Prevention
                    </button>
                </h2>
                <div id="c2" class="accordion-collapse collapse" data-bs-parent="#halalAccordion">
                    <div class="accordion-body text-secondary">
                        <p>Cross-contamination is the transfer of non-halal substances to halal food.</p>
                        <ul class="mb-0">
                            <li>Store Halal meat separately (preferably on a higher shelf or distinct freezer).</li>
                            <li>Use separate cutting boards (color-coded) and knives for Halal ingredients.</li>
                            <li>Wash hands thoroughly before handling Halal food.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#c3">
                        3. Ingredient Sourcing
                    </button>
                </h2>
                <div id="c3" class="accordion-collapse collapse" data-bs-parent="#halalAccordion">
                    <div class="accordion-body text-secondary">
                        <p>Ensure all processed ingredients are certified Halal.</p>
                        <ul class="mb-0">
                            <li>Check labels for hidden pork derivatives (e.g., gelatin, enzymes, emulsifiers like E471 if animal-based).</li>
                            <li>Verify that sauces (soy sauce, vanilla extract) do not contain alcohol.</li>
                            <li>Ask suppliers for Halal certificates for meat products.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#c4">
                        4. Utensils and Equipment Cleaning
                    </button>
                </h2>
                <div id="c4" class="accordion-collapse collapse" data-bs-parent="#halalAccordion">
                    <div class="accordion-body text-secondary">
                        <p class="mb-0">If separate utensils cannot be maintained, rigorous ritual cleansing (Sertu) is traditionally required if contaminated by heavy impurities (pork/dog). For general commercial "Halal-Friendly" practices, ensure equipment is thoroughly sanitized with industrial soap and hot water to remove all traces of non-halal grease before Halal prep.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-grid mt-4">
            <a href="owner_dashboard.php" class="btn btn-success py-2">I Understand, Return to Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>