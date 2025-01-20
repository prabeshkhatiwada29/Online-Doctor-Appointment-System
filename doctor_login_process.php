<?php
session_start();
include('db.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        header("Location: doctorlogin.php?error=Please fill in all fields");
        exit();
    }

    // Prepare SQL query to fetch doctor data
    $query = "SELECT * FROM doctor WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $doctor = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $doctor['password'])) {
            // Password is correct, create session and redirect to dashboard
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['name'];
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            // Incorrect password
            header("Location: doctorlogin.php?error=Incorrect password");
            exit();
        }
    } else {
        // Doctor not found
        header("Location: doctorlogin.php?error=Doctor not found");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: doctorlogin.php");
    exit();
}
?>
