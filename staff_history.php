<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'header3.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the "leave" action (Mark as Left)
if (isset($_GET['action']) && $_GET['action'] == 'leave' && isset($_GET['id'])) {
    $staffId = intval($_GET['id']);
    $stmt = $conn->prepare("UPDATE staff SET status = 'left' WHERE id = ?");
    $stmt->bind_param("i", $staffId);
    $stmt->execute();
    $stmt->close();
    header("Location: staff_history.php");  // Redirect back to history after action
    exit();
}

// Handle reactivating the staff
if (isset($_GET['action']) && $_GET['action'] == 'reactivate' && isset($_GET['id'])) {
    $staffId = intval($_GET['id']);
    $stmt = $conn->prepare("UPDATE staff SET status = 'active' WHERE id = ?");
    $stmt->bind_param("i", $staffId);
    $stmt->execute();
    $stmt->close();
    header("Location: staff_history.php");  // Redirect back to history after action
    exit();
}

// Fetch left staff members
$result = $conn->query("SELECT * FROM staff WHERE status = 'left' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff History</title>
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
        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .edit-btn {
            background-color: #00cc66;
            color: #fff;
        }
        .delete-btn {
            background-color: #ff4d4d;
            color: #fff;
        }
        .leave-btn {
            background-color: #ffcc00;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Staff History (Left Staff)</h2>

    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="staff_history.php?action=reactivate&id=<?= $row['id'] ?>">
                            <button class="btn edit-btn">Reactivate</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-data">No staff have left.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
