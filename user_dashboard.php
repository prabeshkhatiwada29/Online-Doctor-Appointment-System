<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: userlogin.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "medicare_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointment history for the logged-in user
$sql = "SELECT a.id AS appointment_id, d.name AS doctor_name, a.appointment_date, a.status
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.id
        WHERE a.user_id = ?
        ORDER BY a.appointment_date DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="userdashboard.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h1>
        <a href="project.php">Logout</a>
    </header>
    <main>
        <!-- Appointment History Section -->
        <section>
            <h2>Your Appointments</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no appointments.</p>
            <?php endif; ?>
        </section>

        <!-- Appointment Booking Section -->
        <section>
            <h2>Book Appointment</h2>
            <form action="book_appointment.php" method="POST">
                <label for="doctor_id">Select Doctor:</label>
                <select name="doctor_id" id="doctor_id" required>
                    <?php
                    $doctors = $conn->query("SELECT * FROM doctors");
                    if ($doctors && $doctors->num_rows > 0):
                        while ($doctor = $doctors->fetch_assoc()):
                            echo "<option value='{$doctor['id']}'>" . htmlspecialchars($doctor['name']) . " (" . htmlspecialchars($doctor['specialization']) . ")</option>";
                        endwhile;
                    else:
                        echo "<option value=''>No doctors available</option>";
                    endif;
                    ?>
                </select>
                <label for="appointment_date">Date:</label>
                <input type="date" name="appointment_date" id="appointment_date" required>
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" required></textarea>
                <button type="submit">Book</button>
            </form>
        </section>
    </main>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
