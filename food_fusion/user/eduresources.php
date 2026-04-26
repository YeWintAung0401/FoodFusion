<?php  
include('connection.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Resources</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<style>
    /* Food Fusion Education - Unique CSS Classes */
    :root {
        --ff-primary: #e63946;
        --ff-secondary: #457b9d;
        --ff-accent: #ffbe0b;
        --ff-dark: #1d3557;
        --ff-light: #f1faee;
        --ff-text: #333;
        --ff-text-light: #6c757d;
    }

    /* Base Styles */
    .ff-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Typography */
    .ff-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: var(--ff-dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 10px;
    }

    .ff-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 70px;
        height: 4px;
        background-color: var(--ff-primary);
    }

    .ff-resource-title {
        font-size: 1.6rem;
        color: var(--ff-dark);
        margin-bottom: 0.75rem;
    }

    .ff-resource-meta {
        color: var(--ff-text-light);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: block;
    }

    .ff-resource-desc {
        margin-bottom: 1.5rem;
        color: var(--ff-text);
        line-height: 1.7;
    }

    /* Buttons */
    .ff-btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .ff-primary-btn {
        background-color: var(--ff-primary);
        color: white;
    }

    .ff-primary-btn:hover {
        background-color: #c1121f;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(225, 57, 70, 0.3);
    }

    .ff-download-btn {
        background-color: var(--ff-secondary);
        color: white;
    }

    .ff-download-btn:hover {
        background-color: #315a7a;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(69, 123, 157, 0.3);
    }

    .ff-video-btn {
        background-color: #ff006e;
        color: white;
    }

    .ff-video-btn:hover {
        background-color: #d00060;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(255, 0, 110, 0.3);
    }

    .ff-interactive-btn {
        background-color: var(--ff-accent);
        color: var(--ff-dark);
    }

    .ff-interactive-btn:hover {
        background-color: #e9ac0b;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(255, 190, 11, 0.3);
    }

    /* Hero Section */
    .ff-edu-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=1600&auto=format');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 220px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .ff-hero-content h1 {
        font-size: 3.2rem;
        margin-bottom: 20px;
        color: white;
    }

    .ff-hero-content p {
        font-size: 1.3rem;
        max-width: 700px;
        margin: 0 auto 30px;
    }

    /* Category Grid Section */
    .ff-category-grid {
        padding: 60px 0;
        background-color: #f8f9fa;
    }

    .ff-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .ff-section-title {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.2rem;
        color: var(--ff-dark);
        position: relative;
    }

    .ff-section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: var(--ff-primary);
    }

    .ff-category-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .ff-category-card {
        background: white;
        padding: 35px 25px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ff-category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }

    .ff-category-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: var(--ff-primary);
    }

    .ff-category-card h3 {
        margin: 0 0 15px 0;
        font-size: 1.4rem;
    }

    .ff-category-card p {
        margin: 0 0 25px 0;
        color: var(--ff-text-light);
        flex-grow: 1;
    }

    .ff-category-card .ff-btn {
        margin-top: auto;
        width: 80%;
        max-width: 180px;
    }

    .ff-btn-group {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .ff-btn i {
        margin-right: 5px;
    }

    /* Category-specific icon colors */
    .ff-fundamentals-card .ff-category-icon {
        color: #e63946;
    }

    .ff-world-cuisine-card .ff-category-icon {
        color: #457b9d;
    }

    .ff-science-card .ff-category-icon {
        color: #ff006e;
    }

    .ff-nutrition-card .ff-category-icon {
        color: #2a9d8f;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .ff-category-grid {
            padding: 40px 0;
        }
    
        .ff-section-title {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }
    
        .ff-category-wrapper {
            gap: 20px;
        }
    
        .ff-category-card {
            padding: 25px 15px;
        }
    }

    @media (max-width: 480px) {
        .ff-category-wrapper {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    /* Resource Sections */
    .ff-resource-section {
        padding: 80px 0;
    }

    .ff-fundamentals-bg {
        background-color: #f8f9fa;
    }

    .ff-cuisine-bg {
        background-color: #fff9f0;
    }

    .ff-science-bg {
        background-color: #f0f8ff;
    }

    .ff-nutrition-bg {
        background-color: #f0fff4;
    }

    .ff-resource-list {
        margin-top: 40px;
    }

    .ff-resource-item {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 40px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .ff-resource-thumb {
        aspect-ratio: 3/2; 
    }

    .ff-resource-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ff-resource-details {
        flex: 2 1 400px;
        padding: 30px;
    }

    /* Newsletter */
    .ff-newsletter {
        text-align: center;
        padding: 80px 0;
        background-color: var(--ff-dark);
        color: white;
    }

    .ff-newsletter .ff-section-title {
        color: white;
    }

    .ff-newsletter .ff-section-title::after {
        background-color: var(--ff-accent);
    }

    .ff-newsletter-desc {
        max-width: 600px;
        margin: 0 auto 30px;
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .ff-newsletter-form {
        display: flex;
        max-width: 500px;
        margin: 0 auto;
    }

    .ff-newsletter-input {
        flex: 1;
        padding: 12px 15px;
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 1rem;
    }

    .ff-subscribe-btn {
        background-color: var(--ff-accent);
        color: var(--ff-dark);
        border-radius: 0 4px 4px 0;
        font-weight: 600;
    }

    .ff-subscribe-btn:hover {
        background-color: #e9ac0b;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .ff-edu-hero {
            padding: 80px 0;
        }
    
        .ff-hero-content h1 {
            font-size: 2.5rem;
        }
    
        .ff-section-title {
            font-size: 1.8rem;
        }
    
        .ff-resource-item {
            flex-direction: column;
        }
    
        .ff-resource-thumb {
            min-height: 200px;
        }
    
        .ff-newsletter-form {
            flex-direction: column;
        }
    
        .ff-newsletter-input,
        .ff-subscribe-btn {
            width: 100%;
            border-radius: 4px;
        }
    
        .ff-subscribe-btn {
            margin-top: 10px;
        }
    }

    /* Animations */
    @keyframes ffFadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .ff-resource-section {
        animation: ffFadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    .ff-resource-section:nth-child(1) { animation-delay: 0.1s; }
    .ff-resource-section:nth-child(2) { animation-delay: 0.2s; }
    .ff-resource-section:nth-child(3) { animation-delay: 0.3s; }
    .ff-resource-section:nth-child(4) { animation-delay: 0.4s; }
</style>
    <?php include('userNavbar.php'); ?>

    <main>
        <section class="ff-edu-hero">
            <div class="ff-hero-content">
                <h1>Food Fusion Educational Resources</h1>
                <p>Explore our collection of culinary learning materials, recipes, and cultural food guides</p>
            </div>
        </section>

        <section class="ff-category-grid">
            <div class="ff-container">
                <h2 class="ff-section-title">Learning Categories</h2>
                <div class="ff-category-wrapper">
                    <div class="ff-category-card ff-fundamentals-card">
                        <i class="fas fa-book-open ff-category-icon"></i>
                        <h3>Culinary Fundamentals</h3>
                        <p>Master basic cooking techniques, knife skills, and kitchen safety</p>
                        <a href="#fundamentals" class="ff-btn ff-primary-btn">Explore</a>
                    </div>
                    
                    <div class="ff-category-card ff-world-cuisine-card">
                        <i class="fas fa-globe-americas ff-category-icon"></i>
                        <h3>World Cuisines</h3>
                        <p>Discover traditional dishes and cooking methods from around the globe</p>
                        <a href="#world-cuisines" class="ff-btn ff-primary-btn">Explore</a>
                    </div>
                    
                    <div class="ff-category-card ff-science-card">
                        <i class="fas fa-flask ff-category-icon"></i>
                        <h3>Food Science</h3>
                        <p>Understand the chemistry and physics behind cooking processes</p>
                        <a href="#food-science" class="ff-btn ff-primary-btn">Explore</a>
                    </div>
                    
                    <div class="ff-category-card ff-nutrition-card">
                        <i class="fas fa-leaf ff-category-icon"></i>
                        <h3>Nutrition</h3>
                        <p>Learn about balanced diets, superfoods, and dietary requirements</p>
                        <a href="#nutrition" class="ff-btn ff-primary-btn">Explore</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="fundamentals" class="ff-resource-section ff-fundamentals-bg">
            <div class="ff-container">
                <h2 class="ff-section-title">Culinary Fundamentals</h2>
                <div class="ff-resource-list">
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://img.freepik.com/free-photo/front-view-person-cutting-carrot-near-orange_23-2148555352.jpg?w=600&h=400&fit=crop&auto=format" alt="Knife Skills" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Essential Knife Skills</h3>
                            <p class="ff-resource-meta">PDF Guide • Beginner • 8 pages</p>
                            <p class="ff-resource-desc">Learn proper knife handling, basic cuts, and maintenance techniques that every cook should master.</p>
                            <a href="../PDF/Basic_Knife_Skill.pdf" class="ff-btn ff-download-btn" download>Download Guide</a>
                        </div>
                    </div>
                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1547592180-85f173990554?w=600&h=400&fit=crop&auto=format" alt="Cooking Methods" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Cooking Methods Explained</h3>
                            <p class="ff-resource-meta">Video Course</p>
                            <p class="ff-resource-desc">Detailed explanations and demonstrations of various cooking techniques from sautéing to sous-vide.</p>
        
                            <div class="ff-btn-group">
                                <a href="https://youtu.be/RS8ALWDlpis" class="ff-btn ff-video-btn" target="_blank">
                                    <i class="fas fa-play"></i> Watch Video
                                </a>
                                <a href="../video/CookingMethods.mp4" class="ff-btn ff-download-btn" target="_blank" download >
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=600&h=400&fit=crop&auto=format" alt="Kitchen Safety" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Kitchen Safety Handbook</h3>
                            <p class="ff-resource-meta">Interactive Guide • All Levels</p>
                            <p class="ff-resource-desc">Comprehensive guide to food safety, fire prevention, and accident avoidance in the kitchen.</p>
                            <a href="https://www.foodsafety.gov/food-safety-charts" class="ff-btn ff-interactive-btn">Access Guide</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="world-cuisines" class="ff-resource-section ff-cuisine-bg">
            <div class="ff-container">
                <h2 class="ff-section-title">World Cuisines</h2>
                <div class="ff-resource-list">
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=600&h=400&fit=crop&auto=format" alt="Asian Cuisine" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Asian Culinary Traditions</h3>
                            <p class="ff-resource-meta">Interactive Module • Intermediate</p>
                            <p class="ff-resource-desc">Explore the diverse flavors and techniques from China, Japan, Thailand, and more with our interactive learning module.</p>
                            <a href="https://haikucuisine.com/en/news/voyage-culinaire-en-terre-asiatique" class="ff-btn ff-interactive-btn">Start Learning</a>
                        </div>
                    </div>
                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&h=400&fit=crop&auto=format" alt="Mediterranean Diet" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Mediterranean Diet Guide</h3>
                            <p class="ff-resource-meta">E-book </p>
                            <p class="ff-resource-desc">Comprehensive guide to the healthy Mediterranean eating pattern with authentic recipes.</p>
                            <a href="../PDF/Mediterranean_Diet_Guide.pdf" class="ff-btn ff-download-btn" download><i class="fas fa-download"></i> Download E-book</a>
                        </div>
                    </div>
                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=600&h=400&fit=crop&auto=format" alt="Latin American Cuisine" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Latin American Flavors</h3>
                            <p class="ff-resource-meta">Video Course</p>
                            <p class="ff-resource-desc">Master the techniques behind Mexican, Peruvian, Brazilian and other Latin cuisines.</p>
                            <a href="https://youtu.be/lCIsUaWfj0Q" class="ff-btn ff-video-btn" target="_blank">
                                <i class="fas fa-play"></i> Watch Video
                            </a>
                            <a href="../video/Latin_American_Flavors.mp4" class="ff-btn ff-download-btn" target="_blank" download >
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="food-science" class="ff-resource-section ff-science-bg">
            <div class="ff-container">
                <h2 class="ff-section-title">Food Science</h2>
                <div class="ff-resource-list">                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img 
                              src="https://i0.wp.com/www.easyonlinebakinglessons.com/wp-content/uploads/2020/10/baking-science-2.jpg?resize=600%2C400&quality=85&ssl=1" 
                              alt="Baker's hands with flour and dough, showing gluten development" 
                              class="ff-resource-img"
                              width="600"
                              height="400"
                              loading="lazy">                    
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">The Science of Baking</h3>
                            <p class="ff-resource-meta">PDF Guide • Beginner • 273 pages</p>
                            <p class="ff-resource-desc">Visual guide explaining the chemical reactions that occur during baking.</p>
                            <a href="../PDF/scienceOfBaking.pdf" class="ff-btn ff-download-btn" download>
                                <i class="fas fa-download"></i> Download E-book
                            </a>
                        </div>
                    </div>
                
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1571167366136-b57e07761625?w=600&h=400&fit=crop&auto=format" alt="Food Preservation" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">The Science of Food Preservation</h3>
                            <p class="ff-resource-meta">Interactive Guide • All levels</p>
                            <p class="ff-resource-desc">Learn the scientific principles behind canning, fermenting, drying and other preservation methods.</p>
                            <a href="https://www.sciencedirect.com/topics/food-science/food-preservation" class="ff-btn ff-interactive-btn">Start Learning</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="nutrition" class="ff-resource-section ff-nutrition-bg">
            <div class="ff-container">
                <h2 class="ff-section-title">Nutrition</h2>
                <div class="ff-resource-list">
                    <div class="ff-resource-item">
                        <div class="ff-resource-thumb">
                            <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=600&h=400&fit=crop&auto=format" alt="Dietary Needs" class="ff-resource-img">
                        </div>
                        <div class="ff-resource-details">
                            <h3 class="ff-resource-title">Special Dietary Needs Guide</h3>
                            <p class="ff-resource-meta">Video Course</p>
                            <p class="ff-resource-desc">Nutritional guidance for gluten-free, dairy-free, diabetic and other special diets.</p>
                            <a href="https://youtu.be/x0-Dob7NLc4" class="ff-btn ff-video-btn" target="_blank">
                                <i class="fas fa-play"></i> Watch Video
                            </a>
                            <a href="../video/SpecialDietaryNeeds.mp4" class="ff-btn ff-download-btn" download>
                                <i class="fas fa-download"></i> Download 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <?php include('footer.php'); ?>
</body>
</html>