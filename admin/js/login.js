document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Form Validation
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            const username = document.getElementById('username').value.trim();
            const password = passwordInput.value.trim();

            if (!username || !password) {
                e.preventDefault();
                alert('Please enter both username and password.');
            }
        });
    }

    // Show/Hide Password Toggle
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    }
});