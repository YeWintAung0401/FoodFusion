<?php
include('connection.php');
$pageTitle = "Forgot Password - FoodFusion";
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if email exists
    $query = "SELECT * FROM usertbl WHERE userEmail = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password directly
        $updateQuery = "UPDATE usertbl SET userPassword = '$hashedPassword' WHERE userEmail = '$email'";
        
        if (mysqli_query($conn, $updateQuery)) {
            $message = "<div class='forgetPass_success'>Password updated successfully!</div>";
        } else {
            $message = "<div class='forgetPass_error'>Error updating password. Please try again.</div>";
        }
    } else {
        $message = "<div class='forgetPass_error'>Email not found in our system.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    
    <div class="forgetPass_container">
        <div class="forgetPass_card">
            <h1 class="forgetPass_title">Reset Password</h1>
            <p class="forgetPass_subtitle">Enter your email and new password</p>
            
            <?php echo $message; ?>
            
            <form method="POST" class="forgetPass_form">
                <div class="forgetPass_form-group">
                    <label for="email" class="forgetPass_label">Email Address</label>
                    <input type="email" id="email" name="email" class="forgetPass_input" required>
                    <i class="fas fa-envelope forgetPass_icon"></i>
                </div>
                
                <div class="forgetPass_form-group">
                    <label for="password" class="forgetPass_label">New Password</label>
                    <input type="password" id="password" name="password" class="forgetPass_input" required minlength="8">
                    <i class="fas fa-lock forgetPass_icon"></i>
                </div>
                
                <button type="submit" class="forgetPass_button">Reset Password</button>
            </form>
            
            <div class="forgetPass_footer">
                <a href="login.php" class="forgetPass_link">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
    
</body>
</html>