<?php 
include('connection.php');
session_start();

if (isset($_POST['register-btn'])) {
    // Initialize variables
    $errors = [];
    
    // Validate and sanitize inputs
    $userFName = mysqli_real_escape_string($conn, trim($_POST['userFName']));
    $userLName = mysqli_real_escape_string($conn, trim($_POST['userLName']));
    $userEmail = mysqli_real_escape_string($conn, trim($_POST['userEmail']));
    $userPassword = $_POST['userPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userPhone = mysqli_real_escape_string($conn, trim($_POST['userPhone'] ?? ''));
    $userAddress = mysqli_real_escape_string($conn, trim($_POST['userAddress'] ?? ''));
    
    // Validate email format
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT userEmail FROM usertbl WHERE userEmail = ?");
    $checkEmail->bind_param("s", $userEmail);
    $checkEmail->execute();
    $checkEmail->store_result();
    
    if ($checkEmail->num_rows > 0) {
        $errors[] = "Email already exists";
    }
    $checkEmail->close();
    
    // Validate password
    if (strlen($userPassword) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    
    // Check password match
    if ($userPassword !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    // File upload handling
    $img_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../img/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Validate file
        $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
        $fileType = $_FILES['photo']['type'];
        $fileSize = $_FILES['photo']['size'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!array_key_exists($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed";
        } elseif ($fileSize > $maxSize) {
            $errors[] = "File size must be less than 2MB";
        } else {
            // Generate unique filename
            $extension = $allowedTypes[$fileType];
            $filename = uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $errors[] = "Failed to upload image";
            } else {
                $img_path = $targetPath;
            }
        }
    }

    if (empty($img_path)) {
        $img_path = "../img/default-profile.png";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $status = "1"; // Define the status value

        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO usertbl (userFName, userLName, userEmail, userPassword, userPhone, userAddress, photo, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind the parameters
        $stmt->bind_param("ssssssss", $userFName, $userLName, $userEmail, $hashedPassword, $userPhone, $userAddress, $img_path, $status);

        // Execute the query
        if ($stmt->execute()) {
            $last_user_id = $conn->insert_id;
            $user_result = $conn->query("SELECT * FROM usertbl WHERE userID = $last_user_id");
            if ($user_result && $user_result->num_rows === 1) {
                $user = $user_result->fetch_assoc();
                $_SESSION['user'] = $user;
                $_SESSION['userID'] = $user['userID'];

                echo "<script>
                        alert('Registration Successful! You are now logged in.');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        } else {
            $errors[] = "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }

    
    // If there were errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['registration_errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header("Location: register.php");
        exit();
    }
}
?>