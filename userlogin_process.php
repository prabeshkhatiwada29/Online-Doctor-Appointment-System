<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); // Turn off error display in production

// Database connection
$conn = new mysqli("localhost", "root", "", "medicare_db");
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Both username and password fields are required!";
        header("Location: login.php"); // Redirect back to login page
        exit();
    }

    // SQL query to find the user by username
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = "Error preparing SQL statement: " . $conn->error;
        header("Location: login.php");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and verify password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $row['id']; // Assuming the primary key is 'id'
            $_SESSION['username'] = $row['username'];

            // Redirect to the user dashboard
            header("Location: user_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: login.php"); // Redirect back to login page
            exit();
        }
    } else {
        $_SESSION['error'] = "User account not found.";
        header("Location: login.php"); // Redirect back to login page
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
