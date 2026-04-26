<?php
session_start();

// Clear all session data
$_SESSION = [];
session_unset();
session_destroy();

// Optional: remove any login-related cookies
if (isset($_COOKIE['login_counter'])) {
    setcookie('login_counter', '', time() - 3600, '/');
}

// Redirect to login page (or homepage)
header("Location: login.php");
exit();
?>