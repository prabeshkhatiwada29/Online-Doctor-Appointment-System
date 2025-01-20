<?php
// doctor_dashboard.php
session_start();
include 'db.php'; // Replace with your database connection file

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch appointments for the logged-in doctor
$query = "SELECT a.id, u.username AS patient_name, a.appointment_date, a.status, a.message, a.reason FROM appointments a JOIN users u ON a.user_id = u.id WHERE a.doctor_id = ? ORDER BY a.appointment_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="project.css"> <!-- Include your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #d9534f;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: #c9302c;
        }
        h3 {
            margin-top: 30px;
            color: #555;
        }
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .appointments-table th, .appointments-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .appointments-table th {
            background-color: #f8f9fa;
            color: #333;
        }
        .appointments-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .appointments-table tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[name="action"][value="approve"] {
            background: #5cb85c;
            color: #fff;
        }
        button[name="action"][value="approve"]:hover {
            background: #4cae4c;
        }
        button[name="action"][value="cancel"] {
            background: #d9534f;
            color: #fff;
        }
        button[name="action"][value="cancel"]:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['doctor_name']; ?></h2>
        <a href="project.php" class="logout-btn">Logout</a>

        <h3>Your Appointments</h3>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($appointment = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['message']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                        <td>
                            <?php if ($appointment['status'] === 'Pending') { ?>
                                <form method="POST" action="update_appointment.php" style="display:inline;">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                    <button type="submit" name="action" value="approve">Approve</button>
                                    <button type="submit" name="action" value="cancel">Cancel</button>
                                </form>
                            <?php } else { ?>
                                <span><?php echo htmlspecialchars($appointment['status']); ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
