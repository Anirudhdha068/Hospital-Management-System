<?php
session_start();

// Admin authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'header3.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$today = date('Y-m-d');

// Fetch today’s appointments
$query = "
    SELECT a.*, name AS user_name, u.email, phone 
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    WHERE a.date = '$today'
    ORDER BY a.timeslot
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Today's Appointments</title>
    <style>
        body {
            background: #111;
            color: #fff;
            padding: 100px 30px 30px;
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
            color: #00d9ff;
            margin-bottom: 30px;
        }
        .table-container {
            background: #1c1c1c;
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #444;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #00ffcc;
        }
        tr:hover {
            background-color: #2c2c2c;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            padding: 20px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <h2>Today's Appointments</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
        <thead>
    <tr>
        <th>#</th>
        <th>User Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Time Slot</th>
        <th>Department</th>
        <th>Message</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php 
    $count = 1;
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= $count++; ?></td>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['timeslot']) ?></td>
        <td><?= htmlspecialchars($row['department']) ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td>
            <a href="reschedule_appointment.php?id=<?= $row['id'] ?>" 
               style="padding: 6px 12px; background: #00d9ff; color: #000; border-radius: 5px; text-decoration: none;">
               Reschedule
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>

        </table>
        <?php else: ?>
        <div class="no-data">No appointments found for today.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
