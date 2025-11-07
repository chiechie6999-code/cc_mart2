<?php
session_start();
require 'db.php';

$username = $_POST['username'];
$answer1 = $_POST['auth_answer_1'];
$answer2 = $_POST['auth_answer_2'];
$answer3 = $_POST['auth_answer_3'];
$new_password = $_POST['new_password'];
$re_enter_password = $_POST['re_enter_password'];

if ($new_password !== $re_enter_password) {
    // Should be handled by JS, but as a fallback
    header("Location: forgot_password.php");
    exit;
}

$stmt = $conn->prepare("SELECT auth_answer_1, auth_answer_2, auth_answer_3 FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_answer_1, $hashed_answer_2, $hashed_answer_3);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    if (password_verify($answer1, $hashed_answer_1) && password_verify($answer2, $hashed_answer_2) && password_verify($answer3, $hashed_answer_3)) {
        // Answers are correct, update password
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update_stmt->bind_param("ss", $hashed_new_password, $username);
        $update_stmt->execute();
        $update_stmt->close();

        header("Location: login.php"); // Redirect to login on success
        exit;
    }
}

// If answers are wrong or user not found
header("Location: forgot_password.php");
exit;

$stmt->close();
$conn->close();
?>