<?php
// index.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

// Redirect to dashboard if already logged in
if (is_logged_in()) {
    header("Location: /pages/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLeClear MIS - Sign In</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Style -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-brand">
                <div class="login-logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h2>SLeClear MIS</h2>
                <p>Sierra Leone Student Clearance & Financial Management Information System</p>
            </div>
            
            <div class="login-card">
                <h3>Welcome Back</h3>
                <p class="card-subtitle">Sign in to manage clearances, payments, and reporting</p>
                
                <?php echo display_flash_messages(); ?>
                
                <form action="/api/login.php" method="POST" class="login-form">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <div class="form-group">
                        <label for="username"><i class="fa-solid fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required autocomplete="username">
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <span>Sign In</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Quick Demo Login Panel for testing -->
            <div class="demo-login-panel">
                <h4>Quick Demo Logins (Click to Fill)</h4>
                <div class="demo-buttons">
                    <button type="button" class="btn-demo" onclick="fillCredentials('admin', 'admin123')">
                        <i class="fa-solid fa-user-shield"></i> Admin
                    </button>
                    <button type="button" class="btn-demo" onclick="fillCredentials('finance', 'finance123')">
                        <i class="fa-solid fa-coins"></i> Finance
                    </button>
                    <button type="button" class="btn-demo" onclick="fillCredentials('registry', 'registry123')">
                        <i class="fa-solid fa-file-contract"></i> Registry
                    </button>
                </div>
            </div>
            
            <div class="login-footer">
                <p>&copy; <?php echo date('Y'); ?> SLeClear MIS. Supporting SDGs 4 & 10.</p>
            </div>
        </div>
    </div>

    <script>
        function fillCredentials(user, pass) {
            document.getElementById('username').value = user;
            document.getElementById('password').value = pass;
            
            // Add visual focus and flash effect to the button
            const btn = document.querySelector('.btn-primary');
            btn.classList.add('flash-effect');
            setTimeout(() => btn.classList.remove('flash-effect'), 500);
        }
    </script>
</body>
</html>
