<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="registration.php">Register</a>
        </nav>
    </header>
    <main>
        <h1>ccmart</h1>
        <form action="login_process.php" method="post" name="loginform" class="login-form">
            <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password*</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <i class="fa fa-eye" id="toggle-password"></i>
                </div>
            </div>
            <button type="submit" id="login-button">Log-in</button>
            <div id="forgot-password-link"
                style="display: <?php echo (isset($_SESSION['show_forgot_password']) && $_SESSION['show_forgot_password']) ? 'block' : 'none'; ?>;">
                <a href="forgot_password.php">Forgot Password? Reset Here</a>
            </div>
             <p>Not yet a member? <a href="registration.php">Please register here</a></p>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 ccmart. All rights reserved.</p>
    </footer>
    <script src="../js/login.js"></script>
    <?php
    session_start();
    if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time'])) {
        $remainingTime = $_SESSION['lockout_time'] - time();
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const loginButton = document.getElementById('login-button');
                const registerLink = document.querySelector('a[href=\"registration.php\"]');
                loginButton.disabled = true;
                registerLink.style.pointerEvents = 'none';
                registerLink.style.color = 'gray';

                let timeLeft = $remainingTime;
                const timer = setInterval(function() {
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        loginButton.disabled = false;
                        registerLink.style.pointerEvents = 'auto';
                        registerLink.style.color = 'blue';
                        loginButton.textContent = 'Log-in';
                    } else {
                        loginButton.textContent = 'Retry in ' + timeLeft + 's';
                        timeLeft--;
                    }
                }, 1000);
            });
        </script>";
    }
    ?>
    <script>
        // Disable back button
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };
    </script>
</body>
</html>