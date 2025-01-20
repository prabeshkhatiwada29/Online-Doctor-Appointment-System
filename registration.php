<?php
session_start();

// Check if session variables are set and display the messages
if (isset($_SESSION['errors'])) {
    echo "<script>var errors = " . json_encode($_SESSION['errors']) . ";</script>";
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Medicare Hospital</title>
    <link rel="stylesheet" href="logindesign.css">
</head>
<body>
    <header>
        <h1>Online Doctor Appointment</h1>
    </header>

    <main>
        <section id="register" class="login-section">
            <h2>Create a New Account</h2>

            <!-- Display error messages if any -->
            <div id="message-container"></div>

            <!-- Registration Form -->
            <form id="registration-form" action="register_process.php" method="POST" class="login-form" onsubmit="return validateForm()">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>

                <button type="submit">Sign Up</button>
            </form>

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </section>
    </main>

    <script src="registration.js"></script>
</body>
</html>
