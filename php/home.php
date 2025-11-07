<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="logout.php">Log-out</a>
        </nav>
    </header>
    <main>
        <h1>Welcome to ccmart</h1>
        </main>
    <footer>
        <p>&copy; 2024 ccmart. All rights reserved.</p>
    </footer>
</body>
</html>