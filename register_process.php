<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "medicare_db");

// Check the connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Function to check if the email domain is valid
function isValidEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = [];

    // Validate input fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (!preg_match("/^[A-Za-z\s]{3,}$/", $username)) {
        $errors[] = "Username must be at least 3 characters long and contain only letters and spaces.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !isValidEmailDomain($email)) {
        $errors[] = "Invalid email address or domain.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password)) {
        $errors[] = "Password must be at least 8 characters long and include letters and numbers.";
    }

    // If errors exist, redirect back with errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: registration.php");
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute and handle the result
    if ($stmt->execute()) {
        $_SESSION['success'] = "<p class='success'>Congratulations! Your account has been successfully created.</p>";
        header("Location: success.php"); // Redirect to success page
        exit();
    } else {
        $_SESSION['errors'] = ["Error: " . $stmt->error];
        header("Location: registration.php"); // Redirect back to registration if error
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
