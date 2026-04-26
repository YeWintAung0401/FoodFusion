<?php
session_start();
include 'connection.php';

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

// Prevent self-deletion
if ($id == $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot delete your own account";
    header("Location: usersList.php");
    exit();
}

try {
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM usertbl WHERE userID = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['error'] = "No user found with that ID";
        }
    } else {
        $_SESSION['error'] = "Error deleting user: " . $stmt->error;
    }
    
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

$conn->close();
header("Location: usersList.php");
exit();
?>