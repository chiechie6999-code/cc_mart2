<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="login.php">Log-in</a>
        </nav>
    </header>
    <main>
        <h1>CabilicDental</h1>
        <form action="php/reset_password.php" method="post" name="resetform">
            <label for="username">Username*</label>
            <input type="text" id="username" name="username" required onchange="fetchQuestions()">

            <div id="questions-container" style="display: none;">
                <label id="question_1_label"></label>
                <input type="password" id="auth_answer_1" name="auth_answer_1" required>
                <label id="question_2_label"></label>
                <input type="password" id="auth_answer_2" name="auth_answer_2" required>
                <label id="question_3_label"></label>
                <input type="password" id="auth_answer_3" name="auth_answer_3" required>

                <label for="new_password">New Password*</label>
                <input type="password" id="new_password" name="new_password" required>
                <label for="re_enter_password">Re-enter New Password*</label>
                <input type="password" id="re_enter_password" name="re_enter_password" required>

                <button type="submit">Reset Password</button>
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 CabilicDental. All rights reserved.</p>
    </footer>
    <script src="js/forgot_password.js"></script>
</body>
</html>