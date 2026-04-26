<?php
    session_start();
    include 'connection.php'; // Include your database connection

    $query = "SELECT * FROM contactustbl Order by date DESC";
    // $result=mysqli_query($conn,$query);

    // $query = "SELECT 
    //     m.message_id,
    //     m.message_content,
    //     m.created_at,
    //     u.userID,
    //     u.userFName,
    //     u.userLName,
    //     u.userEmail,
    //     u.photo
    //   FROM contactustbl m
    //   JOIN usertbl u ON m.userID = u.userID
    //   ORDER BY m.created_at DESC";

    $result = $conn->query($query);
    $messages = [];

    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    $conn->close();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users Messages</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .message-feed {
            margin-top: 30px;
        }
        
        .message-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            transition: transform 0.2s ease;
        }
        
        .message-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f0f0f0;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .message-content {
            flex-grow: 1;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .user-name {
            font-weight: 600;
            color: #2c3e50;
            margin-right: 10px;
            font-size: 16px;
        }
        
        .user-email {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .message-text {
            margin: 10px 0;
            line-height: 1.5;
            font-size: 15px;
        }
        
        .message-time {
            font-size: 13px;
            color: #95a5a6;
            display: flex;
            align-items: center;
        }
        
        .message-time:before {
            content: "•";
            margin: 0 8px;
            color: #ddd;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #95a5a6;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include('adminNav.php'); ?>
    
    <div class="header">
        <h1>Community Messages</h1>
        <p>All user messages in one place</p>
    </div>
    
    <div class="message-feed">
        <?php if (empty($messages)): ?>
            <div class="empty-state">
                No messages found in the system.
            </div>
        <?php else: ?>
            <?php foreach ($messages as $message): ?>
                <div class="message-card">
                    <img src="../img/default-profile.jpg" 
                         alt="Default Profile Image" 
                         class="user-avatar">
                    
                    <div class="message-content">
                        <div class="user-info">
                            <span class="user-name">
                                <?php echo htmlspecialchars($message['userName']); ?>
                            </span>
                            <span class="user-email">
                                <?php echo htmlspecialchars($message['userEmail']); ?>
                            </span>
                        </div>
                        
                        <div class="message-text">
                            <?php echo htmlspecialchars($message['message']); ?>
                        </div>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>

