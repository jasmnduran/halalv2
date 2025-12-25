<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halal Certification Application - Halal Keeps</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>
    .application-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
    }

    .step-indicator {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 20px;
      border-top: 4px solid var(--primary-green);
    }

    .step {
      display: flex;
      align-items: center;
      margin: 0 10px;
      padding: 10px 15px;
      border-radius: 25px;
      background: #f0f0f0;
      color: #666;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .step.active {
      background: var(--primary-green);
      color: white;
    }

    .step.completed {
      background: var(--secondary-green);
      color: white;
    }

    .step-number {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 8px;
      font-size: 0.9rem;
    }

    .form-section {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .form-section h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .form-section h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .form-row {
      display: flex;
      gap: 16px;
      margin-bottom: 16px;
    }

    .form-row .form-group {
      flex: 1;
      margin-bottom: 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      color: #333;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 0.95rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 14px 18px;
      border: 2px solid var(--input-border);
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #fafafa;
      box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--primary-green);
      background: white;
      box-shadow: 0 0 0 3px rgba(13, 140, 76, 0.1);
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .checkbox-group {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 10px;
    }

    .checkbox-item {
      display: flex;
      align-items: center;
      background: #f8f9fa;
      padding: 12px 15px;
      border-radius: 8px;
      border: 2px solid #e9ecef;
      transition: all 0.3s ease;
      cursor: pointer;
      flex: 1;
      min-width: 200px;
    }

    .checkbox-item:hover {
      border-color: var(--primary-green);
      background: var(--light-green);
    }

    .checkbox-item input[type="checkbox"] {
      margin-right: 10px;
      transform: scale(1.2);
    }

    .checkbox-item input[type="checkbox"]:checked + label {
      color: var(--primary-green);
      font-weight: 600;
    }

    .document-upload {
      border: 2px dashed var(--primary-green);
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      background: var(--light-green);
      margin: 10px 0;
    }

    .document-upload input[type="file"] {
      margin: 10px 0;
    }

    .document-list {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      margin: 10px 0;
    }

    .document-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #e9ecef;
    }

    .document-item:last-child {
      border-bottom: none;
    }

    .btn {
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(13, 140, 76, 0.3);
      padding: 15px 30px;
      text-decoration: none;
      display: inline-block;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(135deg, #6c757d, #5a6268);
    }

    .btn-secondary:hover {
      background: linear-gradient(135deg, #5a6268, #6c757d);
    }

    .navigation-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .info-box {
      background: var(--light-green);
      border: 2px solid var(--primary-green);
      border-radius: 10px;
      padding: 15px;
      margin: 15px 0;
    }

    .info-box h4 {
      color: var(--primary-green);
      margin-bottom: 10px;
    }

    .undertaking-section {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin: 20px 0;
    }

    .undertaking-section h4 {
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .undertaking-section ul {
      margin: 10px 0;
      padding-left: 20px;
    }

    .undertaking-section li {
      margin-bottom: 8px;
      line-height: 1.6;
    }

    /* Undertaking agreement compact checkbox */
    .checkbox-item.agree {
      background: transparent;
      border: none;
      padding: 0;
      min-width: auto;
      flex: 0 0 auto;
      gap: 10px;
    }
    .checkbox-item.agree input[type="checkbox"] {
      margin: 0;
      transform: scale(1.1);
    }
    .checkbox-item.agree label {
      display: inline;
      margin: 0;
      color: var(--primary-green);
      font-weight: 700;
      white-space: normal;
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      
      .form-section {
        padding: 25px 20px;
      }

      .step-indicator {
        flex-direction: column;
        gap: 10px;
      }

      .step {
        margin: 0;
      }

      .checkbox-group {
        flex-direction: column;
      }

      .checkbox-item {
        min-width: auto;
      }
    }
  </style>
</head>
<body>
  <div class="application-container">
    <img src="logo.jpg" alt="Halal Keeps Logo" class="logo">
    <h1 class="text-center">Halal Certification Application</h1>
    <p class="subtitle text-center">Complete your halal certification application in 6 easy steps</p>

    <!-- Step Indicator -->
    <div class="step-indicator">
      <div class="step active" id="step-1">
        <div class="step-number">1</div>
        <span>Basic Info</span>
      </div>
      <div class="step" id="step-2">
        <div class="step-number">2</div>
        <span>Certification Type</span>
      </div>
      <div class="step" id="step-3">
        <div class="step-number">3</div>
        <span>Details</span>
      </div>
      <div class="step" id="step-4">
        <div class="step-number">4</div>
        <span>Documents</span>
      </div>
      <div class="step" id="step-5">
        <div class="step-number">5</div>
        <span>Schedule</span>
      </div>
      <div class="step" id="step-6">
        <div class="step-number">6</div>
        <span>Agreement</span>
      </div>
    </div>

    <form id="certificationForm" action="actions/process_certification.php" method="post" enctype="multipart/form-data">
      
      <!-- Step 1: Basic Company Information -->
      <div class="form-section" id="section-1">
        <h2>Step 1: Basic Company Information</h2>
        
        <div class="form-row">
          <div class="form-group">
            <label for="applicant_name">Applicant Name *</label>
            <input type="text" id="applicant_name" name="applicant_name" required>
          </div>
          <div class="form-group">
            <label for="company_name">Company Name *</label>
            <input type="text" id="company_name" name="company_name" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="business_address">Business Address *</label>
            <textarea id="business_address" name="business_address" required></textarea>
          </div>
          <div class="form-group">
            <label for="mailing_address">Mailing Address</label>
            <textarea id="mailing_address" name="mailing_address"></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="ownership_type">Type of Ownership *</label>
            <select id="ownership_type" name="ownership_type" required>
              <option value="">Select Ownership Type</option>
              <option value="sole_proprietorship">Sole Proprietorship</option>
              <option value="partnership">Partnership</option>
              <option value="corporation">Corporation</option>
              <option value="cooperative">Cooperative</option>
            </select>
          </div>
          <div class="form-group">
            <label for="contact_person">Contact Person *</label>
            <input type="text" id="contact_person" name="contact_person" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="telephone">Phone Number *</label>
            <input type="tel" id="telephone" name="telephone" required>
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
          </div>
        </div>
      </div>

      <!-- Step 2: Type of Certification -->
      <div class="form-section" id="section-2" style="display: none;">
        <h2>Step 2: Type of Certification</h2>
        
        <div class="form-group">
          <label>Application Type *</label>
          <div class="checkbox-group">
            <div class="checkbox-item">
              <input type="radio" id="initial" name="application_type" value="initial" required>
              <label for="initial">Initial Application</label>
            </div>
            <div class="checkbox-item">
              <input type="radio" id="renewal" name="application_type" value="renewal" required>
              <label for="renewal">Renewal</label>
            </div>
            <div class="checkbox-item">
              <input type="radio" id="scope_extension" name="application_type" value="scope_extension" required>
              <label for="scope_extension">Scope Extension</label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Certification Type *</label>
          <div class="checkbox-group">
            <div class="checkbox-item">
              <input type="radio" id="product" name="certification_type" value="product" required>
              <label for="product">Product Certification</label>
            </div>
            <div class="checkbox-item">
              <input type="radio" id="establishment" name="certification_type" value="establishment" required>
              <label for="establishment">Establishment Certification</label>
            </div>
            <div class="checkbox-item">
              <input type="radio" id="abattoir" name="certification_type" value="abattoir" required>
              <label for="abattoir">Abattoir Certification</label>
            </div>
          </div>
        </div>
      </div>

      <!-- Step 3: Certification Details -->
      <div class="form-section" id="section-3" style="display: none;">
        <h2>Step 3: Certification Details</h2>
        
        <!-- Product Certification Details -->
        <div id="product-details" style="display: none;">
          <h3>Product Information</h3>
          <div class="form-group">
            <label for="product_list">Product List *</label>
            <textarea id="product_list" name="product_list" placeholder="List all products to be certified"></textarea>
          </div>
          <div class="form-group">
            <label for="product_categories">Product Categories</label>
            <input type="text" id="product_categories" name="product_categories" placeholder="e.g., Food, Beverages, Cosmetics">
          </div>
        </div>

        <!-- Establishment Certification Details -->
        <div id="establishment-details" style="display: none;">
          <h3>Establishment Information</h3>
          <div class="form-group">
            <label for="establishment_type">Type of Establishment *</label>
            <select id="establishment_type" name="establishment_type">
              <option value="">Select Establishment Type</option>
              <option value="restaurant">Restaurant</option>
              <option value="food_manufacturing">Food Manufacturing</option>
              <option value="retail">Retail Store</option>
              <option value="catering">Catering Service</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="establishment_capacity">Establishment Capacity</label>
            <input type="text" id="establishment_capacity" name="establishment_capacity" placeholder="e.g., 50 seats, 1000 sqm">
          </div>
        </div>

        <!-- Abattoir Certification Details -->
        <div id="abattoir-details" style="display: none;">
          <h3>Abattoir Information</h3>
          <div class="form-group">
            <label for="abattoir_capacity">Daily Slaughtering Capacity *</label>
            <input type="text" id="abattoir_capacity" name="abattoir_capacity" placeholder="e.g., 50 heads per day">
          </div>
          <div class="form-group">
            <label for="animal_types">Types of Animals</label>
            <input type="text" id="animal_types" name="animal_types" placeholder="e.g., Cattle, Sheep, Goats">
          </div>
        </div>
      </div>

      <!-- Step 4: Required Documents -->
      <div class="form-section" id="section-4" style="display: none;">
        <h2>Step 4: Required Documents</h2>
        
        <div class="info-box">
          <h4>📋 Document Checklist</h4>
          <p>Please upload all required documents. Documents marked with * are mandatory.</p>
        </div>

        <div id="document-requirements">
          <!-- Documents will be populated based on certification type -->
        </div>
      </div>

      <!-- Step 5: Audit Schedule -->
      <div class="form-section" id="section-5" style="display: none;">
        <h2>Step 5: Audit Schedule</h2>
        
        <div class="form-group">
          <label for="halal_seminar_date">Preferred Halal Seminar Date *</label>
          <input type="date" id="halal_seminar_date" name="halal_seminar_date" required>
        </div>

        <div class="form-group">
          <label for="first_audit_date">Preferred First Audit Date *</label>
          <input type="date" id="first_audit_date" name="first_audit_date" required>
        </div>

        <div class="form-group">
          <label for="final_audit_date">Preferred Final Audit Date *</label>
          <input type="date" id="final_audit_date" name="final_audit_date" required>
        </div>

        <div class="info-box">
          <h4>📅 Schedule Information</h4>
          <p>Please note that dates are subject to availability. We will contact you to confirm the final schedule.</p>
        </div>
      </div>

      <!-- Step 6: Agreement & Undertaking -->
      <div class="form-section" id="section-6" style="display: none;">
        <h2>Step 6: Agreement & Undertaking</h2>
        
        <div class="undertaking-section">
          <h4>UNDERTAKING</h4>
          <p>I, <strong id="applicant-name-display">[Applicant Name]</strong>, hereby apply for Halal Certification and undertake to:</p>
          
          <ul>
            <li>Comply with all Halal requirements and standards as prescribed by the certifying body</li>
            <li>Allow inspection of premises, equipment, and processes at any time</li>
            <li>Maintain proper records of all halal products and ingredients</li>
            <li>Notify the certifying body of any changes in products, processes, or ingredients</li>
            <li>Pay all required fees and charges as per the certification agreement</li>
            <li>Cooperate fully with audit procedures and provide necessary documentation</li>
            <li>Abide by the terms and conditions of the Halal certification agreement</li>
          </ul>

          <div class="form-group">
            <div class="checkbox-item agree">
              <input type="checkbox" id="undertaking_agreement" name="undertaking_agreement" required>
              <label for="undertaking_agreement">I agree to the above undertaking and terms *</label>
            </div>
          </div>

          <div class="form-group">
            <label for="signature">Digital Signature *</label>
            <input type="text" id="signature" name="signature" placeholder="Type your full name as digital signature" required>
          </div>

          <div class="form-group">
            <label for="application_date">Application Date *</label>
            <input type="date" id="application_date" name="application_date" required>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="navigation-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">Previous</button>
        <button type="button" class="btn" id="nextBtn" onclick="changeStep(1)">Next</button>
        <button type="submit" class="btn" id="submitBtn" style="display: none;">Submit Application</button>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentStep = 1;
    const totalSteps = 6;

    // Document requirements based on certification type
    const documentRequirements = {
      product: [
        { name: 'Letter of Intent', required: true },
        { name: 'SEC/DTI Registration', required: true },
        { name: 'Product Specifications', required: true },
        { name: 'Ingredient List', required: true },
        { name: 'Manufacturing Process Flow', required: true },
        { name: 'Quality Control Procedures', required: false },
        { name: 'Packaging Information', required: true }
      ],
      establishment: [
        { name: 'SEC/DTI Registration', required: true },
        { name: 'Company Profile', required: true },
        { name: 'Process Flow Charts', required: true },
        { name: 'Environmental Compliance Certificate (ECC)', required: true },
        { name: 'Layout Plan', required: true },
        { name: 'Mayor\'s Permit', required: true },
        { name: 'Fire Safety Certificate', required: false },
        { name: 'Sanitary Permit', required: true }
      ],
      abattoir: [
        { name: 'NMIS Accreditation', required: true },
        { name: 'Operating Flow Chart', required: true },
        { name: 'Building Permit', required: true },
        { name: 'Environmental Compliance Certificate (ECC)', required: true },
        { name: 'Veterinary Certificate', required: true },
        { name: 'Slaughtering Procedures', required: true },
        { name: 'Waste Management Plan', required: false }
      ]
    };

    function changeStep(direction) {
      const newStep = currentStep + direction;
      
      if (newStep < 1 || newStep > totalSteps) return;
      
      // Hide current section
      document.getElementById(`section-${currentStep}`).style.display = 'none';
      document.getElementById(`step-${currentStep}`).classList.remove('active');
      
      // Show new section
      currentStep = newStep;
      document.getElementById(`section-${currentStep}`).style.display = 'block';
      document.getElementById(`step-${currentStep}`).classList.add('active');
      
      // Update navigation buttons
      updateNavigationButtons();
      
      // Handle specific step logic
      handleStepLogic();
    }

    function updateNavigationButtons() {
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const submitBtn = document.getElementById('submitBtn');
      
      prevBtn.style.display = currentStep > 1 ? 'block' : 'none';
      
      if (currentStep === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
      } else {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
      }
    }

    function handleStepLogic() {
      if (currentStep === 3) {
        // Show/hide details based on certification type
        const certificationType = document.querySelector('input[name="certification_type"]:checked');
        if (certificationType) {
          showCertificationDetails(certificationType.value);
        }
      } else if (currentStep === 4) {
        // Show document requirements
        const certificationType = document.querySelector('input[name="certification_type"]:checked');
        if (certificationType) {
          showDocumentRequirements(certificationType.value);
        }
      } else if (currentStep === 6) {
        // Update applicant name in undertaking
        const applicantName = document.getElementById('applicant_name').value;
        document.getElementById('applicant-name-display').textContent = applicantName || '[Applicant Name]';
      }
    }

    function showCertificationDetails(type) {
      // Hide all detail sections
      document.getElementById('product-details').style.display = 'none';
      document.getElementById('establishment-details').style.display = 'none';
      document.getElementById('abattoir-details').style.display = 'none';
      
      // Show relevant section
      if (type === 'product') {
        document.getElementById('product-details').style.display = 'block';
      } else if (type === 'establishment') {
        document.getElementById('establishment-details').style.display = 'block';
      } else if (type === 'abattoir') {
        document.getElementById('abattoir-details').style.display = 'block';
      }
    }

    function showDocumentRequirements(type) {
      const container = document.getElementById('document-requirements');
      const requirements = documentRequirements[type] || [];
      
      container.innerHTML = '';
      
      requirements.forEach((doc, index) => {
        const docDiv = document.createElement('div');
        docDiv.className = 'document-list';
        docDiv.innerHTML = `
          <div class="document-item">
            <div>
              <strong>${doc.name}</strong>
              ${doc.required ? '<span style="color: red;">*</span>' : ''}
            </div>
            <div class="document-upload">
              <input type="file" name="document_${index}" id="document_${index}" ${doc.required ? 'required' : ''}>
              <label for="document_${index}">Choose File</label>
            </div>
          </div>
        `;
        container.appendChild(docDiv);
      });
    }

    // Event listeners
    document.querySelectorAll('input[name="certification_type"]').forEach(radio => {
      radio.addEventListener('change', function() {
        if (currentStep === 3) {
          showCertificationDetails(this.value);
        } else if (currentStep === 4) {
          showDocumentRequirements(this.value);
        }
      });
    });

    // Set today's date as default for application date
    document.getElementById('application_date').value = new Date().toISOString().split('T')[0];

    // jQuery Mobile initialization
    $(document).ready(function() {
      $.mobile.initializePage();
      
      $('input, button, select, textarea').on('touchstart', function() {
        $(this).addClass('ui-btn-active');
      }).on('touchend', function() {
        $(this).removeClass('ui-btn-active');
      });
    });
  </script>
</body>
</html>
