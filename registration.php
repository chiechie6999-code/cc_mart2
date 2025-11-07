<!DOCTYPE html>
<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_data']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="login.php">Log-in</a>
        </nav>
    </header>
    <main>
        <h1>CabilicDental</h1>
        <form action="php/register.php" method="post" name="myform" onsubmit="return validateform()">
            <div class="form-group">
                <label for="id_number">ID Number*</label>
                <input type="text" id="id_number" name="id_number" placeholder="xxxx-xxxx" required value="<?= htmlspecialchars($old_data['id_number'] ?? '') ?>">
                <div id="id_number-error" class="error-message"><?= htmlspecialchars($errors['id_number'] ?? '') ?></div>
            </div>
            <div class="form-group">
                <label for="first_name">First Name*</label>
                <input type="text" id="first_name" name="first_name" required>
                <div id="first_name-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name <span class="optional">optional</span></label>
                <input type="text" id="middle_name" name="middle_name">
            </div>
            <div class="form-group">
                <label for="family_name">Family Name*</label>
                <input type="text" id="family_name" name="family_name" required>
            </div>
            <div class="form-group">
                <label for="name_extension">Name Extension <span class="optional">optional</span></label>
                <input type="text" id="name_extension" name="name_extension">
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate*</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" required>
                <div id="username-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Password*</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <i class="fa fa-eye" id="toggle-password"></i>
                </div>
                <span id="password-strength" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="re_enter_password">Re-enter Password*</label>
                <div class="password-container">
                    <input type="password" id="re_enter_password" name="re_enter_password" required>
                    <i class="fa fa-eye" id="toggle-re-enter-password"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="purok_street">Purok/Street*</label>
                <input type="text" id="purok_street" name="purok_street" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay*</label>
                <input type="text" id="barangay" name="barangay" required>
            </div>
            <div class="form-group">
                <label for="municipal_city">Municipal/City*</label>
                <input type="text" id="municipal_city" name="municipal_city" required>
            </div>
            <div class="form-group">
                <label for="province">Province*</label>
                <input type="text" id="province" name="province" required>
            </div>
            <div class="form-group">
                <label for="country">Country*</label>
                <input type="text" id="country" name="country" required>
            </div>
            <div class="form-group">
                <label for="zip_code">Zip Code*</label>
                <input type="text" id="zip_code" name="zip_code" required>
            </div>
            <div class="form-group full-width">
                <label for="auth_question_1">Authentication Question 1*</label>
                <select id="auth_question_1" name="auth_question_1" required>
                    <option value="Who is your best friend in Elementary?">Who is your best friend in Elementary?</option>
                    <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                    <option value="Who is your favorite teacher in high school?">Who is your favorite teacher in high school?</option>
                </select>
                <label for="auth_answer_1">Answer 1*</label>
                <input type="password" id="auth_answer_1" name="auth_answer_1" required>
            </div>
            <div class="form-group full-width">
                <label for="auth_question_2">Authentication Question 2*</label>
                <select id="auth_question_2" name="auth_question_2" required>
                    <option value="Who is your best friend in Elementary?">Who is your best friend in Elementary?</option>
                    <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                    <option value="Who is your favorite teacher in high school?">Who is your favorite teacher in high school?</option>
                </select>
                <label for="auth_answer_2">Answer 2*</label>
                <input type="password" id="auth_answer_2" name="auth_answer_2" required>
            </div>
            <div class="form-group full-width">
                <label for="auth_question_3">Authentication Question 3*</label>
                <select id="auth_question_3" name="auth_question_3" required>
                    <option value="Who is your best friend in Elementary?">Who is your best friend in Elementary?</option>
                    <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                    <option value="Who is your favorite teacher in high school?">Who is your favorite teacher in high school?</option>
                </select>
                <label for="auth_answer_3">Answer 3*</label>
                <input type="password" id="auth_answer_3" name="auth_answer_3" required>
                <div id="security-questions-error" class="error-message"></div>
            </div>
            <div class="form-group full-width">
                <button type="submit">Register</button>
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 CabilicDental. All rights reserved.</p>
    </footer>
    <script src="js/registration.js"></script>
</body>
</html>