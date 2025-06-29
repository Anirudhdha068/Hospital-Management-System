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

// Fetch data
$totalPatients = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$totalAppointments = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc()['total'];
$todayAppointments = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE date = CURDATE()")->fetch_assoc()['total'];
$upcomingAppointments = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE date > CURDATE()")->fetch_assoc()['total'];
$totalStaff = $conn->query("SELECT COUNT(*) as total FROM staff")->fetch_assoc()['total']; // 👈 Added staff count
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            background: #0f0f0f;
            color: white;
            padding: 100px 30px 30px;
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
            color: #00d9ff;
            margin-bottom: 30px;
        }
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .card {
            background: #1c1c1c;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 10px #000;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px #00d9ff;
        }
        .card h3 {
            font-size: 22px;
            color: #00ffcc;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 28px;
            color: #fff;
        }
        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .nav-links a {
            background: #00d9ff;
            color: #000;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .nav-links a:hover {
            background: #00b2cc;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <div class="dashboard">
        <div class="card">
            <h3>Total Patients</h3>
            <p><?= $totalPatients ?></p>
        </div>
        <div class="card">
            <h3>Total Appointments</h3>
            <p><?= $totalAppointments ?></p>
        </div>
        <div class="card">
            <h3>Today’s Appointments</h3>
            <p><?= $todayAppointments ?></p>
        </div>
        <div class="card">
            <h3>Upcoming Appointments</h3>
            <p><?= $upcomingAppointments ?></p>
        </div>
        <div class="card">
            <h3>Total Staff</h3>
            <p><?= $totalStaff ?></p>
        </div>
    </div>

    <div class="nav-links">
        <a href="manage_patients.php">Manage Patients</a>
        <a href="appointments.php">Manage Appointments</a>
        <a href="manage_staff.php">Manage Staff</a> 
        <a href="today_appointments.php">Today's Appointments</a>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
