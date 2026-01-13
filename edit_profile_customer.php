<?php 
require_once "includes/db.php";
session_start(); 

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login_customer.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch customer data
$stmt = $conn->prepare("SELECT name, middle_initial, gender, email, address, city, province FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Split Name logic
$name_parts = explode(' ', $user['name']);
$last_name = array_pop($name_parts);
$first_name = implode(' ', $name_parts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Customer Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>body { background-color: #f5fcf7; font-family: 'Inter', sans-serif; }</style>
</head>
<body class="py-4">
  <div class="container" style="max-width: 700px;">
    
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Edit Profile</h2>
    </div>

    <form action="actions/edit_profile.php" method="post">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
        
        <h5 class="border-bottom pb-2 mb-3 text-success">Personal Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label small fw-bold">First Name</label>
                <input type="text" name="first_name" class="form-control" required value="<?= htmlspecialchars($first_name) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">M.I.</label>
                <input type="text" name="middle_initial" class="form-control" maxlength="2" value="<?= htmlspecialchars($user['middle_initial'] ?? '') ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold">Last Name</label>
                <input type="text" name="last_name" class="form-control" required value="<?= htmlspecialchars($last_name) ?>">
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="Male" <?= ($user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= ($user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= ($user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
        </div>

        <h5 class="border-bottom pb-2 mb-3 text-success">Location</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Barangay</label>
                <input type="text" name="barangay" class="form-control" required value="<?= htmlspecialchars($user['address']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">City</label>
                <input type="text" name="city" class="form-control" required value="<?= htmlspecialchars($user['city']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Province</label>
                <input type="text" name="province" class="form-control" required value="<?= htmlspecialchars($user['province']) ?>">
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success fw-bold rounded-pill">Update Profile</button>
            <a href="customer_dashboard.php" class="btn btn-light rounded-pill">Cancel</a>
        </div>

      </div>
    </form>
  </div>
</body>
</html>