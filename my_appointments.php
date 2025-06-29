<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_logged_in']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'header2.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

// Deleting appointment
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $deleteId, $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: my_appointments.php");
    exit();
}

// Fetch appointments for the logged-in user
$stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <style>
        body {
            background: #111;
            color: #fff;
            padding: 100px 30px 30px;
            font-family: Arial, sans-serif;
        }
        h2 { text-align: center; color: #00d9ff; margin-bottom: 30px; }
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
            background-color: #333;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            padding: 20px;
            color: #ccc;
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
    </style>
</head>
<body>
    <h2>My Appointments</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Department</th>
                    <th>Message</th>
                    <th>Booked At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['timeslot']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="my_appointments.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Delete this appointment?')">
                                <button class="delete-btn">Delete</button>
                            </a>
                        </td>
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
