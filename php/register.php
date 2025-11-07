<?php
include 'db.php';

function validate_name($name, $field_name) {
    if (empty(trim($name))) return "$field_name can't be blank.";
    if (preg_match('/\\d/', $name)) return "$field_name cannot contain numbers.";
    if (preg_match('/[^a-zA-Z\\s]/', $name)) return "$field_name cannot contain special characters.";
    if (preg_match('/\\s{2,}/', $name)) return "$field_name cannot contain double spaces.";
    if ($name === strtoupper($name)) return "$field_name cannot be all capital letters.";
    if (preg_match('/([a-zA-Z])\\1\\1/', $name)) return "$field_name cannot contain three repeated letters.";
    $words = explode(' ', $name);
    foreach ($words as $word) {
        if (!empty($word) && (ucfirst(strtolower($word)) !== $word)) {
            return "Each word in $field_name must start with a capital letter.";
        }
    }
    return "";
}

$errors = [];

// Get and validate all POST variables
$id_number = $_POST['id_number'] ?? '';
// ... (get all other variables) ...

$first_name_error = validate_name($_POST['first_name'] ?? '', "First Name");
if ($first_name_error) $errors[] = $first_name_error;

// ... (validate all other name fields) ...

if (!preg_match("/^\\d{4}-\\d{4}$/", $id_number)) {
    $errors[] = "Invalid ID Number format.";
}

// ... (add all other server-side validations as per js/registration.js) ...

// Check for duplicates
$stmt = $conn->prepare("SELECT id FROM users WHERE id_number = ? OR email = ? OR username = ?");
$stmt->bind_param("sss", $id_number, $_POST['email'], $_POST['username']);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    $errors[] = "ID Number, Email, or Username already exists.";
}
$stmt->close();

if ($_POST['password'] !== $_POST['re_enter_password']) {
    $errors[] = "Passwords do not match.";
}

if (empty($errors)) {
    // Hash and insert data...
    // (rest of the insertion logic remains the same)
} else {
    // Redirect back with errors
    session_start();
    $_SESSION['errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header("Location: ../registration.php");
    exit();
}

$conn->close();
?>