<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Medicare Hospital</title>
    <link rel="stylesheet" href="logindesign.css">
</head>
<body>
    <header>
        <h1>Medicare Hospital</h1>
    </header>

    <main>
        <section id="login" class="login-section">
            <!-- Login Form for User -->
            <form action="userlogin_process.php" method="POST" class="login-form">
                <h2>User Login</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login as User</button>
            </form>

            <p>Don't have an account? <a href="registration.php">Sign up here</a></p>
        </section>
    </main>
</body>
</html>
