<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: userlogin.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$doctor_id = $_POST['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$reason = $_POST['reason']; // Get the reason from the form

// Validate appointment_date to prevent past dates
$current_date = date("Y-m-d"); // Get the current date
if ($appointment_date < $current_date) {
    die("Invalid date: Appointments cannot be booked for past dates.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "medicare_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate if the user exists in the users table
$user_check_sql = "SELECT id FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_check_sql);
if (!$user_stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_stmt->store_result();

if ($user_stmt->num_rows === 0) {
    die("Invalid user ID: The user does not exist.");
}

$user_stmt->close();

// Validate if the doctor exists in the doctors table
$doctor_check_sql = "SELECT id FROM doctors WHERE id = ?";
$doctor_stmt = $conn->prepare($doctor_check_sql);
if (!$doctor_stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}
$doctor_stmt->bind_param("i", $doctor_id);
$doctor_stmt->execute();
$doctor_stmt->store_result();

if ($doctor_stmt->num_rows === 0) {
    die("Invalid doctor ID: The doctor does not exist.");
}

$doctor_stmt->close();

// Insert appointment into the database
$sql = "INSERT INTO appointments (user_id, doctor_id, appointment_date, reason) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}

$stmt->bind_param("iiss", $user_id, $doctor_id, $appointment_date, $reason); // Add reason here
if ($stmt->execute()) {
    // Redirect or show a success message
    header("Location: user_dashboard.php");
    exit();
} else {
    die("Error in booking appointment: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
