<?php
session_start();
include 'db.php';

// Initialize session variables for login attempts if they don't exist
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

// Check if the user is currently locked out
if (time() < $_SESSION['lockout_time']) {
    // Redirect back to login with a message
    $remaining_time = $_SESSION['lockout_time'] - time();
    header("Location: ../login.php?error=locked&time=" . $remaining_time);
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Successful login
        $_SESSION['login_attempts'] = 0; // Reset attempts on success
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../home.php");
        exit();
    }
}

// If login is unsuccessful
$_SESSION['login_attempts']++;
$lockout_duration = 0;

if ($_SESSION['login_attempts'] >= 9) {
    $lockout_duration = 60; // 60 seconds
} elseif ($_SESSION['login_attempts'] >= 6) {
    $lockout_duration = 30; // 30 seconds
} elseif ($_SESSION['login_attempts'] >= 3) {
    $lockout_duration = 15; // 15 seconds
}

if ($lockout_duration > 0) {
    $_SESSION['lockout_time'] = time() + $lockout_duration;
}


$stmt->close();
$conn->close();

// Redirect back to login with a generic error message
header("Location: ../login.php?error=invalid");
exit();
?>