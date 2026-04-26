<?php if (!$isLoggedIn): ?>
    
    <!-- Login Button (shown when not logged in) -->
    <a href="login.php" class="ff-login-btn"> 
        <i class="fas fa-sign-in-alt ff-login-icon"></i>
        <span>Login</span>
    </a>
<?php else: ?>
    <!-- Logout Button (shown when logged in) -->
    <a href="logout.php" class="ff-login-btn"> 
        <i class="fas fa-sign-out-alt ff-login-icon"></i>
        <span>Logout</span>
    </a>
<?php endif; ?>