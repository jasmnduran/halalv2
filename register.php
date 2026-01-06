<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Registration - Halal Keeps</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 0;
    }
    .register-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-top: 5px solid #0d8c4c;
        width: 100%;
        max-width: 800px; /* Wider for multi-column */
    }
    .btn-register {
        background: #0d8c4c;
        color: white;
        padding: 12px;
        font-weight: 600;
        border: none;
    }
    .btn-register:hover { background: #0a6d3a; color: white; }
    .section-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center">
      <div class="register-card p-4 p-md-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Create Business Account</h2>
            <p class="text-muted">Register as a Business Owner</p>
        </div>

        <form action="actions/register.php" method="post">
            
            <div class="section-label">Personal Information</div>
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                        <label>First Name</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="middle_initial" placeholder="M.I." maxlength="2">
                        <label>M.I.</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                        <label>Last Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="age" placeholder="Age" min="18" required>
                        <label>Age</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <label>Gender</label>
                    </div>
                </div>
            </div>

            <div class="section-label mt-4">Business & Location</div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="business_name" placeholder="Business Name" required>
                <label>Business Name</label>
            </div>
            
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="barangay" placeholder="Barangay" required>
                        <label>Barangay</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="city" placeholder="City" required>
                        <label>City</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="province" placeholder="Province" required>
                        <label>Province</label>
                    </div>
                </div>
            </div>

            <div class="section-label mt-4">Account Security</div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <label>Email Address</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="password" placeholder="Password" required minlength="6">
                <label>Password</label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-register rounded-3">Register Account</button>
            </div>

            <div class="text-center">
                <p class="small text-muted mb-0">
                    Already have an account? <a href="login_owner.php" class="text-success fw-bold text-decoration-none">Sign In</a>
                </p>
            </div>
        </form>
      </div>
  </div>
</body>
</html>