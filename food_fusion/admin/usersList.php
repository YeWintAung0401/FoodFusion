<?php 
    include('connection.php');
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./adminStyle.css">
</head>
<body class="user-management-system">
    <!-- Navigation Bar -->
    <?php include('adminNav.php'); ?>

    <div class="ums-container">
        <h1 class="ums-page-title">User Management System</h1>
        <!-- User List Section -->
        <div class="ums-list-section">
            <form class="ums-search-container" action="usersList.php" method="POST">
                <input type="text" 
                       id="ums-search-input" 
                       class="ums-search-input" 
                       placeholder="Search users..." 
                       name="txtSearchName"
                       value="<?php echo isset($_POST['txtSearchName']) ? htmlspecialchars($_POST['txtSearchName']) : ''; ?>">
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>">
                <button type="submit" 
                        id="ums-search-btn" 
                        class="ums-search-btn" 
                        name="btnSearch">
                    <i class="fas fa-search ums-search-icon"></i>
                </button>
            </form>

            <div class="ums-table-responsive">
                <table id="ums-users-table" class="ums-users-table">
                    <!-- Table headers remain the same -->
                    <thead class="ums-table-header">
                        <tr class="ums-table-row">
                            <th class="ums-table-head ums-col-id">ID</th>
                            <th class="ums-table-head ums-col-photo">Photo</th>
                            <th class="ums-table-head ums-col-name">Name</th>
                            <th class="ums-table-head ums-col-email">Email</th>
                            <th class="ums-table-head ums-col-phone">Phone</th>
                            <th class="ums-table-head ums-col-status">Status</th>
                            <th class="ums-table-head ums-col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ums-users-list" class="ums-table-body">
                        <?php 
                        // Pagination setup
                        $per_page = 10;
                        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                        $offset = ($page - 1) * $per_page;
            
                        if (!isset($_POST['btnSearch'])) {
                            // Count total records
                            $count_query = "SELECT COUNT(*) as total FROM usertbl";
                            $count_result = mysqli_query($conn, $count_query);
                            $total_rows = mysqli_fetch_assoc($count_result)['total'];
                            $total_pages = ceil($total_rows / $per_page);
                
                            // Get paginated data
                            $select_query = "SELECT userID, userFName, userLName, userEmail, userPhone, userPassword, photo, Status 
                                            FROM usertbl ";
                            $select_result = mysqli_query($conn, $select_query);
                
                            if (mysqli_num_rows($select_result) > 0) {
                                while ($arr = mysqli_fetch_array($select_result)) {
                                    $id = $arr['userID'];
                                    $uName = $arr['userFName'] . ' ' . $arr['userLName'];
                                    $uEmail = $arr['userEmail'];
                                    $uPhone = $arr['userPhone'];
                                    $uPhoto = $arr['photo'];
                                    $uStatus = $arr['Status'];

                                    echo '<tr class="ums-table-row">
                                        <td class="ums-table-cell ums-col-id">'.$id.'</td>
                                        <td class="ums-table-cell ums-col-photo"><img src="'.$uPhoto.'" alt="User Photo" class="ums-user-photo"></td>
                                        <td class="ums-table-cell ums-col-name">'.$uName.'</td>
                                        <td class="ums-table-cell ums-col-email">'.$uEmail.'</td>
                                        <td class="ums-table-cell ums-col-phone">'.$uPhone.'</td>
                                        <td class="ums-table-cell ums-col-status">'.($uStatus == 1 ? 'Active' : 'Blocked').'</td>
                                        <td class="ums-table-cell ums-col-actions">
                                            <a href="edit_user.php?id='.$id.'" class="ums-action-btn ums-edit">Edit</a>
                                            <a href="delete_process.php?id='.$id.'" class="ums-action-btn ums-delete" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>
                                            <a href="block_user.php?id='.$id.'" class="ums-action-btn ums-block '.($uStatus == 1 ? '' : 'ums-unblock').'">
                                                '.($uStatus == 1 ? 'Block' : 'Unblock').'
                                            </a>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="ums-no-results">No users found</td></tr>';
                            }
                        } else {
                            $searchName = $_POST['txtSearchName'];
                            $page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1;
                            $offset = ($page - 1) * $per_page;

                            // Count total search results
                            $count_query = "SELECT COUNT(*) as total FROM usertbl 
                                           WHERE userFName LIKE '$searchName%' 
                                           OR userLName LIKE '$searchName%' 
                                           OR userEmail LIKE '$searchName%' 
                                           OR userPhone LIKE '$searchName%'";
                            $count_result = mysqli_query($conn, $count_query);
                            $total_rows = mysqli_fetch_assoc($count_result)['total'];
                            $total_pages = ceil($total_rows / $per_page);
                
                            // Get paginated search results
                            $search_query = "SELECT userID, userFName, userLName, userEmail, userPhone, userPassword, photo, Status 
                                           FROM usertbl 
                                           WHERE userFName LIKE '$searchName%' 
                                           OR userLName LIKE '$searchName%' 
                                           OR userEmail LIKE '$searchName%' 
                                           OR userPhone LIKE '$searchName%'";
                            $search_result = mysqli_query($conn, $search_query);
                
                            if (mysqli_num_rows($search_result) > 0) {
                                while ($searchArr = mysqli_fetch_array($search_result)) {
                                    // Display search results (same as before)
                                    $id = $searchArr['userID'];
                                    $uName = $searchArr['userFName'] . ' ' . $searchArr['userLName'];
                                    $uEmail = $searchArr['userEmail'];
                                    $uPhone = $searchArr['userPhone'];
                                    $uPhoto = $searchArr['photo'];
                                    $uStatus = $searchArr['Status'];

                                    echo '<tr class="ums-table-row">
                                        <td class="ums-table-cell ums-col-id">'.$id.'</td>
                                        <td class="ums-table-cell ums-col-photo"><img src="'.$uPhoto.'" alt="User Photo" class="ums-user-photo"></td>
                                        <td class="ums-table-cell ums-col-name">'.$uName.'</td>
                                        <td class="ums-table-cell ums-col-email">'.$uEmail.'</td>
                                        <td class="ums-table-cell ums-col-phone">'.$uPhone.'</td>
                                        <td class="ums-table-cell ums-col-status">'.($uStatus == 1 ? 'Active' : 'Blocked').'</td>
                                        <td class="ums-table-cell ums-col-actions">
                                            <a href="edit_user.php?id='.$id.'" class="ums-action-btn ums-edit">Edit</a>
                                            <a href="delete_process.php?id='.$id.'" class="ums-action-btn ums-delete" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>
                                            <a href="block_user.php?id='.$id.'" class="ums-action-btn ums-block '.($uStatus == 1 ? '' : 'ums-unblock').'">
                                                '.($uStatus == 1 ? 'Block' : 'Unblock').'
                                            </a>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="ums-no-results">No users found matching your search</td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const umsForm = document.getElementById('ums-user-form');
            const umsCancelBtn = document.getElementById('ums-cancel-btn');
            const umsFormTitle = document.getElementById('ums-form-title');

            // Table elements
            const umsUsersList = document.getElementById('ums-users-list');

            // Search elements
            const umsSearchInput = document.getElementById('ums-search-input');
            const umsSearchBtn = document.getElementById('ums-search-btn');

            // Pagination elements
            const umsPrevBtn = document.getElementById('ums-prev-btn');
            const umsNextBtn = document.getElementById('ums-next-btn');
            const umsPageInfo = document.getElementById('ums-page-info');

            // State variables
            let currentPage = 1;
            let totalPages = 1;
            let currentEditId = null;
            let searchQuery = '';
        });
    </script>
</body>
</html>