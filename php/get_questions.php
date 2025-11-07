<?php
require 'db.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT auth_question_1, auth_question_2, auth_question_3 FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($q1, $q2, $q3);
        $stmt->fetch();
        echo json_encode(['question1' => $q1, 'question2' => $q2, 'question3' => $q3]);
    } else {
        echo json_encode(null);
    }
    $stmt->close();
}
$conn->close();
?>