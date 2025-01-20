<?php
session_start();

// Check if the success session variable is set
if (!isset($_SESSION['success'])) {
    header("Location: registration.php"); // Redirect to registration if no success message
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - Medicare Hospital</title>
    <link rel="stylesheet" href="logindesign.css">
</head>
<body>
    <header>
        <h1>Online Doctor Appointment</h1>
    </header>

    <main>
        <section id="success" class="login-section">
            <h2>Registration Successful</h2>

            <!-- Display success message -->
            <div class="success-message">
                <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    unset($_SESSION['success']); // Clear the success message from the session
                }
                ?>
            </div>

            <p>Click <a href="login.php">here</a> to log in and start booking your appointments.</p>
        </section>
    </main>
</body>
</html>
