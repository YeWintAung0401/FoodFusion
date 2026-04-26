<?php
include('connection.php');
session_start();

// Check if edit_id is provided
if(!isset($_GET['edit_id'])) {
    header("Location: recipesList.php?error=no_recipe_selected");
    exit();
}

$edit_id = (int)$_GET['edit_id'];

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form data
    $id = (int)$_POST['id'];
    $recipeName = mysqli_real_escape_string($conn, $_POST['recipeName']);
    $recipedescription = mysqli_real_escape_string($conn, $_POST['recipedescription']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $cooking_time = (int)$_POST['cooking_time'];
    $serving = (int)$_POST['serving'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $cuisine = mysqli_real_escape_string($conn, $_POST['cuisine']);
    
    // Handle file upload
    $photo_path = $_POST['existing_photo'] ?? null;

    // If remove photo checkbox is checked
    if(isset($_POST['remove_photo']) && $_POST['remove_photo'] == '1') {
        if(!empty($photo_path) && file_exists($photo_path)) {
            unlink($photo_path);
        }
        $photo_path = null;
    } 
    // If a new file is uploaded
    elseif(!empty($_FILES['recipe_photo']['name'])) {
        $target_dir = "uploads/recipes/";
    
        // Create uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Get file info
        $filename = basename($_FILES['recipe_photo']['name']);
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
    
        // Check if file is an actual image
        $check = getimagesize($_FILES['recipe_photo']['tmp_name']);
        if($check === false) {
            die("Error: File is not an image.");
        }
    
        // Check file size (e.g., 5MB limit)
        if ($_FILES['recipe_photo']['size'] > 5000000) {
            die("Error: File is too large. Maximum size is 5MB.");
        }
    
        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if(!in_array($imageFileType, $allowed_types)) {
            die("Error: Only JPG, JPEG, PNG, GIF & WEBP files are allowed.");
        }
    
        // Try to upload file
        if (move_uploaded_file($_FILES['recipe_photo']['tmp_name'], $target_file)) {
            // Delete old photo if it exists
            if(!empty($photo_path) && file_exists($photo_path)) {
                unlink($photo_path);
            }
            $photo_path = $target_file;
        } else {
            die("Error: There was an error uploading your file.");
        }
    }

    // Now you can use $photo_path in your database update/insert query

    // Update query
    $update_query = "UPDATE recipes SET 
                    recipeName = ?, 
                    recipedescription = ?, 
                    ingredients = ?,
                    cooking_time = ?,
                    serving = ?,
                    category = ?,
                    photo_path = ?,
                    difficulty = ?,
                    cuisine = ? 
                    WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $update_query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssisssssi",
        $recipeName,
        $recipedescription,
        $ingredients,
        $cooking_time,
        $serving,
        $category,
        $photo_path,
        $difficulty,
        $cuisine,
        $id
    );

    if(mysqli_stmt_execute($stmt)) {
        // Set session variable for success message
        session_start();
        $_SESSION['update_success'] = true;
        header("Location: recipe_edit.php?edit_id=$id");
        exit();
    } else {
        header("Location: recipe_edit.php?edit_id=$id&error=" . urlencode(mysqli_error($conn)));
        exit();
    }
}

// Start session for success message
$update_success = false;
if(isset($_SESSION['update_success'])) {
    $update_success = true;
    unset($_SESSION['update_success']);
}

// Fetch recipe data
$query = "SELECT * FROM recipes WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $edit_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recipe = mysqli_fetch_assoc($result);

if(!$recipe) {
    header("Location: recipesList.php?error=recipe_not_found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe - <?php echo htmlspecialchars($recipe['recipeName']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .recipe-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
        }
        .recipe-image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .btn-save {
            background-color: #28a745;
            color: white;
        }
        .btn-save:hover {
            background-color: #218838;
        }
        .alert-success {
            animation: fadeOut 3s forwards;
            animation-delay: 2s;
        }
        @keyframes fadeOut {
            to { opacity: 0; display: none; }
        }
    </style>
</head>
<body>
    <?php include('adminNav.php'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if($update_success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        Recipe updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($_GET['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="recipe-form">
                    <div class="form-header">
                        <h2><i class="fas fa-edit me-2"></i>Edit Recipe: <?php echo htmlspecialchars($recipe['recipeName']); ?></h2>
                    </div>
                    
                    <form action="recipe_edit.php?edit_id=<?php echo $recipe['id']; ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
                        <input type="hidden" name="existing_photo" value="<?php echo $recipe['photo_path']; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipeName">Recipe Name</label>
                                    <input type="text" class="form-control" id="recipeName" name="recipeName" 
                                           value="<?php echo htmlspecialchars($recipe['recipeName']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cooking_time">Cooking Time (mins)</label>
                                    <input type="number" class="form-control" id="cooking_time" name="cooking_time" 
                                           value="<?php echo htmlspecialchars($recipe['cooking_time']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="serving">Servings</label>
                                    <input type="number" class="form-control" id="serving" name="serving" 
                                           value="<?php echo htmlspecialchars($recipe['serving']); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="recipedescription">Description</label>
                            <textarea class="form-control" id="recipedescription" name="recipedescription" rows="3" required><?php 
                                echo htmlspecialchars($recipe['recipedescription']); 
                            ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ingredients">Ingredients (one per line)</label>
                                    <textarea class="form-control" id="ingredients" name="ingredients" rows="6" required><?php 
                                        echo htmlspecialchars($recipe['ingredients']); 
                                    ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="Breakfast" <?php echo ($recipe['category'] == 'Breakfast') ? 'selected' : ''; ?>>Breakfast</option>
                                        <option value="Lunch" <?php echo ($recipe['category'] == 'Lunch') ? 'selected' : ''; ?>>Lunch</option>
                                        <option value="Dinner" <?php echo ($recipe['category'] == 'Dinner') ? 'selected' : ''; ?>>Dinner</option>
                                        <option value="Dessert" <?php echo ($recipe['category'] == 'Dessert') ? 'selected' : ''; ?>>Dessert</option>
                                        <option value="Snack" <?php echo ($recipe['category'] == 'Snack') ? 'selected' : ''; ?>>Snack</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cuisine">Cuisine</label>
                                    <select class="form-select" id="cuisine" name="cuisine" required>
                                        <option value="Southeast Asian" <?php echo ($recipe['cuisine'] == 'Southeast Asian') ? 'selected' : ''; ?>>Southeast Asian</option>
                                        <option value="European" <?php echo ($recipe['cuisine'] == 'European') ? 'selected' : ''; ?>>European</option>
                                        <option value="Latin American" <?php echo ($recipe['cuisine'] == 'Latin American') ? 'selected' : ''; ?>>Latin American</option>
                                        <option value="North American" <?php echo ($recipe['cuisine'] == 'North American') ? 'selected' : ''; ?>>North American</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="difficulty">Difficulty</label>
                                    <select class="form-select" id="difficulty" name="difficulty" required>
                                        <option value="Easy" <?php echo ($recipe['difficulty'] == 'Easy') ? 'selected' : ''; ?>>Easy</option>
                                        <option value="Medium" <?php echo ($recipe['difficulty'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Hard" <?php echo ($recipe['difficulty'] == 'Hard') ? 'selected' : ''; ?>>Hard</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipe_photo">Recipe Photo</label>
                                    <input type="file" class="form-control" id="recipe_photo" name="recipe_photo" accept="image/*">
        
                                    <?php if(!empty($recipe['photo_path'])): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo htmlspecialchars($recipe['photo_path']); ?>" 
                                                 class="recipe-image-preview" style="max-width: 200px; max-height: 200px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                                                <label class="form-check-label" for="remove_photo">
                                                    Remove current image
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions mt-4">
                            <a href="recipesList.php" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-fade success alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert-success');
            if(alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>