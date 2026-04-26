    <?php  
    include('connection.php');

    session_start();

    if (!isset($_SESSION['login_counter'])) {
        $_SESSION['login_counter'] = 0;
    }

    if (isset($_POST['btnLogin'])) {
        $email = $_POST['useremail'];
        $password = $_POST['password'];

        // Check in usertbl
        $user_query = "SELECT * FROM usertbl WHERE userEmail = '$email'";
        $user_result = mysqli_query($conn, $user_query);

        // Check in admintbl
        $admin_query = "SELECT * FROM admintbl WHERE adminEmail = '$email'";
        $admin_result = mysqli_query($conn, $admin_query);

        // If admin email found
        if (mysqli_num_rows($admin_result) === 1) {
            $admin = mysqli_fetch_assoc($admin_result);
            $plain_pw = $admin['adminPassword'];

            if ($password === $plain_pw) {
                $_SESSION['admin'] = $admin;
                // $_SESSION['role'] = 'admin';

                echo "<script>
                        alert('Admin Login Successful!');
                        window.location.href='../admin/index.php';
                    </script>";
                exit();
            } else {
                // error_log("Login failed: wrong password for $email");
                handleFailedAttempt();
            }
        }
        // If user email found
        elseif (mysqli_num_rows($user_result) === 1) {
            $user = mysqli_fetch_assoc($user_result);
            $hashed_pw = $user['userPassword'];
            $user_status = $user['Status'];

            if ($user_status == 1) { // Check if user is active (status = 1)
                if (password_verify($password, $hashed_pw)) {
                    $_SESSION['user'] = $user;
                    $_SESSION['userID'] = $user['userID'];

                    echo "<script>
                            alert('Login Successful! Welcome!');
                            window.location.href='index.php';
                        </script>";
                    exit();
                } else {
                    // error_log("Login failed: wrong password for $email");
                    handleFailedAttempt();
                }
            } else {
                // User is blocked (status != 1)
                echo "<script>
                        alert('Your account has been blocked by admin. Please contact support.');
                        window.location.href='login.php';
                    </script>";
                exit();
            }
        }
        // If neither found
        else {
            echo "<script>
                    alert('Invalid Email or Password!');
                    window.location.href='login.php';
                </script>";
            exit();
        }
    }

    // --- Function for failed login ---
    function handleFailedAttempt() {
        // Increment the counter in session
        $_SESSION['login_counter']++;

        $counter = $_SESSION['login_counter'];

        if ($counter == 3) {
            // Set a lock cookie for 10 minutes (600 seconds)
            setcookie("login_counter","c",Time()+1*600); //1minutes

            echo "<script>
                    alert('Too many failed attempts. Please wait 3 minutes before trying again.');
                    window.location.href='loginTimer.php';
                </script>";
            exit();
        } else {
            echo "<script>
                    alert('Invalid Password! Attempt $counter of 3.');
                    window.location.href='login.php';
                </script>";
            exit();
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <div class="login-body">
            <div class="login-container">

                <div class="login-header">
                    <div class="logo">
                        <i class="fas fa-utensils"></i>
                        <span>Foodie's App</span>
                    </div>
                    <h1>Welcome Back</h1>
                    <p>Please login to your account</p>
                </div>

                <form class="login-form" method="POST" action="login.php">
                    <div class="form-group">
                        <label for="useremail">Email</label>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" id="useremail" name="useremail" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <i class="fas fa-eye toggle-pw" id="toggle-pw"></i>
                        </div>
                        <div class="form-options">
                            <label class="checkbox">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                            <a href="forgotPassword.php">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" name="btnLogin" class="login-btn">Login</button>

                    <div class="divider">
                        <span>or continue with</span>
                    </div>

                    <div class="social-login">
                        <button type="button" class="social-btn google">
                            <i class="fab fa-google"></i>
                        </button>
                        <button type="button" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                    </div>

                    <div class="login-footer">
                        Don't have an account? <a href="register.php">Sign up</a>
                    </div>
                </form>

            </div>
        </div>

        <script>
            document.getElementById('toggle-pw').addEventListener('click', function () {
                const pwInput = document.getElementById('password');
                const icon = this;
                if (pwInput.type === 'password') {
                    pwInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    pwInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        </script>
    </body>
    </html>
