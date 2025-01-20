<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Medicare Hospital</title>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

header {
    background-color: #3498db;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

header h1 {
    font-size: 2.5rem;
}

/* Main Section */
main {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
}

.login-section {
    background-color: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
}

.login-section h2 {
    font-size: 2.1rem;
    margin-bottom: 20px;
    color: #333;
}

.login-options {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.login-options a {
    background-color: #3498db;
    color: #fff;
    padding: 15px;
    border-radius: 4px;
    font-size: 1.2rem;
}

.login-options a:hover {
    background-color: #2980b9;
}





    </style>
</head>
<body>
    <header>
        <h1> Online Doctor Appointment</h1>

    </header>

    <main>
        <section id="login" class="login-section">
            <h2>Login to Your Account</h2>

            <!-- Buttons to choose login type -->
            <div class="login-options">
                <a href="admin_login.php" class="btn-primary">Login as Admin</a>
                <a href="userlogin.php" class="btn-primary">Login as User</a>
            </div>

            <p>Don't have an account? <a href="registration.php">Sign up here</a></p>
        </section>
    </main>

  \
</body>
</html>
