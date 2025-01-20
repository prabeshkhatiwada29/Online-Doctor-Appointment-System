<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "medicare_db");

// Check the connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Admin login verification
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize input data
    $admin_username = htmlspecialchars(trim($_POST['admin_username']));
    $admin_password = trim($_POST['admin_password']);

    // Validate input
    if (empty($admin_username) || empty($admin_password)) {
        $_SESSION['error'] = "Please enter both username and password.";
        header("Location: admin_login.php");
        exit();
    }

    // SQL query to check if admin exists
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $admin_username, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists and the password matches
    if ($result->num_rows === 1) {
        // Successful login: Store session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_username;
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Incorrect username or password
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: admin_login.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
