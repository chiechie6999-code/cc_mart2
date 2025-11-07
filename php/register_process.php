<?php
session_start();
require 'db.php';

$errors = [];
$old_data = $_POST;

// Validate ID Number
$id_number = trim($_POST['id_number']);
if (empty($id_number)) {
    $errors['id_number'] = "ID Number is required.";
} elseif (!preg_match('/^\d{4}-\d{4}$/', $id_number)) {
    $errors['id_number'] = "ID Number must be in the format xxxx-xxxx.";
} else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors['id_number'] = "ID Number already exists.";
    }
    $stmt->close();
}

// Validate First Name, Middle Name, Family Name, Name Extension
$name_fields = ['first_name', 'middle_name', 'family_name', 'name_extension'];
foreach ($name_fields as $field) {
    if (isset($_POST[$field])) {
        $value = trim($_POST[$field]);
        if (!empty($value)) {
            if (!preg_match('/^[A-Z][a-z]+( [A-Z][a-z]+)*$/', $value)) {
                $errors[$field] = "Must start with a capital letter and contain only letters.";
            }
            if (preg_match('/(.)\1\1/', $value)) {
                $errors[$field] = "Cannot contain three repeated letters in a row.";
            }
        }
    }
}

// Validate Birthdate and Age
$birthdate = $_POST['birthdate'];
if (empty($birthdate)) {
    $errors['birthdate'] = "Birthdate is required.";
} else {
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    if ($age < 18) {
        $errors['birthdate'] = "You must be at least 18 years old.";
    }
}

// Validate Email
$email = trim($_POST['email']);
if (empty($email)) {
    $errors['email'] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format.";
} else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors['email'] = "Email already exists.";
    }
    $stmt->close();
}

// Validate Username
$username = trim($_POST['username']);
if (empty($username)) {
    $errors['username'] = "Username is required.";
} else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors['username'] = "Username already exists.";
    }
    $stmt->close();
}

// Validate Password
$password = $_POST['password'];
if (empty($password)) {
    $errors['password'] = "Password is required.";
} elseif (strlen($password) < 8) {
    $errors['password'] = "Password must be at least 8 characters long.";
} elseif ($password !== $_POST['re_enter_password']) {
    $errors['password'] = "Passwords do not match.";
}

// Validate Address fields
$address_fields = ['purok_street', 'barangay', 'municipal_city', 'province', 'country', 'zip_code'];
foreach ($address_fields as $field) {
    if (empty(trim($_POST[$field]))) {
        $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
    }
}

// Validate Security Questions
$auth_question_1 = $_POST['auth_question_1'];
$auth_answer_1 = trim($_POST['auth_answer_1']);
$auth_question_2 = $_POST['auth_question_2'];
$auth_answer_2 = trim($_POST['auth_answer_2']);
$auth_question_3 = $_POST['auth_question_3'];
$auth_answer_3 = trim($_POST['auth_answer_3']);

if (empty($auth_answer_1) || empty($auth_answer_2) || empty($auth_answer_3)) {
    $errors['auth_questions'] = "All security questions must be answered.";
}
if ($auth_question_1 === $auth_question_2 || $auth_question_1 === $auth_question_3 || $auth_question_2 === $auth_question_3) {
    $errors['auth_questions'] = "You must select three different security questions.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old_data'] = $old_data;
    header("Location: registration.php");
    exit;
}

// Hash passwords and answers
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$hashed_answer_1 = password_hash($auth_answer_1, PASSWORD_DEFAULT);
$hashed_answer_2 = password_hash($auth_answer_2, PASSWORD_DEFAULT);
$hashed_answer_3 = password_hash($auth_answer_3, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (id_number, first_name, middle_name, family_name, name_extension, birthdate, age, email, username, password, auth_question_1, auth_answer_1, auth_question_2, auth_answer_2, auth_question_3, auth_answer_3, purok_street, barangay, municipal_city, province, country, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssisssssssssssssss",
    $id_number, $_POST['first_name'], $_POST['middle_name'], $_POST['family_name'], $_POST['name_extension'],
    $birthdate, $age, $email, $username, $hashed_password,
    $auth_question_1, $hashed_answer_1, $auth_question_2, $hashed_answer_2, $auth_question_3, $hashed_answer_3,
    $_POST['purok_street'], $_POST['barangay'], $_POST['municipal_city'], $_POST['province'], $_POST['country'], $_POST['zip_code']
);

if ($stmt->execute()) {
    header("Location: login.php");
    exit;
} else {
    $errors['db_error'] = "Error: " . $stmt->error;
    $_SESSION['errors'] = $errors;
    $_SESSION['old_data'] = $old_data;
    header("Location: registration.php");
    exit;
}

$stmt->close();
$conn->close();
?>