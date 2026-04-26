<?php
include 'connection.php';
session_start();

// Check authorization
if (!isset($_SESSION['admin'])) {
    header("Location: ../user/login.php");
    exit();
}

// Check if ID exists and is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid user ID";
    header("Location: usersList.php");
    exit();
}

$id = $_GET['id'];

// Fetch user data
try {
    $stmt = $conn->prepare("SELECT * FROM usertbl WHERE userID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "User not found";
        header("Location: usersList.php");
        exit();
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: usersList.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    
    // Handle file upload
    $photo_path = $user['photo']; // Keep existing photo by default
    
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        
        // Check if file is an actual image
        if (getimagesize($_FILES["photo"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Delete old photo if it exists
                if (!empty($user['photo']) && file_exists($user['photo'])) {
                    unlink($user['photo']);
                }
                $photo_path = $target_file;
            } else {
                $_SESSION['error'] = "Error uploading photo";
                header("Location: edit_user.php?id=".$id);
                exit();
            }
        } else {
            $_SESSION['error'] = "File is not an image";
            header("Location: edit_user.php?id=".$id);
            exit();
        }
    } else{
        $photo_path = "../img/default-profile.png";
    }
    
    // Update user in database
    try {
        $stmt = $conn->prepare("UPDATE usertbl SET 
                                userFName = ?, 
                                userLName = ?, 
                                userEmail = ?, 
                                userPhone = ?, 
                                userAddress = ?, 
                                photo = ?, 
                                Status = ? 
                                WHERE userID = ?");
        $stmt->bind_param("ssssssii", 
                         $firstName, 
                         $lastName, 
                         $email, 
                         $phone, 
                         $address, 
                         $photo_path, 
                         $status, 
                         $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "User updated successfully";
            header("Location: usersList.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating user: " . $stmt->error;
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Main Container Styles */
        .ums-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .ums-page-title {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        /* Form Styles */
        form {
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Current Photo Styles */
        .current-photo {
            margin-top: 15px;
            text-align: center;
        }

        .current-photo img {
            border-radius: 4px;
            border: 1px solid #eee;
            padding: 5px;
        }

        .current-photo p {
            margin-top: 5px;
            color: #666;
            font-size: 14px;
        }

        /* Button Styles */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .ums-btn {
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .ums-btn-primary {
            background-color: #4a90e2;
            color: white;
            border: none;
        }

        .ums-btn-primary:hover {
            background-color: #3a7bc8;
        }

        .ums-btn-secondary {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .ums-btn-secondary:hover {
            background-color: #e0e0e0;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .ums-container {
                padding: 15px;
                margin: 10px;
            }
        }
    </style>
</head>
<body class="user-management-system">
    <?php include('adminNav.php'); ?>
    
    <div class="ums-container">
        <h1 class="ums-page-title">Edit User</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="firstName" value="<?php echo htmlspecialchars($user['userFName']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lastName" value="<?php echo htmlspecialchars($user['userLName']); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['userEmail']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['userPhone']); ?>">
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <textarea name="address"><?php echo htmlspecialchars($user['userAddress']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" name="photo" id="photo-upload" accept="image/*" onchange="previewImage(this)">
    
                <?php if (!empty($user['photo'])): ?>
                    <div class="current-photo" id="current-photo-container">
                        <img src="<?php echo htmlspecialchars($user['photo']); ?>" id="current-photo" alt="Current Photo">
                        <p>Current Photo</p>
                    </div>
                <?php endif; ?>
    
                <div id="new-photo-preview" style="display: none; margin-top: 10px;">
                    <img id="photo-preview" src="#" alt="New Photo Preview" style="max-width: 200px;">
                    <p>New Photo</p>
                    <button type="button" onclick="cancelNewPhoto()" class="ums-btn ums-btn-secondary" style="margin-top: 5px; padding: 5px 10px; font-size: 14px;">
                        Cancel
                    </button>
                </div>
            </div>

            <script>
            function previewImage(input) {
                const previewContainer = document.getElementById('new-photo-preview');
                const currentPhotoContainer = document.getElementById('current-photo-container');
                const preview = document.getElementById('photo-preview');
    
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
        
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.style.display = 'block';
            
                        // Hide current photo if exists
                        if (currentPhotoContainer) {
                            currentPhotoContainer.style.display = 'none';
                        }
                    }
        
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function cancelNewPhoto() {
                const fileInput = document.getElementById('photo-upload');
                const previewContainer = document.getElementById('new-photo-preview');
                const currentPhotoContainer = document.getElementById('current-photo-container');
    
                // Reset file input
                fileInput.value = '';
    
                // Hide preview
                previewContainer.style.display = 'none';
    
                // Show current photo again if it exists
                if (currentPhotoContainer) {
                    currentPhotoContainer.style.display = 'block';
                }
            }
            </script>

            <style>
            .current-photo {
                margin-top: 15px;
                text-align: center;
            }

            .current-photo img {
                max-width: 200px;
                border-radius: 4px;
                border: 1px solid #eee;
                padding: 5px;
            }

            .current-photo p {
                margin-top: 5px;
                color: #666;
                font-size: 14px;
            }

            #new-photo-preview {
                text-align: center;
            }

            #new-photo-preview img {
                max-width: 200px;
                border-radius: 4px;
                border: 1px solid #4a90e2;
                padding: 5px;
            }

            #new-photo-preview p {
                margin-top: 5px;
                color: #4a90e2;
                font-size: 14px;
                font-weight: 600;
            }
            </style>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="1" <?php echo ($user['Status'] == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="2" <?php echo ($user['Status'] == 2) ? 'selected' : ''; ?>>Blocked</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="ums-btn ums-btn-primary">Update User</button>
                <a href="usersList.php" class="ums-btn ums-btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>