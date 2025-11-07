<?php
include 'db.php';

$username = $_POST['username'] ?? '';
$answer1 = $_POST['auth_answer_1'] ?? '';
$answer2 = $_POST['auth_answer_2'] ?? '';
$answer3 = $_POST['auth_answer_3'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$re_enter_password = $_POST['re_enter_password'] ?? '';

// Basic validation
if ($new_password !== $re_enter_password) {
    header("Location: ../forgot_password.php?error=mismatch");
    exit();
}

$stmt = $conn->prepare("SELECT auth_answer_1, auth_answer_2, auth_answer_3 FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verify all three answers
    if (password_verify($answer1, $row['auth_answer_1']) &&
        password_verify($answer2, $row['auth_answer_2']) &&
        password_verify($answer3, $row['auth_answer_3'])) {

        // Answers are correct, update the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update_stmt->bind_param("ss", $hashed_password, $username);

        if ($update_stmt->execute()) {
            header("Location: ../login.php?reset=success");
        } else {
            header("Location: ../forgot_password.php?error=dberror");
        }
        $update_stmt->close();

    } else {
        // Answers are incorrect
        header("Location: ../forgot_password.php?error=incorrect");
    }
} else {
    // Username not found
    header("Location: ../forgot_password.php?error=notfound");
}

$stmt->close();
$conn->close();
?>