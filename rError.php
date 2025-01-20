<?php
session_start();

// Display error message if exists
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

// Display success message if exists
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
?>
