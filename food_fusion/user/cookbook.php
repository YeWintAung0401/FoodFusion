<?php
    include('connection.php');
    session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Cookbook</title>
    <style>
        .container {
            max-width: 700px;
            
            margin: 50px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            font-family: 'Segoe UI', sans-serif;
        }

        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .recipe-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: border 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus,
        .form-group input[type="file"]:focus,
        .form-group select:focus {
            border-color: #27ae60;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-action--add {
            background-color: #27ae60;
            color: white;
        }

        .btn-action--add:hover {
            background-color: #219150;
        }

        .btn-action--cancel {
            background-color: #e74c3c;
            color: white;
        }

        .btn-action--cancel:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<body>
    <?php include('userNavbar.php'); ?>
    <div class="container">
        <h1>Share Your Recipe</h1>

        <div class="recipe-form">
            <form method="POST" enctype="multipart/form-data" action="cook_Process.php">

                <!-- Assuming uid comes from session -->

                <div class="form-group">
                    <label for="title">Recipe Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g., Chicken Biryani" required>
                </div>

                <div class="form-group">
                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" placeholder="Tell us what makes this recipe special..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="photo">Upload a Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="btnShareCookbook" class="btn btn-action btn-action--add">
                        <i class="fas fa-paper-plane"></i> Share Recipe
                    </button>
                    <a href="cookbook.php" class="btn btn-action btn-action--cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php include('cookbookList.php'); ?>

</body>
</html>


