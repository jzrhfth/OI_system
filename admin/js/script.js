document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const username = loginForm.username.value;
        const password = loginForm.password.value;

        // Placeholder for actual authentication logic
        if (username && password) {
            console.log(`Attempting login for user: ${username}`);
            alert('Login button clicked. Check console for details.');
        } else {
            alert('Please fill in all fields.');
        }
    });
});