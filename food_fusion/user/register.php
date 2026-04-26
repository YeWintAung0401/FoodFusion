<?php 
include('connection.php');
session_start();

if (isset($_SESSION['registration_errors']) && is_array($_SESSION['registration_errors'])) {
    echo "<script>";
    foreach ($_SESSION['registration_errors'] as $error) {
        echo "alert('" . addslashes($error) . "');";
    }
    echo "</script>";
    unset($_SESSION['registration_errors']);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodFusion</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        .file-input {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body class="login-body">
    <div class="register-container">
        <div class="register-header">
            <div class="logo">
                <i class="fas fa-utensils"></i>
                <span>FoodFusion</span>
            </div>
            <h1>Join Our Culinary Community</h1>
            <p>Create your account to share and discover recipes</p>
        </div>

        <form class="register-form" id="registrationForm" method="POST" action="register_process.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="userFName">First Name *</label>
                <div class="input-group">
                    <i class="fas fa-signature"></i>
                    <input type="text" id="userFName" name="userFName" placeholder="Your first name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="userLName">Last Name *</label>
                <div class="input-group">
                    <i class="fas fa-signature"></i>
                    <input type="text" id="userLName" name="userLName" placeholder="Your last name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="userEmail">Email *</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="userEmail" name="userEmail" placeholder="Your email address" required>
                </div>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="userPassword">Password *</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="userPassword" name="userPassword" placeholder="Create a password (min 8 characters)" required minlength="8">
                    <i class="fas fa-eye toggle-pw" id="toggle-pw"></i>
                </div>
                <div class="error-message" id="password-error"></div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password *</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required minlength="8">
                    <i class="fas fa-eye toggle-pw" id="toggle-confirm-pw"></i>
                </div>
                <div class="error-message" id="confirm-error"></div>
            </div>

            <div class="form-group">
                <label for="userPhone">Phone Number</label>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="userPhone" name="userPhone" placeholder="Your phone number">
                </div>
            </div>

            <div class="form-group">
                <label for="userAddress">Address</label>
                <div class="input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" id="userAddress" name="userAddress" placeholder="Your full address">
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <div class="input-group file-input">
                    <i class="fas fa-camera"></i>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <div class="error-message" id="photo-error"></div>
            </div>

            <div class="terms">
                <label class="checkbox">
                    <input type="checkbox" name="terms" required>
                    <span>I agree to the <a href="#" id="terms-link">Terms of Service</a>, <a href="#" id="privacy-link">Privacy Policy</a>, and understand the <a href="#" id="cookie-link">Cookie Policy</a></span>
                </label>
                <div class="error-message" id="terms-error"></div>
            </div>

            <button type="submit" class="register-btn" name="register-btn">Register</button>

            <div class="register-footer">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('toggle-pw').addEventListener('click', function() {
            const passwordInput = document.getElementById('userPassword');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Toggle Confirm password visibility
        document.getElementById('toggle-confirm-pw').addEventListener('click', function() {
            const confirmInput = document.getElementById('confirmPassword');
            const icon = this;
            
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                confirmInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            let valid = true;
            
            // Validate email format
            const email = document.getElementById('userEmail').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = 'Please enter a valid email address';
                document.getElementById('email-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('email-error').style.display = 'none';
            }
            
            // Validate password
            const password = document.getElementById('userPassword').value;
            if (password.length < 8) {
                document.getElementById('password-error').textContent = 'Password must be at least 8 characters';
                document.getElementById('password-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('password-error').style.display = 'none';
            }
            
            // Validate password match
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                document.getElementById('confirm-error').textContent = 'Passwords do not match';
                document.getElementById('confirm-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('confirm-error').style.display = 'none';
            }
            
            // Validate terms
            if (!document.querySelector('input[name="terms"]').checked) {
                document.getElementById('terms-error').textContent = 'You must accept the terms and conditions';
                document.getElementById('terms-error').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('terms-error').style.display = 'none';
            }
            
            // Validate file if selected
            const fileInput = document.getElementById('photo');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    document.getElementById('photo-error').textContent = 'Only JPG, PNG, or GIF files are allowed';
                    document.getElementById('photo-error').style.display = 'block';
                    valid = false;
                } else if (file.size > maxSize) {
                    document.getElementById('photo-error').textContent = 'File size must be less than 2MB';
                    document.getElementById('photo-error').style.display = 'block';
                    valid = false;
                } else {
                    document.getElementById('photo-error').style.display = 'none';
                }
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });

        // Cookie consent link
        document.getElementById('cookie-link').addEventListener('click', function(e) {
            e.preventDefault();
            alert('This website uses cookies to enhance user experience. By registering, you consent to our use of cookies.');
        });
    </script>
</body>
</html>