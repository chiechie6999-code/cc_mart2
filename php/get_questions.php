<?php
include 'db.php';
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';

if (empty($username)) {
    echo json_encode(['error' => 'Username cannot be empty.']);
    exit();
}

$stmt = $conn->prepare("SELECT auth_question_1, auth_question_2, auth_question_3 FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Username not found.']);
}

$stmt->close();
$conn->close();
?>