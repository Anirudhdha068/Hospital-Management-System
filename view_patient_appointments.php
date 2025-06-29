<?php
session_start();

// Admin check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'header3.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user_id from URL
if (!isset($_GET['user_id'])) {
    echo "<p style='color: red; text-align: center;'>No patient selected.</p>";
    exit();
}

$userId = intval($_GET['user_id']);

// Fetch patient info
$userStmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult->num_rows == 0) {
    echo "<p style='color: red; text-align: center;'>Patient not found.</p>";
    exit();
}
$user = $userResult->fetch_assoc();
$fullName = $user['first_name'] . ' ' . $user['last_name'];

// Fetch appointments
$stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($fullName) ?> - Appointments</title>
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
            margin-bottom: 10px;
        }
        .patient-name {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #ccc;
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
    <h2>Patient Appointments</h2>
    <div class="patient-name">Viewing appointments for: <strong><?= htmlspecialchars($fullName) ?></strong></div>

    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Department</th>
                    <th>Message</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-data">No appointments found for this patient.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
