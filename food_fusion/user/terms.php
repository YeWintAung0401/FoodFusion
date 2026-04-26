<?php
include('connection.php');
$pageTitle = "Terms of Service - FoodFusion";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- Cookie Consent Popup -->
    <div id="cookie-popup" class="terms_cookie-popup">
        <p>🍪 We use cookies to improve your experience. By using our site, you agree to our cookie policy.</p>
        <button onclick="acceptCookies()" class="terms_cookie-btn">Accept</button>
    </div>
    
    <script>
        window.onload = function() {
            if (!sessionStorage.getItem('cookiesAccepted')) {
                document.getElementById('cookie-popup').style.display = 'flex';
            }
        }
 
        function acceptCookies() {
            sessionStorage.setItem('cookiesAccepted', 'true');
            document.getElementById('cookie-popup').style.display = 'none';
        }
    </script>

    <?php include('userNavbar.php'); ?>
    
    <div class="terms_container">
        <header class="terms_header">
            <h1 class="terms_title">Terms of Service</h1>
            <p class="terms_subtitle">The rules and guidelines for using FoodFusion</p>
        </header>
        
        <div class="terms_card">
            <div class="terms_section">
                <h2 class="terms_section-title">1. Acceptance of Terms</h2>
                <p class="terms_text">By accessing or using FoodFusion, you agree to be bound by these Terms of Service.</p>
            </div>
            
            <div class="terms_section">
                <h2 class="terms_section-title">2. User Responsibilities</h2>
                <p class="terms_text">You agree to use FoodFusion responsibly and lawfully:</p>
                <ul class="terms_list">
                    <li class="terms_list-item">You must be at least 13 years old to use our services</li>
                    <li class="terms_list-item">You are responsible for maintaining the confidentiality of your account</li>
                    <li class="terms_list-item">You agree not to post harmful or illegal content</li>
                </ul>
            </div>
            
            <div class="terms_section">
                <h2 class="terms_section-title">3. Content Ownership</h2>
                <p class="terms_text">You retain ownership of any content you submit, but grant FoodFusion a license to use it.</p>
            </div>
            
            <div class="terms_section">
                <h2 class="terms_section-title">4. Termination</h2>
                <p class="terms_text">We may terminate or suspend access to our services immediately for violations of these terms.</p>
            </div>
            
            <div class="terms_section">
                <h2 class="terms_section-title">5. Changes to Terms</h2>
                <p class="terms_text">We reserve the right to modify these terms at any time. Continued use constitutes acceptance.</p>
            </div>
            
            <div class="terms_section">
                <h2 class="terms_section-title">6. Contact Us</h2>
                <p class="terms_text">Questions about these terms may be sent to:</p>
                <p class="terms_contact-info"><a href="mailto:legal@foodfusion.com" class="terms_contact-link">legal@foodfusion.com</a></p>
            </div>
            
            <p class="terms_update-date">Last Updated: <?php echo date("F j, Y"); ?></p>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>