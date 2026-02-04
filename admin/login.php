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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM admin WHERE username=:username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result && md5($password) === $result->password) {
        $_SESSION['username'] = $result->username;
        $_SESSION['admin_id'] = $result->id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
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
                <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="togglePassword" style="width: auto; margin: 0;">
                    <label for="togglePassword" style="font-weight: normal; font-size: 0.9em; margin: 0; cursor: pointer;">Show Password</label>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <script src="js/login.js"></script>
</body>
</html>