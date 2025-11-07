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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="php/logout.php">Log-out</a>
        </nav>
    </header>
    <main>
        <h1>Welcome to CabilicDental</h1>
        </main>
    <footer>
        <p>&copy; 2024 CabilicDental. All rights reserved.</p>
    </footer>
</body>
</html>