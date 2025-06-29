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

// Fetch all patients
$result = $conn->query("SELECT id, first_name, last_name, email, mobile_number, created_at FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Patients</title>
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
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .view-btn {
            background-color: #00bcd4;
        }
        .view-btn:hover {
            background-color: #0097a7;
        }
        .delete-btn {
            background-color: #ff4d4d;
        }
        .delete-btn:hover {
            background-color: #e60000;
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
    <h2>Manage Patients</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile_number']) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="view_patient_appointments.php?user_id=<?= $row['id'] ?>">
                            <button class="btn view-btn">View Appointments</button>
                        </a>
                        <!-- Optional delete button -->
                        <!--
                        <a href="delete_patient.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this patient?')">
                            <button class="btn delete-btn">Delete</button>
                        </a>
                        -->
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-data">No patients found.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
