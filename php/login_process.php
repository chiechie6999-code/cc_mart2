<?php
session_start();
require 'db.php';

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

if (time() < $_SESSION['lockout_time']) {
    // Still locked out
    header("Location: login.php");
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        // Login successful
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lockout_time']);
        unset($_SESSION['show_forgot_password']);
        header("Location: home.php");
        exit;
    }
}

// Login failed
$_SESSION['login_attempts']++;

if ($_SESSION['login_attempts'] >= 2) {
    $_SESSION['show_forgot_password'] = true;
}

if ($_SESSION['login_attempts'] >= 3) {
    $lockout_duration = 15; // 15 seconds for the first lockout
    if (isset($_SESSION['lockout_count']) && $_SESSION['lockout_count'] == 1) {
        $lockout_duration = 30;
    } elseif (isset($_SESSION['lockout_count']) && $_SESSION['lockout_count'] >= 2) {
        $lockout_duration = 60;
    }

    $_SESSION['lockout_time'] = time() + $lockout_duration;
    $_SESSION['lockout_count'] = isset($_SESSION['lockout_count']) ? $_SESSION['lockout_count'] + 1 : 1;
    $_SESSION['login_attempts'] = 0;
}

header("Location: login.php");
exit;

$stmt->close();
$conn->close();
?>