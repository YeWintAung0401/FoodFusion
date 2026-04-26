<?php 
session_start();

$_SESSION = [];
session_unset();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Timer</title>    
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .timer-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }

        .timer-container h1 {
            color: #d32f2f;
            margin-bottom: 20px;
        }

        .timer {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .message {
            color: #555;
            margin-top: 15px;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="timer-container">
    <h1>Login is Blocked</h1>
    <div class="timer" id="Timer">Loading...</div>
    <div class="message">Too many failed attempts. Please wait to try again.</div>
</div>

    <script>
        // Set target time to 3 minutes from now
        var now = new Date();
        now.setMinutes(now.getMinutes() + 1);  // Set to 3 minutes
        var ResetTime = now.getTime();

        var x = setInterval(function () {
            var currentTime = new Date().getTime();
            var distance = ResetTime - currentTime;

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("Timer").innerHTML = minutes + "m " + seconds + "s";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("Timer").innerHTML = "Redirecting...";
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>


</body>
</html>
