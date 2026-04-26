<?php
include('connection.php');
session_start();

// Only process form if submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAddRecipe'])) {
    // Initialize variables and errors array
    $errors = [];
    
    // Sanitize inputs
    $name = trim(htmlspecialchars($_POST['recipe_name']));
    $description = trim(htmlspecialchars($_POST['recipe_description']));
    $cookingTime = (int)$_POST['cooking_time'];
    $servings = (int)$_POST['servings'];
    $ingredients = trim(htmlspecialchars($_POST['ingredients']));
    $category = trim(htmlspecialchars($_POST['category']));
    $difficulty = trim(htmlspecialchars($_POST['difficulty']));
    $cuisine = trim(htmlspecialchars($_POST['cuisine']));

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Recipe name is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if ($cookingTime <= 0) {
        $errors[] = "Cooking time must be greater than 0.";
    }

    if ($servings <= 0) {
        $errors[] = "Servings must be greater than 0.";
    }

    if (empty($ingredients)) {
        $errors[] = "Ingredients list cannot be empty.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    }

    if (empty($difficulty)) {
        $errors[] = "Cultural Cooking Difficulty is required.";
    }

    if (empty($cuisine)) {
        $errors[] = "Cuisine Origin is required.";
    }

    // Handle file upload
    $photoPath = '';
    if (isset($_FILES['recipe_photo']) && $_FILES['recipe_photo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['recipe_photo']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed.";
        } else {
            $uploadDir = 'uploads/recipes/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExt = pathinfo($_FILES['recipe_photo']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $filename;
            
            if (!move_uploaded_file($_FILES['recipe_photo']['tmp_name'], $targetPath)) {
                $errors[] = "Failed to upload image.";
            } else {
                $photoPath = $targetPath;
            }
        }
    }

    if (empty($errors)) {
        try {
            // Insert new recipe
            $stmt = $conn->prepare("INSERT INTO recipes 
                (recipeName, recipedescription, cooking_time, serving, ingredients, category, photo_path, difficulty, cuisine) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?)");
            $stmt->bind_param("ssiisssss", $name, $description, $cookingTime, $servings, $ingredients, $category, $photoPath, $difficulty, $cuisine);

            if ($stmt->execute()) {
                $message = "Recipe added successfully!";
                echo "<script>
                    alert('$message');
                    window.location.href = 'recipesList.php';
                </script>";
            } else {
                throw new Exception("Database error: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "<script>
                alert('Failed to save recipe. Please try again later.');
                window.history.back();
            </script>";
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($oldStmt)) $oldStmt->close();
        }
    } else {
        $errorList = implode("\\n", array_map('addslashes', $errors));
        echo "<script>
            alert('Error:\\n{$errorList}');
            window.history.back();
        </script>";
    }
} 
?>