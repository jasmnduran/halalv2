<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Owner Login - Halal Keeps</title>
  
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
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
        background: white;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        border-top: 5px solid var(--primary-green);
        width: 100%;
        max-width: 450px;
    }
    
    .btn-login {
        background: var(--primary-green);
        border: none;
        color: white;
        padding: 12px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(13, 140, 76, 0.2);
    }
    .btn-login:hover {
        background: #0a6d3a;
        color: white;
        transform: translateY(-2px);
    }

    .form-floating:focus-within {
        border-color: var(--primary-green);
    }
    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(13, 140, 76, 0.15);
    }
  </style>
</head>
<body class="p-4">

  <div class="login-card p-4 p-md-5">
    
    <div class="text-center mb-4">
        <img src="logo.jpg" alt="Logo" class="rounded-circle border border-3 border-success mb-3" width="80" height="80">
        <h2 class="fw-bold text-dark">Welcome Back</h2>
        <p class="text-muted">Sign in to manage your business</p>
    </div>

    <form action="actions/login.php" method="post">
        
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <label for="email">Email Address</label>
        </div>
        
        <div class="input-group mb-4">
            <div class="form-floating flex-grow-1">
                <input type="password" class="form-control border-end-0 rounded-0 rounded-start" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()">
                <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
        </div>
        
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-login rounded-3">Sign In</button>
        </div>

        <div class="text-center">
            <a href="#" class="text-decoration-none text-muted small mb-3 d-block">Forgot Password?</a>
            <hr class="opacity-10 my-3">
            <p class="small text-muted mb-0">
                Don't have an account? 
                <a href="registertype.php" class="text-success fw-bold text-decoration-none">Register</a>
            </p>
        </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
      }
    }
  </script>
</body>
</html>