<?php  
include('connection.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Resources Hub</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include('userNavbar.php'); ?>

    <main class="culinary-main">
        <header class="culinary-header">
            <h1>Culinary Resources</h1>
            <p>Providing downloadable recipe cards, cooking tutorials, and instructional videos on various cooking techniques and kitchen hacks.</p>
        </header>

        <section class="resource-categories">
            <div class="category-card">
                <i class="fas fa-utensils"></i>
                <h3>Basic Techniques</h3>
                <p>Master fundamental cooking skills</p>
            </div>
            <div class="category-card">
                <i class="fas fa-bread-slice"></i>
                <h3>Baking Essentials</h3>
                <p>Perfect your pastry skills</p>
            </div>
            <div class="category-card">
                <i class="fas fa-blender"></i>
                <h3>Kitchen Hacks</h3>
                <p>Smart tricks for every cook</p>
            </div>
        </section>

        <section class="featured-resources">
            <h2>Featured Content</h2>
            
            <article class="resource-card video-resource">
                <div class="resource-thumbnail">
                    <img src="../video/img1.png" alt="Jenkins Culinary Resources">
                    <div class="play-icon"><i class="fas fa-play"></i></div>
                </div>
                <div class="resource-content">
                    <h3>Jenkins Culinary Resources</h3>
                    <p class="resource-meta"><i class="far fa-clock"></i> 1:24 mins | <i class="fas fa-download"></i> 6.19 MB</p>
                    <p>Explore a curated video collection by Jenkins Culinary Academy, featuring foundational cooking methods, professional kitchen tips, and culinary insights designed to boost your confidence and skills in the kitchen.</p>
                    <div class="resource-actions">
                        <a href="../video/JenkinsCulinaryResources.mp4" download class="download-btn">
                            <i class="fas fa-download"></i> Download Video
                        </a>
                    </div>
                </div>
            </article>

            <article class="resource-card pdf-resource">
                <div class="resource-thumbnail">
                    <img src="../video/img2.png" alt="Sauce Making Guide">
                </div>
                <div class="resource-content">
                    <h3>The Complete Sauce Guide</h3>
                    <p class="resource-meta"><i class="far fa-file-pdf"></i> PDF | 144 pages</p>
                    <p>The History of Sauce Making.</p>
                    <div class="resource-actions">
                        <a href="../PDF/bookofsauces.pdf" download class="download-btn">
                            <i class="fas fa-download"></i> Download Guide
                        </a>
                    </div>
                </div>
            </article>

            <article class="resource-card video-resource">
                <div class="resource-thumbnail">
                    <img src="../video/img3.png" alt="Meal Prep Tutorial">
                    <div class="play-icon"><i class="fas fa-play"></i></div>
                </div>
                <div class="resource-content">
                    <h3>How to Make Chicken Pasta Primavera</h3>
                    <p class="resource-meta"><i class="far fa-clock"></i> 2:01 mins | <i class="fas fa-download"></i> 7.74 MB</p>
                    <p>Follow this step-by-step guide to prepare a delicious, balanced meal perfect for busy days.</p>
                    <div class="resource-actions">
                        <a href="../video/How to Make Chicken Pasta Primavera.mp4" download class="download-btn">
                            <i class="fas fa-download"></i> Download Video
                        </a>
                    </div>
                </div>
            </article>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>