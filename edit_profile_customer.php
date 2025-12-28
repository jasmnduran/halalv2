<?php 
session_start(); 
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - Halal Keeps</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-green: #0d8c4c;
      --bs-body-bg: #f5fcf7;
      --bs-font-sans-serif: 'Inter', sans-serif;
    }
    body { background-color: var(--bs-body-bg); }
    
    .profile-container { max-width: 700px; margin: 0 auto; }
    
    .main-card {
        background: white;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border-top: 5px solid var(--primary-green);
    }
    .section-title {
        color: var(--primary-green);
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .btn-save {
        background: var(--primary-green);
        border: none;
        padding: 12px;
        font-weight: 600;
    }
    .btn-save:hover { background: #0a6d3a; color: white; }
  </style>
</head>
<body class="py-4">
  <div class="container profile-container">
    
    <div class="text-center mb-4">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border border-3 border-success mb-3" width="80" height="80">
        <h2 class="fw-bold text-dark">Edit Customer Profile</h2>
    </div>

    <form action="actions/edit_profile.php" method="post">
      <div class="card main-card p-4 p-md-5">
        
        <div class="mb-4">
            <h5 class="section-title"><i class="bi bi-person-badge me-2"></i>Personal Details</h5>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-bold text-muted">First Name</label>
                    <input type="text" name="first_name" class="form-control" required value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">M.I.</label>
                    <input type="text" name="middle_initial" class="form-control" maxlength="1" value="<?= htmlspecialchars($user['middle_initial'] ?? '') ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label small fw-bold text-muted">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Age</label>
                    <input type="number" name="age" class="form-control" min="13" required value="<?= htmlspecialchars($user['age'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender...</option>
                        <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="section-title"><i class="bi bi-geo-alt me-2"></i>Address</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Barangay</label>
                    <input type="text" name="barangay" class="form-control" required value="<?= htmlspecialchars($user['barangay'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">City</label>
                    <input type="text" name="city" class="form-control" required value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Province</label>
                    <input type="text" name="province" class="form-control" required value="<?= htmlspecialchars($user['province'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h5 class="section-title"><i class="bi bi-envelope me-2"></i>Contact</h5>
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Email Address</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            </div>
        </div>

        <div class="d-grid gap-3">
            <button type="submit" class="btn btn-save text-white rounded-3">Save Changes</button>
            <a href="customer_dashboard.php" class="btn btn-outline-secondary rounded-3">Cancel</a>
        </div>

      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>