<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
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
        <h1>CabilicDental</h1>
        <form action="php/login.php" method="post" name="loginform">
            <label for="username">Username*</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password*</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fa fa-eye" id="toggle-password"></i>
            </div>
            <button type="submit" id="login-button">Log-in</button>
            <div id="forgot-password-link" style="display: none;">
                <a href="forgot_password.php">Forgot Password? Reset Here</a>
            </div>
             <p>Not yet a member? <a href="registration.php">Please register here</a></p>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 CabilicDental. All rights reserved.</p>
    </footer>
    <script src="js/login.js"></script>
</body>
</html>