<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Portal - Halal Keeps</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #0d8c4c;
            --secondary-green: #16a765;
            --light-green: #e8f5e9;
            --bs-body-bg: #f5f7fa;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bs-body-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar & Layout */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid #eee;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            padding: 1.5rem;
            z-index: 1030;
            transition: transform 0.3s;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s;
            width: calc(100% - 280px);
        }
        
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
        }

        .nav-link {
            color: #64748b;
            font-weight: 500;
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover, .nav-link.active {
            background-color: var(--light-green);
            color: var(--primary-green);
        }
        .nav-link.active { font-weight: 600; }

        /* Wizard Stepper */
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 2rem; position: relative; }
        .step-line { position: absolute; top: 15px; left: 0; width: 100%; height: 2px; background: #e9ecef; z-index: 0; }
        .step-progress { position: absolute; top: 15px; left: 0; height: 2px; background: var(--primary-green); z-index: 0; transition: width 0.3s; }
        .step-item { position: relative; z-index: 1; text-align: center; flex: 1; opacity: 0.5; transition: opacity 0.3s; }
        .step-item.active { opacity: 1; font-weight: 700; }
        .step-item.completed { opacity: 1; color: var(--primary-green); }
        .step-circle {
            width: 32px; height: 32px; background: white; border: 2px solid #dee2e6;
            color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.5rem; font-weight: 600; transition: all 0.3s;
        }
        .step-item.active .step-circle {
            background: var(--primary-green); color: white; border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(13, 140, 76, 0.2);
        }
        .step-item.completed .step-circle {
            background: var(--secondary-green); color: white; border-color: var(--secondary-green);
        }

        /* Views */
        .view-section { display: none; animation: fadeIn 0.3s ease; }
        .view-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* Dashboard Cards */
        .dash-card {
            border: none; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            background: white; padding: 1.5rem; height: 100%;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white border-bottom d-lg-none sticky-top px-3">
        <button class="btn btn-light" type="button" onclick="toggleSidebar()">
            <i class="bi bi-list fs-4"></i>
        </button>
        <span class="fw-bold text-dark">Applicant Portal</span>
        <div style="width: 40px;"></div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="d-flex align-items-center gap-3 mb-5 px-2">
            <img src="logo.jpg" alt="Logo" class="rounded-circle border border-success" width="40" height="40">
            <div>
                <h6 class="fw-bold mb-0 text-dark">Halal Keeps</h6>
                <small class="text-muted">Applicant Portal</small>
            </div>
        </div>

        <div class="mb-4 px-2">
            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                <div class="bg-white p-2 rounded-circle shadow-sm text-success">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold mb-0 text-truncate" id="sidebarUserName">Business Owner</h6>
                    <small class="text-muted">User</small>
                </div>
            </div>
        </div>

        <nav class="nav flex-column">
            <a href="#" class="nav-link active" onclick="app.showDashboard()"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a href="#" class="nav-link" onclick="app.showWizard()"><i class="bi bi-file-earmark-plus-fill"></i> New Application</a>
            <a href="#" class="nav-link" onclick="app.showProgress()"><i class="bi bi-hourglass-split"></i> Track Status</a>
            <a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        
        <div id="view-dashboard" class="view-section active">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark mb-0">Overview</h2>
                <button class="btn btn-success rounded-pill px-4" onclick="app.showWizard()">
                    <i class="bi bi-plus-lg me-2"></i>Apply Now
                </button>
            </div>

            <div id="dash-empty" class="text-center py-5 bg-white rounded-4 border border-dashed d-none">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-3 text-muted">
                    <i class="bi bi-clipboard-data fs-1"></i>
                </div>
                <h4>No Active Applications</h4>
                <p class="text-muted">Start your Halal certification journey today.</p>
            </div>

            <div id="dash-active">
                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="dash-card border-start border-5 border-success">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1" id="dashCompanyName">Loading...</h5>
                                    <span class="badge bg-warning text-dark">Under Review</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Application ID</small>
                                    <span class="font-monospace fw-bold" id="dashAppId">...</span>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-success" id="dashProgress" style="width: 0%"></div>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Progress</span>
                                <span id="dashProgressText">0%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dash-card">
                            <h6 class="fw-bold mb-3 text-muted text-uppercase small">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="app.showProgress()">View Full Details</button>
                                <button class="btn btn-outline-danger btn-sm" onclick="app.deleteApplication()">Withdraw App</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="dash-card">
                            <h6 class="fw-bold mb-3">Recent Notifications</h6>
                            <div id="notificationList" class="list-group list-group-flush">
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-card">
                            <h6 class="fw-bold mb-3">Company Profile</h6>
                            <ul class="list-unstyled small text-muted mb-0" id="dashCompanyDetails">
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-wizard" class="view-section">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="step-indicator mb-0">
                        <div class="step-line"></div>
                        <div class="step-progress" id="wizardProgress" style="width: 0%"></div>
                        <div class="step-item active" data-step="1"><div class="step-circle">1</div><small>Info</small></div>
                        <div class="step-item" data-step="2"><div class="step-circle">2</div><small>Type</small></div>
                        <div class="step-item" data-step="3"><div class="step-circle">3</div><small>Items</small></div>
                        <div class="step-item" data-step="4"><div class="step-circle">4</div><small>Docs</small></div>
                        <div class="step-item" data-step="5"><div class="step-circle">5</div><small>Finish</small></div>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form id="wizardForm">
                        
                        <div class="wizard-step" id="step-1-content">
                            <h4 class="fw-bold text-success mb-4">Company Information</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="companyName" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" name="contactPerson" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="2" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-step d-none" id="step-2-content">
                            <h4 class="fw-bold text-success mb-4">Manufacturing Details</h4>
                            <div class="mb-4">
                                <label class="form-label d-block fw-bold mb-3">Product Source</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="manufacturing" id="manLocal" value="local" checked>
                                    <label class="btn btn-outline-success" for="manLocal">Locally Manufactured</label>
                                    
                                    <input type="radio" class="btn-check" name="manufacturing" id="manImport" value="imported">
                                    <label class="btn btn-outline-success" for="manImport">Imported</label>
                                </div>
                            </div>
                            
                            <div id="localFields">
                                <label class="form-label">Number of Plants</label>
                                <input type="number" class="form-control mb-3" id="numPlants" placeholder="e.g. 1">
                                <div id="plantAddresses"></div>
                            </div>
                        </div>

                        <div class="wizard-step d-none" id="step-3-content">
                            <h4 class="fw-bold text-success mb-4">Product Items</h4>
                            <div id="itemList" class="mb-3"></div>
                            <button type="button" class="btn btn-light w-100 border-dashed" onclick="app.addItemRow()">
                                <i class="bi bi-plus-circle me-2"></i>Add Product Item
                            </button>
                        </div>

                        <div class="wizard-step d-none" id="step-4-content">
                            <h4 class="fw-bold text-success mb-4">Required Documents</h4>
                            <div class="alert alert-info small mb-4"><i class="bi bi-info-circle me-2"></i>Upload PDF files only.</div>
                            <div id="docList" class="d-grid gap-3"></div>
                        </div>

                        <div class="wizard-step d-none" id="step-5-content">
                            <h4 class="fw-bold text-success mb-4">Review & Submit</h4>
                            <div class="bg-light p-4 rounded-3 mb-4">
                                <p class="mb-2">I hereby certify that the information provided is true and correct.</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="certifyCheck" required>
                                    <label class="form-check-label fw-bold" for="certifyCheck">I Agree</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" id="prevBtn" onclick="app.prevStep()">Back</button>
                            <button type="button" class="btn btn-success px-5 rounded-pill fw-bold" id="nextBtn" onclick="app.nextStep()">Next Step</button>
                            <button type="button" class="btn btn-success px-5 rounded-pill fw-bold d-none" id="submitBtn" onclick="app.submitApp()">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="view-progress" class="view-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark mb-0">Application Status</h2>
                <button class="btn btn-outline-secondary btn-sm" onclick="app.showDashboard()">Back</button>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div id="progressContent">
                    </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const app = {
            state: {
                step: 1,
                maxSteps: 5,
                appData: JSON.parse(localStorage.getItem('halal_app_data')) || null,
                documents: ['Business Permit', 'Sanitary Permit', 'Product List', 'Process Flow', 'Halal Policy'],
                reviewData: {}
            },

            init: function() {
                this.updateUI();
                this.setupListeners();
                
                // Initialize plant address inputs
                $('#numPlants').on('input', function() {
                    const count = parseInt($(this).val()) || 0;
                    const container = $('#plantAddresses');
                    container.empty();
                    for(let i=0; i<count; i++) {
                        container.append(`<input type="text" class="form-control mb-2" placeholder="Address for Plant ${i+1}">`);
                    }
                });
            },

            // Navigation Logic
            showDashboard: function() {
                $('.view-section').removeClass('active');
                $('#view-dashboard').addClass('active');
                this.renderDashboard();
            },

            showWizard: function() {
                if(this.state.appData && !confirm("Start new application? Existing data will be lost.")) return;
                
                this.state.step = 1;
                this.resetForm();
                $('.view-section').removeClass('active');
                $('#view-wizard').addClass('active');
                this.updateWizardUI();
                this.renderDocs();
                this.addItemRow(); // Initial row
            },

            showProgress: function() {
                if(!this.state.appData) { alert("No active application."); return; }
                $('.view-section').removeClass('active');
                $('#view-progress').addClass('active');
                this.renderProgress();
            },

            // Wizard Logic
            nextStep: function() {
                if(!this.validateStep(this.state.step)) return;
                if(this.state.step < this.state.maxSteps) {
                    this.state.step++;
                    this.updateWizardUI();
                }
            },

            prevStep: function() {
                if(this.state.step > 1) {
                    this.state.step--;
                    this.updateWizardUI();
                }
            },

            updateWizardUI: function() {
                $('.wizard-step').addClass('d-none');
                $(`#step-${this.state.step}-content`).removeClass('d-none');
                
                // Stepper Visuals
                $('.step-item').removeClass('active completed');
                for(let i=1; i<=this.state.maxSteps; i++) {
                    if(i < this.state.step) $(`.step-item[data-step="${i}"]`).addClass('completed');
                    if(i === this.state.step) $(`.step-item[data-step="${i}"]`).addClass('active');
                }
                const progress = ((this.state.step - 1) / (this.state.maxSteps - 1)) * 100;
                $('#wizardProgress').css('width', `${progress}%`);

                // Buttons
                $('#prevBtn').toggle(this.state.step > 1);
                $('#nextBtn').toggle(this.state.step < this.state.maxSteps);
                $('#submitBtn').toggleClass('d-none', this.state.step !== this.state.maxSteps);
            },

            validateStep: function(step) {
                const inputs = $(`#step-${step}-content`).find('input[required], textarea[required]');
                let valid = true;
                inputs.each(function() {
                    if(!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                return valid;
            },

            // Form Helpers
            addItemRow: function() {
                $('#itemList').append(`
                    <div class="input-group mb-2 item-row">
                        <input type="text" class="form-control" placeholder="Product Name">
                        <select class="form-select" style="max-width: 120px;">
                            <option>Food</option><option>Non-Food</option>
                        </select>
                        <button type="button" class="btn btn-outline-danger" onclick="$(this).parent().remove()"><i class="bi bi-trash"></i></button>
                    </div>
                `);
            },

            renderDocs: function() {
                $('#docList').html(this.state.documents.map(doc => `
                    <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-light">
                        <span class="fw-medium">${doc} *</span>
                        <input type="file" class="form-control form-control-sm w-50">
                    </div>
                `).join(''));
            },

            submitApp: function() {
                if(!$('#certifyCheck').is(':checked')) { alert("Please agree to terms."); return; }
                
                // Collect Data
                const formData = {
                    id: 'APP-' + Math.floor(Math.random()*10000),
                    company: $('input[name="companyName"]').val(),
                    date: new Date().toISOString(),
                    status: 'Pending',
                    items: $('.item-row').length,
                    progress: 10 // Initial progress
                };
                
                localStorage.setItem('halal_app_data', JSON.stringify(formData));
                this.state.appData = formData;
                
                alert("Application Submitted Successfully!");
                this.showDashboard();
            },

            resetForm: function() {
                $('#wizardForm')[0].reset();
                $('#itemList').empty();
                $('#plantAddresses').empty();
            },

            deleteApplication: function() {
                if(confirm("Are you sure? This cannot be undone.")) {
                    localStorage.removeItem('halal_app_data');
                    this.state.appData = null;
                    this.renderDashboard();
                }
            },

            // Renderers
            renderDashboard: function() {
                const data = this.state.appData;
                if(!data) {
                    $('#dash-empty').removeClass('d-none');
                    $('#dash-active').addClass('d-none');
                } else {
                    $('#dash-empty').addClass('d-none');
                    $('#dash-active').removeClass('d-none');
                    
                    $('#dashCompanyName').text(data.company);
                    $('#dashAppId').text(data.id);
                    $('#dashProgress').css('width', data.progress + '%');
                    $('#dashProgressText').text(data.progress + '%');
                    
                    $('#dashCompanyDetails').html(`
                        <li><i class="bi bi-calendar3 me-2"></i>Submitted: ${new Date(data.date).toLocaleDateString()}</li>
                        <li><i class="bi bi-box-seam me-2"></i>Products: ${data.items} items listed</li>
                        <li><i class="bi bi-check2-circle me-2"></i>Status: ${data.status}</li>
                    `);

                    // Mock Notifications
                    $('#notificationList').html(`
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <strong class="text-success">Application Received</strong>
                                <small class="text-muted">Just now</small>
                            </div>
                            <p class="mb-0 small text-muted">Your application #${data.id} has been queued for review.</p>
                        </div>
                    `);
                }
            },

            renderProgress: function() {
                const data = this.state.appData;
                const container = $('#progressContent');
                
                let html = `
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light p-3 rounded me-3">
                            <h2 class="mb-0 text-success fw-bold">${data.progress}%</h2>
                        </div>
                        <div>
                            <h5 class="mb-1">Compliance Score</h5>
                            <div class="progress" style="width: 200px; height: 8px;">
                                <div class="progress-bar bg-success" style="width: ${data.progress}%"></div>
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-bold border-bottom pb-2 mb-3">Document Status</h6>
                `;
                
                this.state.documents.forEach(doc => {
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>${doc}</span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">Pending Review</span>
                        </div>
                    `;
                });
                
                container.html(html);
            },

            updateUI: function() {
                // Mobile toggle
                window.toggleSidebar = function() {
                    $('#sidebar').toggleClass('show');
                }
            },
            
            setupListeners: function() {
                // Any specific global listeners
            }
        };

        $(document).ready(function() {
            app.init();
            app.showDashboard(); // Default view
        });
    </script>
</body>
</html>