<?php
include('connection.php');
$pageTitle = "Privacy Policy - FoodFusion";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include('userNavbar.php'); ?>
    
    <div class="privacy_policy-container">
        <header class="privacy_policy-header">
            <h1 class="privacy_policy-title">Privacy Policy</h1>
            <p class="privacy_policy-subtitle">How we protect and use your information at FoodFusion</p>
        </header>
        
        <div class="privacy_policy-card">
            <div class="privacy_policy-section">
                <h2 class="privacy_policy-section-title">Information We Collect</h2>
                <p>We collect information to provide better services to our users:</p>
                <ul class="privacy_policy-list">
                    <li><span class="privacy_policy-highlight">Account Information:</span> When you register, we collect your name, email address, and profile information.</li>
                    <li><span class="privacy_policy-highlight">Recipe Data:</span> Recipes you create, including ingredients, instructions, and photos.</li>
                    <li><span class="privacy_policy-highlight">Usage Data:</span> How you interact with our website, including pages visited and features used.</li>
                    <li><span class="privacy_policy-highlight">Device Information:</span> We may collect device-specific information (such as browser type and IP address).</li>
                </ul>
            </div>
            
            <!-- Additional sections continue with the same pattern -->
            
            <div class="privacy_policy-section">
                <h2 class="privacy_policy-section-title">Contact Us</h2>
                <p>If you have questions about this privacy policy, please contact us at:</p>
                <p><a href="mailto:privacy@foodfusion.com" class="privacy_policy-contact-link">privacy@foodfusion.com</a></p>
            </div>
            
            <p class="privacy_policy-update-date">Last Updated: <?php echo date("F j, Y"); ?></p>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>