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

// Prevent self-blocking
if ($id == $_SESSION['admin']) {
    $_SESSION['error'] = "You cannot block your own account";
    header("Location: usersList.php");
    exit();
}
try {
    // First, check current status of the user
    $status_stmt = $conn->prepare("SELECT Status FROM usertbl WHERE userID = ?");
    $status_stmt->bind_param("i", $id);
    $status_stmt->execute();
    $status_result = $status_stmt->get_result();

    if ($status_result->num_rows > 0) {
        $user_status = $status_result->fetch_assoc();
        $current_status = $user_status['Status'];

        // Toggle status: if currently active (1), block (2); else unblock (1)
        $new_status = ($current_status == 1) ? 2 : 1;

        // Update user status
        $stmt = $conn->prepare("UPDATE usertbl SET Status = ? WHERE userID = ?");
        $stmt->bind_param("ii", $new_status, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['success'] = ($new_status == 1) ? "User unblocked successfully" : "User blocked successfully";
            } else {
                $_SESSION['error'] = "User status unchanged or user not found.";
            }
        } else {
            $_SESSION['error'] = "Error updating user status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "No user found with that ID";
    }

    $status_stmt->close();
} catch (Exception $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}


$conn->close();
header("Location: usersList.php");
exit();
?>