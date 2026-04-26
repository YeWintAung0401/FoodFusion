<?php
ob_start(); // Start output buffering to prevent "headers already sent"

include('connection.php');


// Handle edit request (for loading form data)
$recipe_to_edit = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $edit_query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $edit_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $edit_id);
        mysqli_stmt_execute($stmt);
        $edit_result = mysqli_stmt_get_result($stmt);
        $recipe_to_edit = mysqli_fetch_assoc($edit_result);
    }
}

// Fetch all recipes for display
$query = "SELECT * 
          FROM recipes 
          ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

ob_end_flush(); // End buffering — output can now be sent safely
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* existing CSS styles */
          .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 20px;
        }
        
        .recipe-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .recipe-image-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .recipe-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .recipe-card:hover .recipe-image {
            transform: scale(1.05);
        }
        
        .recipe-details {
            padding: 20px;
        }
        
        .recipe-title {
            font-size: 1.3rem;
            margin: 0 0 10px;
            color: #333;
            font-weight: 600;
        }
        
        .recipe-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .recipe-author {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #555;
            margin-bottom: 10px;
        }
        
        .recipe-description {
            color: #555;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 60px;
        }
        
        .recipe-category {
            display: inline-block;
            background: #f0f7ff;
            color: #1a73e8;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        
        .recipe-actions {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid #eee;
            margin-top: 15px;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view {
            background-color: #1a73e8;
            color: white;
        }
        
        .btn-view:hover {
            background-color: #0d5bba;
        }
        
        .btn-edit {
            background-color: #f0f7ff;
            color: #1a73e8;
            border: 1px solid #1a73e8;
        }
        
        .btn-edit:hover {
            background-color: #e1f0ff;
        }
        
        .btn-delete {
            background-color: #fff0f0;
            color: #e81a1a;
            border: 1px solid #e81a1a;
        }
        
        .btn-delete:hover {
            background-color: #ffe1e1;
        }
        
        .no-recipes {
            text-align: center;
            padding: 50px;
            color: #666;
            grid-column: 1 / -1;
        }
        
        .no-recipes i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .recipe-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 90%;
                padding: 20px;
            }
        }
        
        /* Add success/error message styles */
        .alert {
            padding: 15px;
            margin: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .close-alert {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: inherit;
        }
    </style>
</head>
<body>

    <!-- Display success/error messages -->
        <?php if (isset($_GET['delete_success'])): ?>
            <div id="alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
                Recipe deleted successfully!
            </div>

            <script>
                // Auto-hide the alert after 3 seconds
                setTimeout(function() {
                    const alert = document.getElementById('alert-success');
                    if (alert) {
                        alert.style.transition = "opacity 0.5s ease";
                        alert.style.opacity = 0;
                        setTimeout(() => alert.style.display = "none", 500); // Remove from view after fade
                    }
                }, 3000); // 3 seconds
            </script>
        <?php endif; ?>

    <?php if (isset($_GET['delete_error'])): ?>
        <div id="alert-error" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
            Error deleting recipe. Please try again.
        </div>

        <script>
            setTimeout(function() {
                const alert = document.getElementById('alert-error');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.style.display = "none", 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>


    <!-- Recipes List -->
    <h2 style="padding: 20px 20px 0;">Recipe Collection</h2>
    <div class="recipe-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($recipe = mysqli_fetch_assoc($result)): ?>
                <div class="recipe-card">
                    <div class="recipe-image-container">
                        <?php if ($recipe['photo_path']): ?>
                            <img src="<?php echo htmlspecialchars($recipe['photo_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($recipe['recipeName']); ?>" 
                                 class="recipe-image">
                        <?php else: ?>
                            <div style="height: 100%; background: #f5f5f5; display: flex; 
                                align-items: center; justify-content: center;">
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
                            <a href="recipe_detail.php?id=<?php echo $recipe['id']; ?>" class="btn btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="recipe_edit.php?edit_id=<?php echo $recipe['id']; ?>" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="recipesList.php?delete_id=<?php echo $recipe['id']; ?>" class="btn btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this recipe?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-recipes">
                <i class="fas fa-book-open"></i>
                <h3>No Recipes Found</h3>
                <p>Get started by adding your first recipe!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.querySelector('.modal-overlay');
            if (event.target === modal) {
                window.location.href = 'recipesList.php';
            }
        });
    </script>
</body>
</html>