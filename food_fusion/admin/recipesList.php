<?php
    include('connection.php');
    session_start();

// Handle delete request FIRST (before any output)
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id']; // Type cast for safety
    $delete_query = "DELETE FROM recipes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $delete_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: recipesList.php?delete_success=1");
            exit();
        } else {
            header("Location: recipesList.php?delete_error=1");
            exit();
        }
    } else {
        header("Location: recipesList.php?delete_error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1, h2 {
            color: #2c3e50;
        }
        
        .recipe-form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            max-height: 70vh;
            overflow-y: auto;
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 8px;
        }

        .btn-action i {
            font-size: 14px;
        }

        /* Save/Update Button */
        .btn-action--delete {
            background-color: #ff0000ff;
            color: white;
        }

        .btn-action--delete:hover {
            background-color: #ff0000ff;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);
        }

        /* Add Button */
        .btn-action--add {
            background-color: #007bff;
            color: white;
        }

        .btn-action--add:hover {
            background-color: #0069d9;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
        }

        /* Cancel Button */
        .btn-action--cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-action--cancel:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(108, 117, 125, 0.3);
        }
        
        .recipe-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .recipe-table th, .recipe-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .recipe-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .recipe-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .recipe-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .action-btns {
            display: flex;
            gap: 10px;
        }
        
        .no-recipes {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include 'adminNav.php'; ?>
    <div class="container">
        <h1>Recipe Management</h1>
        
        <!-- Recipe Form (Add/Edit) -->
        <div class="recipe-form">
            <form method="POST" enctype="multipart/form-data" action="recipes_process.php">
                <!-- <input type="hidden" name="recipe_id">  -->
                
                <div class="form-group">
                    <label for="recipe_name">Recipe Name</label>
                    <input type="text" id="recipe_name" name="recipe_name" required>
                </div>
                
                <div class="form-group">
                    <label for="recipe_description">Description</label>
                    <textarea id="recipe_description" name="recipe_description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="cooking_time">Cooking Time (minutes)</label>
                    <input type="number" id="cooking_time" name="cooking_time" required>
                </div>
                
                <div class="form-group">
                    <label for="servings">Servings</label>
                    <input type="number" id="servings" name="servings" required>
                </div>
                
                <div class="form-group">
                    <label for="ingredients">Ingredients (one per line)</label>
                    <textarea id="ingredients" name="ingredients" required></textarea>
                </div>

                <div class="form-group ">
                    <label for="difficulty">Cultural Cooking Difficulty</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="">How challenging are traditional techniques?</option>
                        <option value="Easy">Simple (Basic techniques)</option>
                        <option value="Medium">Intermediate (Special equipment/methods)</option>
                        <option value="Hard">Advanced (Traditional mastery required)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Dinner">Dinner</option>
                        <option value="Dessert">Dessert</option>
                    </select>
                </div>

                <div class="form-group">
                        <label for="cuisine">Cuisine Origin</label>
                        <select id="cuisine" name="cuisine" required>
                            <option value="">Select regional cuisine</option>
                            <option value="Southeast Asian">Southeast Asian (Thai, Vietnamese, Indonesian)</option>
                            <option value="European">European (Mediterranean, Continental, Nordic)</option>
                            <option value="Latin American">Latin American (Mexican, Brazilian, Peruvian)</option>
                            <option value="North American">North American (Regional specialties)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="recipe_photo">Recipe Photo</label>
                    <input type="file" id="recipe_photo" name="recipe_photo" accept="image/*">
                </div>
                
                <div class="form-actions">
                    <!-- Show Add button when creating new recipe -->
                    <button type="submit" name="btnAddRecipe" class="btn btn-action btn-action--add">
                        <i class="fas fa-plus"></i> Add Recipe
                    </button>
                    <a href="recipesList.php" class="btn btn-action btn-action--cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>

        <?php include('recipe_Collection.php'); ?>
        



    </div>
</body>
</html>