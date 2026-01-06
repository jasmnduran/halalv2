<?php
session_start();
// Ensure certifier is logged in
if (!isset($_SESSION["certifier_id"])) {
    // Redirect to login if session missing (Uncomment in production)
    // header("Location: login_certifier.html");
    // exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HDIP - Halal Certification System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #0d8c4c;
            --bs-body-bg: #f5f7fa;
            --bs-font-sans-serif: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bs-body-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Branding */
        .bg-brand { background: linear-gradient(135deg, var(--primary-green), #0a6d3a); }
        .text-brand { color: var(--primary-green) !important; }
        
        /* Stats Cards */
        .stat-card {
            border: none;
            border-left: 5px solid var(--primary-green);
            transition: transform 0.2s;
            background: white;
        }
        .stat-card:hover { transform: translateY(-3px); }
        
        .status-badge { font-size: 0.85em; padding: 0.4em 0.8em; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-brand shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="bi bi-shield-check fs-4"></i> HDIP Certification
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white-50 small me-3 d-none d-md-inline">Welcome, Certifier</span>
                <a href="logout.php" class="btn btn-sm btn-outline-light rounded-pill px-3">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4 flex-grow-1">

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm stat-card h-100">
                    <div class="card-body text-center p-3">
                        <h2 class="display-5 fw-bold text-brand mb-0" id="stat-total">-</h2>
                        <small class="text-muted text-uppercase fw-bold">Total Apps</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm stat-card h-100" style="border-left-color: #ffc107;">
                    <div class="card-body text-center p-3">
                        <h2 class="display-5 fw-bold text-warning mb-0" id="stat-pending">-</h2>
                        <small class="text-muted text-uppercase fw-bold">Pending</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm stat-card h-100" style="border-left-color: #198754;">
                    <div class="card-body text-center p-3">
                        <h2 class="display-5 fw-bold text-success mb-0" id="stat-approved">-</h2>
                        <small class="text-muted text-uppercase fw-bold">Approved</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm stat-card h-100" style="border-left-color: #dc3545;">
                    <div class="card-body text-center p-3">
                        <h2 class="display-5 fw-bold text-danger mb-0" id="stat-rejected">-</h2>
                        <small class="text-muted text-uppercase fw-bold">Rejected</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-brand me-2"></i>Recent Applications</h5>
                <button class="btn btn-sm btn-outline-secondary" onclick="loadApplications()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">App ID</th>
                                <th>Company Name</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="applications-body">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <div class="spinner-border spinner-border-sm text-brand me-2" role="status"></div>
                                    Loading data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadStats();
            loadApplications();
        });

        async function loadStats() {
            try {
                // Fetch from the uploaded PHP action
                const response = await fetch('actions/fetch_stats.php');
                const data = await response.json();

                // Update DOM elements (safely handling potential nulls)
                document.getElementById('stat-total').textContent = data.total ?? 0;
                document.getElementById('stat-pending').textContent = data.pending ?? 0;
                document.getElementById('stat-approved').textContent = data.approved ?? 0;
                document.getElementById('stat-rejected').textContent = data.rejected ?? 0;
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        async function loadApplications() {
            const tbody = document.getElementById('applications-body');
            
            try {
                const response = await fetch('actions/fetch_applications.php');
                const applications = await response.json();

                if (applications.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No applications found.</td></tr>';
                    return;
                }

                tbody.innerHTML = applications.map(app => {
                    // Status Badge Logic
                    let badgeClass = 'bg-secondary';
                    if (app.status === 'Approved') badgeClass = 'bg-success bg-opacity-10 text-success border border-success';
                    if (app.status === 'Pending') badgeClass = 'bg-warning bg-opacity-10 text-dark border border-warning';
                    if (app.status === 'Rejected') badgeClass = 'bg-danger bg-opacity-10 text-danger border border-danger';

                    return `
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#${app.application_id}</td>
                            <td class="fw-medium">${app.company_name}</td>
                            <td class="text-muted small">${new Date(app.submission_date).toLocaleDateString()}</td>
                            <td><span class="badge rounded-pill ${badgeClass} status-badge">${app.status}</span></td>
                            <td class="pe-4 text-end">
                                <a href="inspection_review.php?id=${app.application_id}" class="btn btn-sm btn-brand rounded-pill px-3">
                                    Review
                                </a>
                            </td>
                        </tr>
                    `;
                }).join('');

            } catch (error) {
                console.error('Error loading apps:', error);
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-danger"><i class="bi bi-exclamation-circle me-1"></i> Failed to load data.</td></tr>`;
                
                // Fallback Mock Data for Demonstration if PHP fails
                fallbackRender();
            }
        }

        function fallbackRender() {
            // Only runs if fetch fails (e.g., when viewing HTML file directly without server)
            const mockApps = [
                { application_id: 101, company_name: "Mock Food Corp", submission_date: "2024-03-10", status: "Pending" },
                { application_id: 102, company_name: "Halal Express", submission_date: "2024-03-09", status: "Approved" }
            ];
            const tbody = document.getElementById('applications-body');
            tbody.innerHTML = mockApps.map(app => `
                <tr>
                    <td class="ps-4 fw-bold text-secondary">#${app.application_id}</td>
                    <td class="fw-medium">${app.company_name}</td>
                    <td class="text-muted small">${app.submission_date}</td>
                    <td><span class="badge rounded-pill bg-light text-dark border">${app.status}</span></td>
                    <td class="pe-4 text-end"><button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>Demo Mode</button></td>
                </tr>
            `).join('');
        }

/**
 * Modern Applicant Form Logic
 * Handles dynamic form fields and client-side validation
 */

document.addEventListener('DOMContentLoaded', () => {
    initDynamicForms();
});

function initDynamicForms() {
    // 1. Manufacturing Plant Logic
    const manufacturingRadios = document.querySelectorAll('input[name="manufacturing"]');
    const localFieldsContainer = document.getElementById('localFields'); // Container in Step 2

    if (manufacturingRadios.length > 0 && localFieldsContainer) {
        manufacturingRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                const isLocal = e.target.value === 'local' || e.target.value === 'both';
                
                if (isLocal) {
                    localFieldsContainer.classList.remove('d-none');
                    // Focus on number input if showing
                    setTimeout(() => document.getElementById('numPlants')?.focus(), 100);
                } else {
                    localFieldsContainer.classList.add('d-none');
                }
            });
        });

        // Dynamic Plant Address Inputs
        const numPlantsInput = document.getElementById('numPlants');
        const addressContainer = document.getElementById('plantAddresses');

        if (numPlantsInput && addressContainer) {
            numPlantsInput.addEventListener('input', (e) => {
                const count = parseInt(e.target.value) || 0;
                const currentCount = addressContainer.children.length;

                // Limit to reasonable number to prevent browser hang
                if (count > 20) return; 

                if (count > currentCount) {
                    // Add fields
                    for (let i = currentCount; i < count; i++) {
                        const div = document.createElement('div');
                        div.className = 'form-floating mb-2 animate-fade-in';
                        div.innerHTML = `
                            <input type="text" class="form-control" name="plant_address_${i}" id="plant_address_${i}" placeholder="Address">
                            <label for="plant_address_${i}">Address for Plant ${i + 1}</label>
                        `;
                        addressContainer.appendChild(div);
                    }
                } else if (count < currentCount) {
                    // Remove fields
                    while (addressContainer.children.length > count) {
                        addressContainer.removeChild(addressContainer.lastChild);
                    }
                }
            });
        }
    }

    // 2. Dynamic Product Items Logic (Replaces text area with dynamic rows)
    const addItemBtn = document.getElementById('addItemBtn');
    const itemsList = document.getElementById('itemList');

    if (addItemBtn && itemsList) {
        // Initial Row
        if (itemsList.children.length === 0) addItemRow(itemsList);

        addItemBtn.addEventListener('click', () => {
            addItemRow(itemsList);
        });
    }
}

function addItemRow(container) {
    const index = container.children.length;
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 align-items-center item-row';
    
    row.innerHTML = `
        <div class="col-7">
            <div class="form-floating">
                <input type="text" class="form-control" name="items[${index}][name]" placeholder="Name" required>
                <label>Product Name</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <select class="form-select" name="items[${index}][type]">
                    <option value="Food">Food</option>
                    <option value="Non-Food">Non-Food</option>
                    <option value="Pharma">Pharma</option>
                </select>
                <label>Type</label>
            </div>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" onclick="this.closest('.item-row').remove()" style="height: 58px;">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(row);
    
    // Auto-focus the new input
    const input = row.querySelector('input');
    if(input) input.focus();
}

// Helper CSS class for animation (add to your <style>)
/* .animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
*/
    </script>
</body>
</html>