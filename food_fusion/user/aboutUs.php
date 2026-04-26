<?php  
include('connection.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Food Fusion</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('userNavbar.php'); ?>

    <main class="ff-about-container">
        <!-- Hero Section -->
        <section class="ff-about-hero">
            <div class="ff-about-hero-content">
                <h1 class="ff-about-hero-title">Our Culinary Journey</h1>
                <p class="ff-about-hero-subtitle">Bringing food lovers together since 2018</p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="ff-about-mission">
            <div class="ff-about-mission-content">
                <h2 class="ff-section-title">Our Mission</h2>
                <p class="ff-about-mission-text">
                    At Food Fusion, we believe everyone deserves to experience the joy of cooking. 
                    Our mission is to break down culinary barriers and create a global community 
                    where food enthusiasts can share, learn, and grow together.
                </p>
                <div class="ff-about-stats">
                    <div class="ff-about-stat">
                        <span class="ff-stat-number">10K+</span>
                        <span class="ff-stat-label">Recipes Shared</span>
                    </div>
                    <div class="ff-about-stat">
                        <span class="ff-stat-number">500K+</span>
                        <span class="ff-stat-label">Community Members</span>
                    </div>
                    <div class="ff-about-stat">
                        <span class="ff-stat-number">50+</span>
                        <span class="ff-stat-label">Countries Represented</span>
                    </div>
                </div>
            </div>
            <div class="ff-about-mission-image">
                <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Cooking ingredients">
            </div>
        </section>

        <!-- Values Section -->
        <section class="ff-about-values">
            <h2 class="ff-section-title ff-centered">Our Core Values</h2>
            <div class="ff-values-grid">
                <div class="ff-value-card">
                    <div class="ff-value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="ff-value-title">Passion for Food</h3>
                    <p class="ff-value-text">
                        We live and breathe culinary creativity, celebrating diverse flavors and techniques from around the world.
                    </p>
                </div>
                <div class="ff-value-card">
                    <div class="ff-value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="ff-value-title">Community First</h3>
                    <p class="ff-value-text">
                        Our platform thrives on the shared knowledge and experiences of our global cooking community.
                    </p>
                </div>
                <div class="ff-value-card">
                    <div class="ff-value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="ff-value-title">Continuous Learning</h3>
                    <p class="ff-value-text">
                        We believe every cook is both teacher and student, constantly evolving their skills.
                    </p>
                </div>
                <div class="ff-value-card">
                    <div class="ff-value-icon">
                        <i class="fas fa-globe-americas"></i>
                    </div>
                    <h3 class="ff-value-title">Cultural Celebration</h3>
                    <p class="ff-value-text">
                        Food is our universal language, connecting cultures through shared culinary traditions.
                    </p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="ff-about-team">
            <h2 class="ff-section-title ff-centered">Meet Our Team</h2>
            <p class="ff-team-subtitle">
                The passionate foodies behind Food Fusion
            </p>
            <div class="ff-team-grid">
                <div class="ff-team-member">
                    <div class="ff-team-image">
                        <img src="../img/Founder.jpg" alt="Ye Wint Aung">
                    </div>
                    <h3 class="ff-team-name">Ye Wint Aung</h3>
                    <p class="ff-team-role">Founder & CEO</p>
                    <p class="ff-team-bio">
                        Professional chef with 15 years experience in international cuisine and culinary education.
                    </p>
                </div>
                <div class="ff-team-member">
                    <div class="ff-team-image">
                        <img src="../img/Head_of_Community.jpg" alt="Kristle">
                    </div>
                    <h3 class="ff-team-name">Kristle</h3>
                    <p class="ff-team-role">Head of Community</p>
                    <p class="ff-team-bio">
                        Food anthropologist dedicated to preserving and sharing traditional cooking methods.
                    </p>
                </div>
                <div class="ff-team-member">
                    <div class="ff-team-image">
                        <img src="../img/director.jpg" alt="Nyi Nyi Zaw Htet">
                    </div>
                    <h3 class="ff-team-name">Nyi Nyi Zaw Htet</h3>
                    <p class="ff-team-role">Content Director</p>
                    <p class="ff-team-bio">
                        Recipe developer and food photographer making culinary art accessible to all.
                    </p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="ff-about-cta">
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
        </section>
    </main>

    <!-- Footer would go here -->
    <?php include 'footer.php'; ?>
</body>
</html>