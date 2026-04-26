<?php
include('connection.php');
session_start();

if (isset($_POST['btnLogin'])) {
    # code...
    $name = $_POST['txtUserName'];
    $Password = $_POST['txtUserPassword'];

    $Login_query= "Select * FROM admintbl WHERE aName='$name' AND aPassword='$Password'";
    $Login_Result = mysqli_query($conn,$Login_query);
    $count= mysqli_num_rows($Login_Result);

    if ($count>0) {
        # code...

        $arr = mysqli_fetch_array($Login_Result);
        $name = $arr['aName'];
        $email = $arr['aEmail'];
        $id = $arr['aid'];
			
        $_SESSION['userName'] =$name;
        $_SESSION['userEmail']= $email;
        $_SESSION['id'] = $id;

        echo "<script> window.alert('login success!')</script>";
    }
    else{
        echo"<script> window.alert('Invalid password')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Fusion</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- Sign Up Popup -->
    <div id="signupPopup" class="signup-popup-overlay">
        <div class="signup-popup">
            <span class="signup-popup-close" onclick="closeSignupPopup()">&times;</span>
            <h2 class="signup-popup-title">Join FoodFusion Today!</h2>
            <p class="signup-popup-subtitle">Create an account to save recipes, share your creations, and join our community of food lovers.</p>
            
            <div class="signup-popup-buttons">
                <a href="register.php" class="signup-popup-btn signup-popup-primary">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
                <button onclick="closeSignupPopup()" class="signup-popup-btn signup-popup-secondary">
                    Maybe Later
                </button>
            </div>
        </div>
    </div>

    <!-- Cookie Consent Popup -->
    <div id="cookie-popup" class="cookie-popup">
        <p>🍪 We use cookies to improve your experience. By using our site, you agree to our cookie policy.</p>
        <button onclick="acceptCookies()">Accept</button>
    </div>
    
    <script>
        window.onload = function() {
            // Only show if user hasn't seen it recently
            if (!sessionStorage.getItem('signupPopupShown')) {
                setTimeout(() => {
                    document.getElementById('signupPopup').style.display = 'flex';
                    sessionStorage.setItem('signupPopupShown', 'true');
                }, 2000); // Show after 2 seconds
            }

            // Existing cookie popup code
            if (!sessionStorage.getItem('cookiesAccepted')) {
                document.getElementById('cookie-popup').style.display = 'flex';
            }
        }
 
        function acceptCookies() {
            sessionStorage.setItem('cookiesAccepted', 'true');
            document.getElementById('cookie-popup').style.display = 'none';
        }

        function closeSignupPopup() {
            document.getElementById('signupPopup').style.display = 'none';
        }
    </script>


    <?php include('userNavbar.php'); ?>

    <!-- Hero Section -->
    <section class="ff-hero">
        <div class="ff-hero-content">
            <h1>Discover the Joy of Home Cooking</h1>
            <p>Join our community of food enthusiasts sharing recipes and culinary inspiration</p>
            <div class="ff-hero-buttons">
                <a href="./register.php" class="ff-primary-btn">Join Us</a>
                <a href="./recipes.php" class="ff-secondary-btn">Explore Recipes</a>
            </div>
        </div>
    </section>

    <!-- Add this section to your index.php file -->
    <section class="ff-events-section">

        <?php include('googleTran.php'); ?>
        
        <div class="ff-events-header">
            <h2 class="ff-events-title">Upcoming Cooking Events</h2>
            <p class="ff-events-subtitle">Join our live cooking classes and workshops</p>
        </div>
    
        <div class="ff-events-grid">
            <!-- Event 1 -->
            <div class="ff-event-card ff-event-featured">
                <span class="ff-event-featured-badge">Featured</span>
                <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Italian Pasta Masterclass" class="ff-event-image">
                <div class="ff-event-content">
                    <span class="ff-event-date">
                        <i class="far fa-calendar-alt"></i> Sept 15, 2025
                    </span>
                    <h3 class="ff-event-title">Italian Pasta Masterclass</h3>
                    <p class="ff-event-desc">Learn to make authentic pasta from scratch with Chef Mario. Includes 3 sauce techniques.</p>
                    <div class="ff-event-meta">
                        <span><i class="fas fa-map-marker-alt"></i> Main Kitchen</span>
                        <span><i class="fas fa-users"></i> 12/20 spots left</span>
                    </div>
                    <a href="#" class="ff-event-btn">Register Now</a>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="ff-event-card">
                <img src="https://images.unsplash.com/photo-1547592180-85f173990554?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Vegan Baking Workshop" class="ff-event-image">
                <div class="ff-event-content">
                    <span class="ff-event-date">
                        <i class="far fa-calendar-alt"></i> Nov 22, 2025
                    </span>
                    <h3 class="ff-event-title">Vegan Baking Workshop</h3>
                    <p class="ff-event-desc">Discover plant-based alternatives for your favorite desserts with Chef Emily.</p>
                    <div class="ff-event-meta">
                        <span><i class="fas fa-map-marker-alt"></i> Baking Studio</span>
                        <span><i class="fas fa-users"></i> 5/15 spots left</span>
                    </div>
                    <a href="#" class="ff-event-btn">Register Now</a>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="ff-event-card">
                <img src="https://images.unsplash.com/photo-1518779578993-ec3579fee39f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Knife Skills Intensive" class="ff-event-image">
                <div class="ff-event-content">
                    <span class="ff-event-date">
                        <i class="far fa-calendar-alt"></i> Dec 29, 2025
                    </span>
                    <h3 class="ff-event-title">Knife Skills Intensive</h3>
                    <p class="ff-event-desc">Master professional knife techniques for faster, safer food preparation.</p>
                    <div class="ff-event-meta">
                        <span><i class="fas fa-map-marker-alt"></i> Demonstration Room</span>
                        <span><i class="fas fa-users"></i> 8/18 spots left</span>
                    </div>
                    <a href="#" class="ff-event-btn">Register Now</a>
                </div>
            </div>
        </div>
    
        <!-- <div style="text-align: center; margin-top: 30px;">
            <a href="#" class="ff-view-all">View All Events <i class="fas fa-arrow-right"></i></a>
        </div> -->
    </section>

    <!-- Features Section -->
    <section class="ff-features">
        <div class="ff-section-header">
            <h2>What We Offer</h2>
            <p>Everything you need for your culinary journey</p>
        </div>
        <div class="ff-features-grid">
            <div class="ff-feature-card">
                <i class="fas fa-book"></i>
                <h3>Recipe Collection</h3>
                <p>Thousands of recipes from around the world</p>
            </div>
            <div class="ff-feature-card">
                <i class="fas fa-users"></i>
                <h3>Community</h3>
                <p>Connect with fellow food lovers</p>
            </div>
            <div class="ff-feature-card">
                <i class="fas fa-video"></i>
                <h3>Cooking Tutorials</h3>
                <p>Step-by-step video guides</p>
            </div>
        </div>
    </section>

    <!-- Popular Recipes -->
    <section class="ff-popular-recipes">
        <div class="ff-section-header">
            <h2>Popular Recipes</h2>
            <p>Try these crowd favorites</p>
        </div>
        <div class="ff-recipes-grid">
            <div class="ff-recipe-card">
                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Pasta Dish">
                <div class="ff-recipe-info">
                    <h3>Creamy Garlic Pasta</h3>
                    <div class="ff-recipe-meta">
                        <span><i class="fas fa-clock"></i> 25 mins</span>
                        <span><i class="fas fa-utensils"></i> Italian</span>
                    </div>
                </div>
            </div>
            <div class="ff-recipe-card">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Salad">
                <div class="ff-recipe-info">
                    <h3>Fresh Veggie Salad</h3>
                    <div class="ff-recipe-meta">
                        <span><i class="fas fa-clock"></i> 15 mins</span>
                        <span><i class="fas fa-utensils"></i> Vegetarian</span>
                    </div>
                </div>
            </div>
            <div class="ff-recipe-card">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Main Course">
                <div class="ff-recipe-info">
                    <h3>Beef Stir Fry</h3>
                    <div class="ff-recipe-meta">
                        <span><i class="fas fa-clock"></i> 30 mins</span>
                        <span><i class="fas fa-utensils"></i> Asian</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="ff-about-cta">
        <div class="ff-cta-container">
            <h2 class="ff-cta-title">Ready to join our culinary community?</h2>
            <div class="ff-cta-buttons">
                <a href="register.php" class="ff-cta-btn ff-primary">
                    <i class="fas fa-user-plus"></i>
                    Sign Up Now
                </a>
                <a href="recipes.php" class="ff-cta-btn ff-secondary">
                    <i class="fas fa-book-open"></i>
                    Explore Recipes
                </a>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // FoodFusion Community Access System
        function ffShowPopup() {
            document.getElementById('ffx-membership-gateway-overlay').classList.add('ffx-active');
            document.body.style.overflow = 'hidden';
        }
        
        function ffClosePopup() {
            document.getElementById('ffx-membership-gateway-overlay').classList.remove('ffx-active');
            document.body.style.overflow = '';
            ffHideRegistrationForm();
        }
        
        function ffShowRegistrationForm() {
            document.getElementById('ffxRegistrationPanel').style.display = 'block';
            document.getElementById('ffxRegistrationPanel').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        
        function ffHideRegistrationForm() {
            document.getElementById('ffxRegistrationPanel').style.display = 'none';
        }
        
        // Close when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('ffx-membership-gateway-overlay');
            if (event.target === popup) {
                ffClosePopup();
            }
        });
        
        // Mobile menu toggle
        document.querySelector('.ff-menu-toggle')?.addEventListener('click', function() {
            document.querySelector('.ff-navbar').classList.toggle('active');
        });
        
        // Auto-hide message after 3 seconds
        setTimeout(() => {
            const message = document.querySelector('.ff-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 3000);
    </script>

</body>
</html>
