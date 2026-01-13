<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halal Certification Application - Halal Keeps</title>
  
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

    .app-container { max-width: 900px; margin: 0 auto; }

    /* Wizard Steps */
    .step-indicator {
        position: relative;
        z-index: 1;
        padding: 0 20px;
    }
    .step-item {
        text-align: center;
        flex: 1;
        position: relative;
        opacity: 0.5;
        transition: opacity 0.3s;
    }
    .step-item.active { opacity: 1; font-weight: 700; }
    .step-item.completed { opacity: 1; color: var(--primary-green); }
    
    .step-circle {
        width: 32px;
        height: 32px;
        background: #e9ecef;
        color: #6c757d;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 600;
        border: 2px solid #dee2e6;
        transition: all 0.3s;
    }
    .step-item.active .step-circle {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(13, 140, 76, 0.2);
    }
    .step-item.completed .step-circle {
        background: var(--secondary-green);
        color: white;
        border-color: var(--secondary-green);
    }

    /* Selection Cards */
    .selection-card {
        border: 2px solid #e9ecef;
        border-radius: 0.75rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .selection-card:hover { border-color: var(--secondary-green); background: #f0fff4; }
    .form-check-input:checked + .selection-card-label .selection-card {
        border-color: var(--primary-green);
        background: #e8f5e9;
        box-shadow: 0 4px 10px rgba(13, 140, 76, 0.1);
    }

    .form-section { animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>
<body class="py-4">
  <div class="container app-container">
    
    <div class="text-center mb-5">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border border-3 border-success mb-3" width="70" height="70">
        <h2 class="fw-bold text-dark">Halal Certification</h2>
        <p class="text-muted">Application Wizard</p>
    </div>

    <div class="d-flex justify-content-between mb-5 position-relative step-indicator">
        <div class="position-absolute top-0 start-0 w-100 mt-3 border-top border-2" style="z-index: -1;"></div>
        
        <div class="step-item active" id="step-1">
            <div class="step-circle">1</div>
            <span class="d-none d-sm-block small">Basic Info</span>
        </div>
        <div class="step-item" id="step-2">
            <div class="step-circle">2</div>
            <span class="d-none d-sm-block small">Type</span>
        </div>
        <div class="step-item" id="step-3">
            <div class="step-circle">3</div>
            <span class="d-none d-sm-block small">Details</span>
        </div>
        <div class="step-item" id="step-4">
            <div class="step-circle">4</div>
            <span class="d-none d-sm-block small">Docs</span>
        </div>
        <div class="step-item" id="step-5">
            <div class="step-circle">5</div>
            <span class="d-none d-sm-block small">Schedule</span>
        </div>
        <div class="step-item" id="step-6">
            <div class="step-circle">6</div>
            <span class="d-none d-sm-block small">Finish</span>
        </div>
    </div>

    <form id="certificationForm" action="actions/process_certification.php" method="post" enctype="multipart/form-data">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            
            <div class="form-section" id="section-1">
                <h4 class="fw-bold text-success mb-4"><i class="bi bi-building me-2"></i>Company Information</h4>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Name" required>
                            <label>Applicant Name *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company" required>
                            <label>Company Name *</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="business_address" name="business_address" placeholder="Address" style="height: 80px" required></textarea>
                            <label>Business Address *</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="mailing_address" name="mailing_address" placeholder="Mailing Address" style="height: 80px"></textarea>
                            <label>Mailing Address (If different)</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="ownership_type" name="ownership_type" required>
                                <option value="">Select...</option>
                                <option value="sole_proprietorship">Sole Proprietorship</option>
                                <option value="partnership">Partnership</option>
                                <option value="corporation">Corporation</option>
                                <option value="cooperative">Cooperative</option>
                            </select>
                            <label>Ownership Type *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact" required>
                            <label>Contact Person *</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Phone" required>
                            <label>Phone Number *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label>Email Address *</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section" id="section-2" style="display: none;">
                <h4 class="fw-bold text-success mb-4"><i class="bi bi-list-check me-2"></i>Certification Scope</h4>
                
                <label class="form-label fw-bold small text-uppercase text-muted">Application Type</label>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="application_type" id="initial" value="initial" required>
                        <label class="selection-card-label w-100" for="initial">
                            <div class="selection-card text-center">
                                <i class="bi bi-file-earmark-plus fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold d-block">Initial</span>
                                <small class="text-muted">New Application</small>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="application_type" id="renewal" value="renewal">
                        <label class="selection-card-label w-100" for="renewal">
                            <div class="selection-card text-center">
                                <i class="bi bi-arrow-repeat fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold d-block">Renewal</span>
                                <small class="text-muted">Existing Certificate</small>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="application_type" id="scope_extension" value="scope_extension">
                        <label class="selection-card-label w-100" for="scope_extension">
                            <div class="selection-card text-center">
                                <i class="bi bi-arrows-expand fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold d-block">Extension</span>
                                <small class="text-muted">Add Products</small>
                            </div>
                        </label>
                    </div>
                </div>

                <label class="form-label fw-bold small text-uppercase text-muted">Category</label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="certification_type" id="product" value="product" required>
                        <label class="selection-card-label w-100" for="product">
                            <div class="selection-card text-center">
                                <i class="bi bi-box-seam fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold">Product</span>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="certification_type" id="establishment" value="establishment">
                        <label class="selection-card-label w-100" for="establishment">
                            <div class="selection-card text-center">
                                <i class="bi bi-shop fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold">Establishment</span>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" class="form-check-input d-none" name="certification_type" id="abattoir" value="abattoir">
                        <label class="selection-card-label w-100" for="abattoir">
                            <div class="selection-card text-center">
                                <i class="bi bi-egg-fried fs-3 d-block mb-2 text-muted"></i>
                                <span class="fw-bold">Abattoir</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-section" id="section-3" style="display: none;">
                <h4 class="fw-bold text-success mb-4"><i class="bi bi-info-circle me-2"></i>Specific Details</h4>
                
                <div id="product-details" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Product List *</label>
                        <textarea class="form-control" name="product_list" rows="4" placeholder="List all products to be certified..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <input type="text" class="form-control" name="product_categories" placeholder="e.g. Beverages, Canned Goods">
                    </div>
                </div>

                <div id="establishment-details" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Type of Establishment</label>
                        <select class="form-select" name="establishment_type">
                            <option value="restaurant">Restaurant</option>
                            <option value="food_manufacturing">Food Manufacturing</option>
                            <option value="retail">Retail Store</option>
                            <option value="catering">Catering Service</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacity (Seats/Size)</label>
                        <input type="text" class="form-control" name="establishment_capacity" placeholder="e.g. 50 seats">
                    </div>
                </div>

                <div id="abattoir-details" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Daily Capacity *</label>
                        <input type="text" class="form-control" name="abattoir_capacity" placeholder="e.g. 50 heads/day">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Animals Processed</label>
                        <input type="text" class="form-control" name="animal_types" placeholder="e.g. Cattle, Goat">
                    </div>
                </div>
            </div>

            <div class="form-section" id="section-4" style="display: none;">
                <h4 class="fw-bold text-success mb-3"><i class="bi bi-folder2-open me-2"></i>Upload Documents</h4>
                <div class="alert alert-info border-0 bg-info bg-opacity-10 small mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i> Upload PDF or JPEG files only. Max 5MB per file.
                </div>
                <div id="document-requirements" class="d-grid gap-3">
                    </div>
            </div>

            <div class="form-section" id="section-5" style="display: none;">
                <h4 class="fw-bold text-success mb-4"><i class="bi bi-calendar-event me-2"></i>Audit Schedule</h4>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Preferred Seminar Date</label>
                        <input type="date" class="form-control" name="halal_seminar_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Preferred First Audit</label>
                        <input type="date" class="form-control" name="first_audit_date" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Preferred Final Audit</label>
                        <input type="date" class="form-control" name="final_audit_date" required>
                    </div>
                </div>
            </div>

            <div class="form-section" id="section-6" style="display: none;">
                <h4 class="fw-bold text-success mb-4"><i class="bi bi-pen me-2"></i>Undertaking</h4>
                
                <div class="bg-light p-4 rounded-3 mb-4 border">
                    <p class="mb-3">I, <strong class="text-dark" id="applicant-name-display">[Name]</strong>, hereby undertake to:</p>
                    <ul class="small text-muted mb-0">
                        <li>Comply with all Halal requirements and standards.</li>
                        <li>Allow inspection of premises at any time.</li>
                        <li>Maintain proper records of ingredients.</li>
                        <li>Pay all required fees and charges.</li>
                    </ul>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="undertaking_agreement" required>
                    <label class="form-check-label fw-bold text-dark" for="undertaking_agreement">
                        I agree to the terms and conditions above.
                    </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="signature" name="signature" placeholder="Signature" required>
                    <label>Digital Signature (Type Full Name) *</label>
                </div>
                
                <input type="hidden" id="application_date" name="application_date">
            </div>

            <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" id="prevBtn" onclick="changeStep(-1)" style="display:none;">Back</button>
                <button type="button" class="btn btn-success px-5 rounded-pill shadow fw-bold" id="nextBtn" onclick="changeStep(1)">Next Step</button>
                <button type="submit" class="btn btn-success px-5 rounded-pill shadow fw-bold" id="submitBtn" style="display:none;">Submit Application</button>
            </div>

        </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentStep = 1;
    const totalSteps = 6;

    // Add this function to fetch user data
async function initUserProfile() {
    try {
        const res = await fetch('api/user.php');
        const data = await res.json();
        
        if (data.is_logged_in && data.user.role === 'owner') {
            // Auto-fill form fields
            // We use document.getElementsByName because your form uses name="company_name"
            if(document.querySelector('[name="applicant_name"]')) document.querySelector('[name="applicant_name"]').value = data.user.name || '';
            if(document.querySelector('[name="company_name"]')) document.querySelector('[name="company_name"]').value = data.user.business || '';
            if(document.querySelector('[name="email"]')) document.querySelector('[name="email"]').value = data.user.email || '';
            if(document.querySelector('[name="contact_person"]')) document.querySelector('[name="contact_person"]').value = data.user.name || '';
            
            // Handle Address (textarea)
            if(document.querySelector('[name="business_address"]')) document.querySelector('[name="business_address"]').value = data.user.location || '';
        }
    } catch (e) {
        console.error("Auto-fill error:", e);
    }
}

    const docsMap = {
      product: ['Letter of Intent', 'SEC/DTI Reg', 'Product Specs', 'Ingredient List', 'Process Flow', 'Packaging Info'],
      establishment: ['SEC/DTI Reg', 'Company Profile', 'Process Flow', 'ECC', 'Floor Plan', 'Mayor\'s Permit', 'Sanitary Permit'],
      abattoir: ['NMIS Accreditation', 'Building Permit', 'ECC', 'Vet Cert', 'Slaughter Procedure']
    };

    function changeStep(n) {
      // Simple validation for demo
      const currentSection = document.getElementById(`section-${currentStep}`);
      const inputs = currentSection.querySelectorAll('input[required], select[required], textarea[required]');
      let valid = true;
      inputs.forEach(i => {
          if (!i.value) { i.classList.add('is-invalid'); valid = false; }
          else { i.classList.remove('is-invalid'); }
      });
      
      if (n === 1 && !valid) return;

      document.getElementById(`section-${currentStep}`).style.display = 'none';
      document.getElementById(`step-${currentStep}`).classList.remove('active');
      document.getElementById(`step-${currentStep}`).classList.add('completed');

      currentStep += n;
      
      document.getElementById(`section-${currentStep}`).style.display = 'block';
      document.getElementById(`step-${currentStep}`).classList.add('active');
      
      updateButtons();
      runStepLogic();
    }

    function updateButtons() {
      document.getElementById('prevBtn').style.display = currentStep > 1 ? 'block' : 'none';
      if (currentStep === totalSteps) {
        document.getElementById('nextBtn').style.display = 'none';
        document.getElementById('submitBtn').style.display = 'block';
      } else {
        document.getElementById('nextBtn').style.display = 'block';
        document.getElementById('submitBtn').style.display = 'none';
      }
    }

    function runStepLogic() {
      const type = document.querySelector('input[name="certification_type"]:checked')?.value || 'product';
      
      if (currentStep === 3) {
        ['product','establishment','abattoir'].forEach(t => document.getElementById(`${t}-details`).style.display = 'none');
        document.getElementById(`${type}-details`).style.display = 'block';
      }
      
      if (currentStep === 4) {
        const container = document.getElementById('document-requirements');
        container.innerHTML = (docsMap[type] || []).map((doc, i) => `
            <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                <div><strong class="text-dark">${doc}</strong> <span class="text-danger">*</span></div>
                <input type="file" class="form-control form-control-sm w-50" name="doc_${i}" required>
            </div>
        `).join('');
      }

      if (currentStep === 6) {
        document.getElementById('applicant-name-display').textContent = document.getElementById('applicant_name').value;
      }
    }

    document.getElementById('application_date').value = new Date().toISOString().split('T')[0];
    // ... existing code ...

document.addEventListener('DOMContentLoaded', () => {
    initUserProfile(); // <--- Call the function here
    
    // Any other startup logic you have...
});
  </script>
</body>
</html>