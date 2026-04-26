
<?php 
include ("connection.php"); 
session_start();
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['user']['userFName'] . ' ' . $_SESSION['user']['userLName']) : '';
$userEmail = $isLoggedIn ? htmlspecialchars($_SESSION['user']['userEmail']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Food Fusion</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('userNavbar.php'); ?>

    <main class="ff-contact-container">
        <section class="ff-contact-hero">
            <div class="ff-contact-hero-content">
                <h1 class="ff-contact-title">Get in Touch</h1>
                <p class="ff-contact-subtitle">We'd love to hear from you! Reach out for questions, feedback, or partnership opportunities.</p>
            </div>
        </section>

        <div class="ff-contact-grid">
            <section class="ff-contact-form-section">
                <h2 class="ff-section-title">Send us a message</h2>
                <form class="ff-contact-form" method="POST" action="contactus_process.php" >
                    <div class="ff-form-group">
                        <label for="ff-name" class="ff-form-label">Name</label>
                        <input type="text" id="ff-name" name="ff-name" class="ff-form-input" 
                               placeholder="Enter your name" required>
                    </div>

                    <div class="ff-form-group">
                        <label for="ff-email" class="ff-form-label">Email Address</label>
                        <input type="email" id="ff-email" name="ff-email" class="ff-form-input" 
                               placeholder="Enter your email" required>
                    </div>
                    
                    <div class="ff-form-group">
                        <label for="ff-message" class="ff-form-label">Your Message</label>
                        <textarea id="ff-message" name="ff-message" class="ff-form-textarea" rows="5" placeholder="Type your message here..." required></textarea>
                    </div>
                    
                    <button type="submit" name="submit" class="ff-submit-btn">
                        <i class="fas fa-paper-plane ff-btn-icon"></i>
                        Send Message
                    </button>
                </form>
            </section>

            <section class="ff-contact-info-section">
                <h2 class="ff-section-title">Contact Information</h2>
                <div class="ff-contact-info-card">
                    <div class="ff-contact-method">
                        <div class="ff-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="ff-contact-details">
                            <h3 class="ff-contact-method-title">Our Location</h3>
                            <p class="ff-contact-method-text">221 Sule Pagoda Rd, Yangon</p>
                        </div>
                    </div>
                    
                    <div class="ff-contact-method">
                        <div class="ff-contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="ff-contact-details">
                            <h3 class="ff-contact-method-title">Phone</h3>
                            <p class="ff-contact-method-text">019255009</p>
                            <p class="ff-contact-method-text">Mon-Fri: 9am-5pm</p>
                        </div>
                    </div>
                    
                    <div class="ff-contact-method">
                        <div class="ff-contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ff-contact-details">
                            <h3 class="ff-contact-method-title">Email</h3>
                            <p class="ff-contact-method-text">foodfusionY@gmail.com</p>
                            <p class="ff-contact-method-text">foodfusionAdmin@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="ff-contact-method">
                        <div class="ff-contact-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="ff-contact-details">
                            <h3 class="ff-contact-method-title">Follow Us</h3>
                            <div class="ff-social-links">
                                <a href="https://www.facebook.com/FoodFusionPK/" class="ff-social-link" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.instagram.com/foodfusionpk/?hl=en" class="ff-social-link" target="_blank" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://www.pinterest.com/foodfusionpk/" class="ff-social-link" target="_blank" aria-label="Pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="https://www.youtube.com/channel/UCuqBZWK9Wrol_4Y22DzisFQ" class="ff-social-link" target="_blank" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="ff-contact-map-section">
            <h2 class="ff-section-title">Find Us on Map</h2>
            <div class="ff-map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1436.5125601407858!2d96.15788276235122!3d16.776950555339734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1ec86c64627b3%3A0xf629281949864a5c!2sSule%20Square!5e1!3m2!1sen!2smm!4v1751878478926!5m2!1sen!2smm" 
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade" class="ff-map-iframe"></iframe>
            </div>
        </section>
    </main>

    <!-- Footer would go here -->
    <?php include 'footer.php'; ?>
</body>
</html>