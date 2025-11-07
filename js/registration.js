document.addEventListener('DOMContentLoaded', function() {
    const idNumberInput = document.getElementById('id_number');
    const idNumberError = document.getElementById('id_number-error');
    const firstNameInput = document.getElementById('first_name');
    const firstNameError = document.getElementById('first_name-error');
    const birthdateInput = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');
    const usernameInput = document.getElementById('username');
    const usernameError = document.getElementById('username-error');
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('password-strength');
    const reEnterPasswordInput = document.getElementById('re_enter_password');
    const togglePassword = document.getElementById('toggle-password');
    const toggleReEnterPassword = document.getElementById('toggle-re-enter-password');

    idNumberInput.addEventListener('input', function() {
        const regex = /^\d{4}-\d{4}$/;
        if (!regex.test(idNumberInput.value)) {
            idNumberError.textContent = "ID Number must be in the format xxxx-xxxx.";
        } else {
            idNumberError.textContent = "";
        }
    });

    firstNameInput.addEventListener('input', function() {
        const regex = /^[A-Z][a-z]+( [A-Z][a-z]+)*$/;
        if (!regex.test(firstNameInput.value)) {
            firstNameError.textContent = "First letter must be capitalized.";
        } else {
            firstNameError.textContent = "";
        }
    });

    birthdateInput.addEventListener('input', function() {
        const birthDate = new Date(birthdateInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        ageInput.value = age;
    });

    usernameInput.addEventListener('blur', function() {
        const username = usernameInput.value;
        if (username.length > 0) {
            fetch('check_username.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'username=' + encodeURIComponent(username)
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'exists') {
                    usernameError.textContent = 'Username already taken.';
                } else {
                    usernameError.textContent = '';
                }
            });
        }
    });

    passwordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        let strength = 'Weak';
        if (password.length >= 8) {
            strength = 'Medium';
        }
        if (password.length >= 8 && /[A-Z]/.test(password) && /[a-z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
            strength = 'Strong';
        }
        passwordStrength.textContent = 'Password Strength: ' + strength;
    });

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    toggleReEnterPassword.addEventListener('click', function() {
        const type = reEnterPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        reEnterPasswordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

});

function validateform() {
    // This function can be expanded with more complex client-side validation if needed.
    // For now, most validation is handled in real-time or by the server.
    const password = document.getElementById('password').value;
    const reEnterPassword = document.getElementById('re_enter_password').value;
    if (password !== reEnterPassword) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}