document.addEventListener('DOMContentLoaded', function() {
    // Show/hide password
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Login lockout and forgot password link logic
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const loginButton = document.getElementById('login-button');
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const registerLink = document.querySelector('a[href="registration.php"]');

    if (error === 'locked') {
        const remainingTime = parseInt(urlParams.get('time'));
        if (loginButton && registerLink && remainingTime > 0) {
            loginButton.disabled = true;
            registerLink.style.pointerEvents = 'none'; // Disables the link
            let countdown = remainingTime;
            const interval = setInterval(function() {
                loginButton.textContent = 'Wait ' + countdown + 's';
                countdown--;
                if (countdown < 0) {
                    clearInterval(interval);
                    loginButton.disabled = false;
                    loginButton.textContent = 'Log-in';
                    registerLink.style.pointerEvents = 'auto';
                }
            }, 1000);
        }
    }

    // Logic to track login attempts would ideally be session-based on the server,
    // but we can simulate a simple version on the client for the UI effect.
    let failedAttempts = parseInt(sessionStorage.getItem('loginAttempts')) || 0;
    if (error === 'invalid') {
        failedAttempts++;
        sessionStorage.setItem('loginAttempts', failedAttempts);
    }

    if (failedAttempts >= 2 && forgotPasswordLink) {
        forgotPasswordLink.style.display = 'block';
    }

});
