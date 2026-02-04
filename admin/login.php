<?php
session_start();
include('includes/dbconnection.php');
$error_message = '';

// If user is already logged in, redirect to the dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // include('includes/dbconnection.php'); // Uncomment when DB is ready
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- Placeholder for database validation ---
    // In a real application, query the database for the user
    // and verify the hashed password.
    if ($username === 'admin' && $password === 'password') { // Example credentials
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Administrator';
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
    // --- End of placeholder ---
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error-message { background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>
</html>