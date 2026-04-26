<?php
include('connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('You must be logged in to share a cookbook.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnShareCookbook'])) {
    $errors = [];
    $uid = $_SESSION['userID'];

    // Sanitize inputs
    $title = trim(htmlspecialchars($_POST['title']));
    $description = trim(htmlspecialchars($_POST['description']));
    $created_at = date('Y-m-d H:i:s');

    // Validate fields
    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    // Handle file upload
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $fileType = $_FILES['photo']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, WEBP, and GIF images are allowed.";
        } else {
            $uploadDir = 'uploads/cookbook/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('cook_') . '.' . $fileExt;
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $errors[] = "Failed to upload image.";
            } else {
                $photoPath = $targetPath;
            }
        }
    } else {
        $errors[] = "Please upload a cookbook image.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO cookbook (uid, title, description, photo, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $uid, $title, $description, $photoPath, $created_at);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Cookbook shared successfully!');
                    window.location.href = 'cookbook.php';
                </script>";
            } else {
                throw new Exception("Database error: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "<script>
                alert('Failed to share cookbook. Please try again later.');
                window.history.back();
            </script>";
        } finally {
            if (isset($stmt)) $stmt->close();
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
