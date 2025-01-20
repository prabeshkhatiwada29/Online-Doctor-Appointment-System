<?php
// doctor_login.php
session_start();
include 'db.php'; // Replace with your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM doctors WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $doctor = $result->fetch_assoc();
        if (password_verify($password, $doctor['password'])) {
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['name'];
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No doctor found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #e8f5f9; /* Light blue background */
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        .header {
            background-color: #00695c; /* Deep teal for a hospital feel */
            color: white;
            width: 100%;
            padding: 30px 0;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            width: 400px;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .login-container h2 {
            text-align: center;
            color: #00695c; /* Matching the header color */
            margin-bottom: 20px;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container label {
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .login-container button {
            padding: 10px;
            background: #00695c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-container button:hover {
            background: #004d40; /* Darker shade for hover */
        }
        .error {
            color: #d32f2f; /* Red for errors */
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        Online Doctor Appointment System
    </div>
    <div class="login-container">
        <h2>Doctor Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
