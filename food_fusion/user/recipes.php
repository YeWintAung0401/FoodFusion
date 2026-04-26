<?php
include('connection.php');
session_start();

// Fetch all recipes with author info
$query = "SELECT * 
          FROM recipes 
          ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Collection - Food Fusion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h2 {
            padding: 20px 20px 0;
            text-align: center;
            color: #333;
        }

        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 25px;
        }

        .recipe-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
        }

        .recipe-image-container {
            height: 200px;
            overflow: hidden;
            background-color: #f0f0f0;
        }

        .recipe-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recipe-details {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .recipe-title {
            font-size: 1.4rem;
            margin: 0 0 10px;
            color: #2c3e50;
        }

        .recipe-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #555;
        }

        .recipe-meta i {
            margin-right: 6px;
            color: #888;
        }

        .recipe-author {
            font-size: 0.9rem;
            margin-bottom: 12px;
            color: #777;
            display: flex;
            align-items: center;
        }

        .recipe-author i {
            margin-right: 6px;
            color: #aaa;
        }

        .recipe-description {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 12px;
        }

        .recipe-category {
            background-color: #e8eaf6;
            color: #3f51b5;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .recipe-actions {
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-comment {
            background-color: #28a745;
            color: white;
        }

        .btn-comment:hover {
            background-color: #218838;
        }

        .no-recipes {
            text-align: center;
            padding: 50px;
            color: #888;
        }

        .no-recipes i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ccc;
        }

    </style>
</head>
<body>

    <?php include('userNavbar.php'); ?>

    <h2 style="padding: 20px 20px 0;">Recipe Collection</h2>

    <div class="recipe-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($recipe = mysqli_fetch_assoc($result)): ?>
                <div class="recipe-card">
                    <div class="recipe-image-container">
                        <?php
                        $imagePath = !empty($recipe['photo_path']) ? '../admin/' . $recipe['photo_path'] : '';
                        ?>

                        <?php if (!empty($recipe['photo_path'])): ?>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                 alt="<?php echo htmlspecialchars($recipe['recipeName']); ?>" 
                                 class="recipe-image">
                        <?php else: ?>
                            <div style="height: 100%; background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-utensils" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="recipe-details">
                        <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['recipeName']); ?></h3>
                        
                        <div class="recipe-meta">
                            <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($recipe['cooking_time']); ?> mins</span>
                            <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($recipe['serving']); ?> servings</span>
                        </div>
                        
                        <p class="recipe-description"><?php echo htmlspecialchars($recipe['recipedescription']); ?></p>
                        
                        <span class="recipe-category"><?php echo htmlspecialchars($recipe['category']); ?></span>
                        
                        <div class="recipe-actions">
                            <a href="user_recipe_detail.php?id=<?php echo $recipe['id']; ?>" class="btn btn-comment">
                                <i class="fas fa-comment"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-recipes">
                <i class="fas fa-book-open"></i>
                <h3>No Recipes Found</h3>
                <p>Check back later for new additions!</p>
            </div>
        <?php endif; ?>
    </div>


</body>
</html>