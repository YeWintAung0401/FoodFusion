<?php
include('connection.php');
session_start();

// Query to count total users
$userQuery = "SELECT COUNT(*) as total_users FROM usertbl";
$userResult = mysqli_query($conn, $userQuery);
$userCount = mysqli_fetch_assoc($userResult)['total_users'];

// Query to count total recipes
$recipeQuery = "SELECT COUNT(*) as total_recipes FROM recipes";
$recipeResult = mysqli_query($conn, $recipeQuery);
$recipeCount = mysqli_fetch_assoc($recipeResult)['total_recipes'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion Admin Dashboard</title>
    <link rel="stylesheet" href="./adminStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('adminNav.php'); ?>
    
    <main class="admin-main">
        <header class="main-header">
            <h1>Dashboard Overview</h1>
            <div class="breadcrumb">
                <span>Admin</span>
                <span>/</span>
                <span>Dashboard</span>
            </div>
        </header>
        
        <section class="dashboard-grid">
            <article class="stat-card">
                <!-- <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div> -->
                <div class="stat-info">
                    <h3>Total Users</h3>
                    <p><?php echo number_format($userCount); ?></p>
                </div>
            </article>
            
            <article class="stat-card">
                <!-- <div class="stat-icon">
                    <i class="fas fa-utensils"></i>
                </div> -->
                <div class="stat-info">
                    <h3>Total Recipes</h3>
                    <p><?php echo number_format($recipeCount); ?></p>
                </div>
            </article>
            
            <article class="stat-card">
                <!-- <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div> -->
                <div class="stat-info">
                    <h3>Upcoming Events</h3>
                    <p>3</p>
                </div>
            </article>
        </section>
        
    </main>

    <?php
    if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
    ?>
        <!-- Bootstrap Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success</h5>
              </div>
              <div class="modal-body">
                Registration was successful!
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          window.onload = function() {
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
          };
        </script>
    <?php
        unset($_SESSION['registration_success']);
    }
    ?>



</body>
</html>