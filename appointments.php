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

// Delete appointment logic
// if (isset($_GET['delete_id'])) {
//     $deleteId = intval($_GET['delete_id']);
//     $conn->query("DELETE FROM appointments WHERE id = $deleteId");
//     header("Location: appointments.php");
//     exit();
// }

// Reschedule appointment date logic
if (isset($_POST['reschedule_btn']) && isset($_POST['appointment_id']) && isset($_POST['new_date'])) {
    $appointmentId = intval($_POST['appointment_id']);
    $newDate = $_POST['new_date'];

    $stmt = $conn->prepare("UPDATE appointments SET date = ? WHERE id = ?");
    $stmt->bind_param("si", $newDate, $appointmentId);
    $stmt->execute();

    header("Location: appointments.php");
    exit();
}

// Get all appointments with user names
$query = "
    SELECT a.*, name AS user_name 
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    ORDER BY a.date DESC
";
$result = $conn->query($query);

// Get reschedule_id from URL
$rescheduleId = isset($_GET['reschedule_id']) ? intval($_GET['reschedule_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments - Admin</title>
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
        .delete-btn {
            padding: 6px 12px;
            background-color: #ff4d4d;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
        .reschedule-btn {
            padding: 6px 12px;
            background-color: #00cc66;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .reschedule-btn:hover {
            background-color: #00994d;
        }
        .cancel-btn {
            padding: 6px 12px;
            background-color: gray;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-btn:hover {
            background-color: #777;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            padding: 20px;
            color: #ccc;
        }
        input[type="date"] {
            padding: 6px;
            border-radius: 5px;
            border: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Manage All Appointments</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Department</th>
                    <th>Message</th>
                    <th>Booked At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>

                    <?php if ($rescheduleId == $row['id']): ?>
                    <!-- Reschedule Mode -->
                    <form method="POST" action="">
                        <td>
                            <input type="date" name="new_date" value="<?= htmlspecialchars($row['date']) ?>" required>
                        </td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                        <td>
                            <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="reschedule_btn" class="reschedule-btn">Save</button>
                            <a href="appointments.php" class="cancel-btn">Cancel</a>
                        </td>
                    </form>
                    <?php else: ?>
                    <!-- Normal View Mode -->
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['timeslot']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                    <td>
                    <a href="reschedule_appointment.php?id=<?= $row['id'] ?>">
                        <button class="delete-btn" style="background-color:#00ccff;">Reschedule</button>
                    </a>

                        <!-- <a href="appointments.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Delete this appointment?')">
                            <button class="delete-btn">Delete</button>
                        </a> -->
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-data">No appointments found.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
