<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include('../includes/db.php');

// Modify the query to join with users and doctors tables
$sql = "SELECT appointments.id, appointments.appointment_date, appointments.status, 
               users.name AS user_name, doctors.name AS doctor_name
        FROM appointments
        JOIN users ON appointments.user_id = users.id
        JOIN doctors ON appointments.doctor_id = doctors.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
</head>
<body>
    <header>
        <h1>Manage Appointments</h1>
    </header>

    <section>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Doctor</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <a href="approve_appointment.php?id=<?php echo $row['id']; ?>">Approve</a> |
                            <a href="reject_appointment.php?id=<?php echo $row['id']; ?>">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
$conn->close();
?>
