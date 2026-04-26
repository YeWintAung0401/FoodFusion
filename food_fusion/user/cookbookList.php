<?php
include('connection.php');

// Fetch all cookbook posts with user information
$query = "SELECT c.*, u.userFName, u.userLName, u.photo as profile_image
          FROM cookbook c
          JOIN usertbl u ON c.uid = u.userID
          ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Cookbook</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2d3436;
            margin-bottom: 30px;
            font-size: 2.2rem;
        }

        .cookbook-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .cookbook-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .cookbook-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .cookbook-image-container {
            position: relative;
        }

        .cookbook-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .author-info {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.9);
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .author-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }

        .author-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #2d3436;
        }

        .cookbook-details {
            padding: 18px;
        }

        .cookbook-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a1a1a;
        }

        .cookbook-description {
            font-size: 0.95rem;
            color: #636e72;
            margin-bottom: 15px;
            min-height: 60px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .cookbook-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .cookbook-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .no-posts {
            text-align: center;
            color: #636e72;
            font-size: 1.1rem;
            margin-top: 50px;
            grid-column: 1 / -1;
        }

        @media (max-width: 768px) {
            .cookbook-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
        }

    </style>
</head>
<body>

    <h2>Community Cookbook</h2>

    <div class="cookbook-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($result)): ?>
                <div class="cookbook-card">
                    <div class="cookbook-image-container">
                        <?php if (!empty($post['photo'])): ?>
                            <img src="<?php echo htmlspecialchars($post['photo']); ?>" class="cookbook-image" alt="Recipe Image">
                        <?php else: ?>
                            <div style="height: 200px; background: #dfe6e9; display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-utensils" style="font-size: 2.5rem; color: #b2bec3;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="author-info">
                            <?php if (!empty($post['profile_image'])): ?>
                                <?php $photo = '../admin/'; ?>
                                <img src="<?php echo htmlspecialchars($photo . $post['profile_image']); ?>" class="author-avatar" alt="Author Avatar">
                            <?php else: ?>
                                <div class="author-avatar" style="background: #6c5ce7; color: white; display: flex; justify-content: center; align-items: center;">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <span class="author-name"><?php echo htmlspecialchars($post['userFName'] . ' ' . $post['userLName']); ?></span>
                        </div>
                    </div>

                    <div class="cookbook-details">
                        <div class="cookbook-title"><?php echo htmlspecialchars($post['title']); ?></div>
                        <div class="cookbook-description"><?php echo htmlspecialchars($post['description']); ?></div>
                        <div class="cookbook-meta">
                            <div class="cookbook-date">
                                <i class="far fa-calendar-alt"></i> 
                                <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-posts">No recipes found in the cookbook.</div>
        <?php endif; ?>
    </div>

</body>
</html>