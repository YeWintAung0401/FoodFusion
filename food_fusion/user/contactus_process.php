<?php
include('connection.php');
session_start();

// Debug: enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('Please log in to send a message.');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Only process form if submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize inputs
    $userName = trim(htmlspecialchars($_POST['ff-name']));
    $userEmail = trim(htmlspecialchars($_POST['ff-email']));
    $message = trim(htmlspecialchars($_POST['ff-message']));
    $date = date("Y-m-d H:i:s");
    $errors = [];
    $userID = $_SESSION['userID'];

    // Validate input
    if (empty($userName)) {
        $errors[] = "Name is required.";
    }

    // Validate email - check for empty first, then validate format
    if (empty($userEmail)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    if (empty($errors)) {
        // Prepare statement with proper error handling
        try {
            $stmt = $conn->prepare("INSERT INTO contactustbl (userName, userEmail, message, date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $userName, $userEmail, $message, $date);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Message sent successfully!');
                    window.location.href = 'contactus.php';
                </script>";
            } else {
                throw new Exception("Database error: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "<script>
                alert('Failed to send message. Please try again later.');
                window.history.back();
            </script>";
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    } else {
        $errorList = implode("\\n", array_map('addslashes', $errors));
        echo "<script>
            alert('Error:\\n{$errorList}');
            window.history.back();
        </script>";
    }
} else {
    // If someone tries to access this page directly
    header("Location: contactus.php");
    exit();
}
?>