<footer class="ff-footer">
    <div class="ff-footer-container">
        <!-- Main Footer Content -->
        <div class="ff-footer-grid">
            <!-- Brand Column -->
            <div class="ff-footer-brand">
                <a href="index.html" class="ff-footer-logo">
                    <i class="fas fa-utensils ff-footer-logo-icon"></i>
                    <span class="ff-footer-logo-text">Food Fusion</span>
                </a>
                <p class="ff-footer-tagline">
                    Bringing culinary creativity to your kitchen since 2018.
                </p>
                <div class="ff-footer-social">
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

            <!-- Quick Links -->
            <div class="ff-footer-links">
                <h3 class="ff-footer-heading">Quick Links</h3>
                <ul class="ff-footer-link-list">
                    <li><a href="index.php" class="ff-footer-link">Home</a></li>
                    <li><a href="aboutUs.php" class="ff-footer-link">About Us</a></li>
                    <li><a href="recipes.php" class="ff-footer-link">Recipe Collection</a></li>
                    <li><a href="community.html" class="ff-footer-link">Community Cookbook</a></li>
                    <li><a href="contactus.php" class="ff-footer-link">Contact Us</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="ff-footer-newsletter">
                <h3 class="ff-footer-heading">Stay Updated</h3>
                <p class="ff-footer-newsletter-text">
                    Subscribe to our newsletter for weekly recipes and cooking tips.
                </p>
                <div class="ff-footer-app-links">
                    <p>Download our app:</p>
                    <div class="ff-app-buttons">
                        <a href="https://apps.apple.com/pk/app/food-fusion/id1361924810" class="ff-app-btn">
                            <i class="fab fa-apple"></i>
                            <span>App Store</span>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.foodfusion.foodfusion&hl=en" class="ff-app-btn">
                            <i class="fab fa-google-play"></i>
                            <span>Google Play</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="ff-footer-bottom">
            <div class="ff-footer-legal">
                <a href="privacy_policy.php" class="ff-legal-link">Privacy Policy</a>
                <a href="terms.php" class="ff-legal-link">Terms of Service</a>
                <a href="cookie.php" class="ff-legal-link">Cookie Policy</a>
            </div>
            <div class="ff-footer-copyright">
                &copy; <?php echo date('Y'); ?> Food Fusion. All rights reserved.
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="ff-back-to-top" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    // Back to Top Button functionality
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.querySelector('.ff-back-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>