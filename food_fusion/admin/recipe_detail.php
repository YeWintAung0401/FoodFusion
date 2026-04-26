<?php
include('connection.php');
session_start();

if (!isset($_GET['id'])) {
    header("Location: recipesList.php");
    exit();
}

$recipe_id = $_GET['id'];
$query = "SELECT * 
          FROM recipes 
          WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $recipe_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recipe = mysqli_fetch_assoc($result);

if (!$recipe) {
    header("Location: recipesList.php?error=recipe_not_found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['recipeName']); ?> - Recipe Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .recipe-header {
            margin-bottom: 30px;
        }
        
        .recipe-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #222;
        }
        
        .recipe-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
            color: #666;
        }
        
        .recipe-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .recipe-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .recipe-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #222;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
        }
        
        .ingredients-list, .instructions-list {
            list-style-type: none;
            padding-left: 0;
        }
        
        .ingredients-list li, .instructions-list li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        
        .ingredients-list li:before {
            content: "•";
            color: #1a73e8;
            font-size: 1.2rem;
            position: absolute;
            left: 0;
            top: -3px;
        }
        
        .instructions-list li:before {
            content: counter(step);
            counter-increment: step;
            background: #1a73e8;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: -10px;
            top: 0;
            font-size: 0.8rem;
        }
        
        .instructions-list {
            counter-reset: step;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #1a73e8;
            text-decoration: none;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .difficulty-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .difficulty-easy {
            background-color: #e6f7e6;
            color: #2e7d32;
        }
        
        .difficulty-medium {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .difficulty-hard {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .difficulty-time-consuming {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        
        @media (max-width: 768px) {
            .recipe-meta {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <?php include('adminNav.php'); ?>
    
    <div class="recipe-header">
        <h1 class="recipe-title"><?php echo htmlspecialchars($recipe['recipeName']); ?></h1>
        
        <div class="recipe-meta">
            <span class="recipe-meta-item"><i class="fas fa-clock"></i> <?php echo htmlspecialchars($recipe['cooking_time']); ?> minutes</span>
            <span class="recipe-meta-item"><i class="fas fa-utensils"></i> <?php echo htmlspecialchars($recipe['serving']); ?> servings</span>
            <span class="recipe-meta-item"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($recipe['category']); ?></span>
            
            <?php if (!empty($recipe['cuisine'])): ?>
                <span class="recipe-meta-item"><i class="fas fa-globe-americas"></i> <?php echo htmlspecialchars($recipe['cuisine']); ?></span>
            <?php endif; ?>
            
            <?php if (!empty($recipe['difficulty'])): ?>
                <span class="recipe-meta-item">
                    <i class="fas fa-tachometer-alt"></i> 
                    <span class="difficulty-badge difficulty-<?php echo strtolower(str_replace(' ', '-', $recipe['difficulty'])); ?>">
                        <?php echo htmlspecialchars($recipe['difficulty']); ?>
                    </span>
                </span>
            <?php endif; ?>
        </div>
        
        <?php if ($recipe['photo_path']): ?>
            <img src="<?php echo htmlspecialchars($recipe['photo_path']); ?>" 
                 alt="<?php echo htmlspecialchars($recipe['recipeName']); ?>" 
                 class="recipe-image">
        <?php endif; ?>
        
        <p><?php echo nl2br(htmlspecialchars($recipe['recipedescription'])); ?></p>
    </div>
    
    <div class="recipe-section">
        <h2 class="section-title">Ingredients</h2>
        <ul class="ingredients-list">
            <?php 
            $ingredients = explode("\n", $recipe['ingredients']);
            foreach ($ingredients as $ingredient): 
                if (trim($ingredient)): ?>
                    <li><?php echo htmlspecialchars(trim($ingredient)); ?></li>
                <?php endif; 
            endforeach; ?>
        </ul>
    </div>
    
    <a href="recipesList.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Recipes</a>
</body>
</html>