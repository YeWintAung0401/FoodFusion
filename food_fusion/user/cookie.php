<?php
include('connection.php');
session_start();
$pageTitle = "Cookie Policy - FoodFusion";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/cookies_policy.css">
</head>
<body>
    <!-- Cookie Consent Popup (with cookies_ prefix) -->
    <div id="cookie-popup" class="cookies_popup">
        <p>🍪 We use cookies to improve your experience. By using our site, you agree to our Cookie Policy.</p>
        <button onclick="acceptCookies()" class="cookies_accept-btn">Accept</button>
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
    
    <div class="cookies_container">
        <header class="cookies_header">
            <h1 class="cookies_title">Cookie Policy</h1>
            <p class="cookies_subtitle">How we use cookies on FoodFusion</p>
        </header>
        
        <div class="cookies_card">
            <div class="cookies_section">
                <h2 class="cookies_section-title">1. What Are Cookies</h2>
                <p class="cookies_text">Cookies are small text files stored on your device when you visit websites. They help sites remember information about your visit.</p>
            </div>
            
            <div class="cookies_section">
                <h2 class="cookies_section-title">2. How We Use Cookies</h2>
                <p class="cookies_text">We use cookies for essential functions and to improve your experience:</p>
                <ul class="cookies_list">
                    <li class="cookies_list-item"><span class="cookies_highlight">Essential Cookies:</span> Necessary for basic site functionality</li>
                    <li class="cookies_list-item"><span class="cookies_highlight">Preference Cookies:</span> Remember your settings and preferences</li>
                    <li class="cookies_list-item"><span class="cookies_highlight">Analytics Cookies:</span> Help us understand how visitors use our site</li>
                    <li class="cookies_list-item"><span class="cookies_highlight">Marketing Cookies:</span> Used to deliver relevant advertisements</li>
                </ul>
            </div>
            
            <div class="cookies_section">
                <h2 class="cookies_section-title">3. Managing Cookies</h2>
                <p class="cookies_text">You can control cookies through your browser settings:</p>
                <ul class="cookies_list">
                    <li class="cookies_list-item">Most browsers allow you to refuse or delete cookies</li>
                    <li class="cookies_list-item">Blocking essential cookies may affect site functionality</li>
                    <li class="cookies_list-item">You can withdraw consent at any time</li>
                </ul>
            </div>
            
            <div class="cookies_section">
                <h2 class="cookies_section-title">4. Third-Party Cookies</h2>
                <p class="cookies_text">Some cookies are placed by third-party services we use, such as analytics providers.</p>
            </div>
            
            <div class="cookies_section">
                <h2 class="cookies_section-title">5. Changes to This Policy</h2>
                <p class="cookies_text">We may update this Cookie Policy as our practices change.</p>
            </div>
            
            <div class="cookies_section">
                <h2 class="cookies_section-title">6. Contact Us</h2>
                <p class="cookies_text">For questions about our Cookie Policy:</p>
                <p class="cookies_contact-info"><a href="mailto:privacy@foodfusion.com" class="cookies_contact-link">privacy@foodfusion.com</a></p>
            </div>
            
            <p class="cookies_update-date">Last Updated: <?php echo date("F j, Y"); ?></p>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>