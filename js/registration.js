document.addEventListener('DOMContentLoaded', function() {
    // Show/hide password
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            togglePasswordVisibility(passwordInput, this);
        });
    }

    const toggleReEnterPassword = document.getElementById('toggle-re-enter-password');
    const reEnterPasswordInput = document.getElementById('re_enter_password');
    if (toggleReEnterPassword && reEnterPasswordInput) {
        toggleReEnterPassword.addEventListener('click', function() {
            togglePasswordVisibility(reEnterPasswordInput, this);
        });
    }

    // Age calculation
    const birthdateInput = document.getElementById('birthdate');
    if (birthdateInput) {
        birthdateInput.addEventListener('change', calculateAge);
    }

    // Password strength check
    if (passwordInput) {
        passwordInput.addEventListener('input', checkPasswordStrength);
    }

    // Live username check
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.addEventListener('blur', checkUsername);
    }

    // Prevent duplicate security questions
    const questionSelects = document.querySelectorAll('select[name^="auth_question"]');
    questionSelects.forEach(select => {
        select.addEventListener('change', validateSecurityQuestions);
    });
});

function togglePasswordVisibility(input, icon) {
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    icon.classList.toggle('fa-eye-slash');
}

function calculateAge() {
    const birthdate = new Date(this.value);
    const ageInput = document.getElementById('age');
    if (!isNaN(birthdate.getTime())) {
        let age = new Date().getFullYear() - birthdate.getFullYear();
        const m = new Date().getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && new Date().getDate() < birthdate.getDate())) {
            age--;
        }
        ageInput.value = age;
    } else {
        ageInput.value = '';
    }
}

function checkPasswordStrength() {
    const password = this.value;
    const strengthIndicator = document.getElementById('password-strength');
    let strength = 'Weak';
    let color = 'red';

    if (password.length >= 12 && /[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[^A-Za-z0-9]/.test(password)) {
        strength = 'Strong';
        color = 'green';
    } else if (password.length >= 8 && (/[A-Z]/.test(password) || /[a-z]/.test(password)) && /\d/.test(password)) {
        strength = 'Medium';
        color = 'orange';
    }

    strengthIndicator.textContent = 'Strength: ' + strength;
    strengthIndicator.style.color = color;
}


function checkUsername() {
    const username = this.value;
    const usernameError = document.getElementById('username-error');
    if (username.trim() !== '') {
        fetch('php/check_username.php?username=' + encodeURIComponent(username))
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    usernameError.textContent = 'Username already taken.';
                } else {
                    usernameError.textContent = '';
                }
            });
    }
}

function validateSecurityQuestions() {
    const selects = Array.from(document.querySelectorAll('select[name^="auth_question"]'));
    const selectedValues = selects.map(s => s.value);
    const hasDuplicates = new Set(selectedValues).size !== selectedValues.length;

    const errorDiv = document.getElementById('security-questions-error');
    if (hasDuplicates && selectedValues.every(v => v !== '')) {
        errorDiv.textContent = 'Please select three unique security questions.';
    } else {
        errorDiv.textContent = '';
    }
}


function validateform() {
    let isValid = true;
    // Clear all previous errors
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    // Name validations
    isValid = validateNameField('first_name', 'First Name') && isValid;
    isValid = validateNameField('family_name', 'Family Name') && isValid;
    // ... continue for all fields

    return isValid;
}

function validateNameField(fieldId, fieldName) {
    const field = document.getElementById(fieldId);
    const errorEl = document.getElementById(fieldId + '-error');
    const value = field.value;

    if (value.trim() === "") {
        errorEl.textContent = fieldName + " can't be blank.";
        return false;
    }
    // Add all other name validation logic here, setting errorEl.textContent
    return true;
}

// Add similar validation functions for other fields...
