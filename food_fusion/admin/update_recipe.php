<?php
include('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $recipeName = $_POST['recipeName'];
    $recipedescription = $_POST['recipedescription'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $cooking_time = $_POST['cooking_time'];
    $serving = $_POST['serving'];
    $category = $_POST['category'];
    
    // Handle file upload
    $photo_path = null;
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Generate unique filename
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_path = $target_file;
            }
        }
    }
    
    // Prepare update query
    if ($photo_path) {
        $update_query = "UPDATE recipes SET 
                        recipeName = ?, 
                        recipedescription = ?, 
                        ingredients = ?,
                        instructions = ?,
                        cooking_time = ?,
                        serving = ?,
                        category = ?,
                        photo_path = ?
                        WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssiissi", 
            $recipeName, $recipedescription, $ingredients, $instructions,
            $cooking_time, $serving, $category, $photo_path, $id);
    } else {
        $update_query = "UPDATE recipes SET 
                        recipeName = ?, 
                        recipedescription = ?, 
                        ingredients = ?,
                        instructions = ?,
                        cooking_time = ?,
                        serving = ?,
                        category = ?
                        WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssiisi", 
            $recipeName, $recipedescription, $ingredients, $instructions,
            $cooking_time, $serving, $category, $id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: recipesList.php?update_success=1");
        exit();
    } else {
        header("Location: recipesList.php?error=update_failed");
        exit();
    }
} else {
    header("Location: recipesList.php");
    exit();
}
?>