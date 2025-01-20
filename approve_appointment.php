<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.html");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$conn = new mysqli("localhost", "root", "", "medicare_db");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Update appointment status to 'Approved'
    $sql = "UPDATE appointments SET status = 'Approved' WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error approving appointment!";
    }
}

$conn->close();
?>
