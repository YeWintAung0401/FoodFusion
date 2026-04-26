<?php
// session_start();

// Check if user is logged in by verifying session variables
$isLoggedIn = isset($_SESSION['userName']) && isset($_SESSION['userEmail']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
    $isLoggedIn = isset($_SESSION['user']) && is_array($_SESSION['user']);
    ?>

    <!-- Navbar -->
    <header class="ff-header">
        <input type="checkbox" id="ff-menu-toggle" class="ff-menu-checkbox">
        <label for="ff-menu-toggle" class="ff-menu-btn">
            <i class="fas fa-bars ff-menu-icon"></i>
        </label>
        <a href="index.php" class="ff-logo"> 
            <i class="fas fa-utensils ff-logo-icon"></i>
            <span class="ff-logo-text">Food Fusion</span>
        </a>
        <nav class="ff-navbar">
            <ul class="ff-nav-list">
                <li class="ff-nav-item">
                    <a href="index.php" class="ff-nav-link">
                        <i class="fas fa-home ff-nav-icon"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="ff-nav-item">
                    <a href="recipes.php" class="ff-nav-link">
                        <i class="fas fa-book ff-nav-icon"></i>
                        <span>Recipes</span>
                    </a>
                </li>
                <li class="ff-nav-item ff-has-dropdown">
                    <a href="#" class="ff-nav-link">
                        <i class="fas fa-folder ff-nav-icon"></i>
                        <span>Resources</span>
                        <i class="fas fa-caret-down ff-dropdown-icon"></i>
                    </a>
                    <ul class="ff-dropdown-menu">
                        <li class="ff-dropdown-item">
                            <a href="./cookbook.php" class="ff-dropdown-link">
                                <i class="fas fa-users ff-dropdown-icon"></i>
                                <span>Community Cookbook</span>
                            </a>
                        </li>
                        <li class="ff-dropdown-item">
                            <a href="./culinaryResources.php" class="ff-dropdown-link">
                                <i class="fas fa-video ff-dropdown-icon"></i>
                                <span>Culinary Resources</span>
                            </a>
                        </li>
                        <li class="ff-dropdown-item">
                            <a href="./eduresources.php" class="ff-dropdown-link">
                                <i class="fas fa-graduation-cap ff-dropdown-icon"></i>
                                <span>Educational Resources</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="ff-nav-item">
                    <a href="contactus.php" class="ff-nav-link">
                        <i class="fas fa-envelope ff-nav-icon"></i>
                        <span>Contact Us</span>
                    </a>
                </li>
                <li class="ff-nav-item">
                    <a href="aboutUs.php" class="ff-nav-link">
                        <i class="fas fa-info-circle ff-nav-icon"></i>
                        <span>About Us</span>
                    </a>
                </li>
            </ul>
        </nav>

        <?php 
            include('login_out.php');
        ?>

    </header>
</body>
</html>