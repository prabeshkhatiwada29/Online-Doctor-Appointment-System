<?php
session_start();

// Check if there's an error message
if (isset($_SESSION['error'])) {
    echo "<p class='error'>{$_SESSION['error']}</p>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Medicare Hospital</title>
    <link rel="stylesheet" href="logindesign.css">
</head>
<body>
    <header>
        <h1>Admin Login - Medicare Hospital</h1>
    </header>

    <main>
        <section id="admin-login" class="login-section">
            <h2>Admin Login</h2>

            <!-- Admin Login Form -->
            <form action="adminlogin_process.php" method="POST" class="login-form">
                <input type="text" name="admin_username" placeholder="Admin Username" required>
                <input type="password" name="admin_password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </section>
    </main>
</body>
</html>
