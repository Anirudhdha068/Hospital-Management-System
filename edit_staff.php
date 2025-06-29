<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'header3.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $stmt = $conn->prepare("UPDATE staff SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    if ($stmt->execute()) {
        header("Location: manage_staff.php");
        exit();
    } else {
        $error = "Failed to update staff.";
    }
}

$staff = $conn->query("SELECT * FROM staff WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff</title>
    <style>
        body {
            background: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 100px 20px 30px;
        }
        h2 {
            text-align: center;
            color: #00d9ff;
            margin-bottom: 30px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: #1c1c1c;
            padding: 25px;
            border-radius: 10px;
        }
        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        form input, form select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            margin-top: 5px;
            background-color: #333;
            color: #fff;
        }
        form button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #00d9ff;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #00aacc;
        }
        .success, .error {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #28a745;
            color: #fff;
        }
        .error {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>

<h2>Edit Staff Member</h2>

<div class="form-container">
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($staff['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($staff['email']) ?>" required>

        <label>Role:</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <?php
                $roles = ['Doctor', 'Nurse', 'Receptionist', 'Lab Technician', 'Pharmacist', 'Admin Assistant'];
                foreach ($roles as $roleOption) {
                    $selected = ($staff['role'] === $roleOption) ? "selected" : "";
                    echo "<option value=\"$roleOption\" $selected>$roleOption</option>";
                }
            ?>
        </select>

        <button type="submit">Update Staff</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
