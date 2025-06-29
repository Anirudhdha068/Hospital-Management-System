<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'header3.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $stmt = $conn->prepare("INSERT INTO staff (name, email, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $role);
    if ($stmt->execute()) {
        header("Location: manage_staff.php");
        exit();
    } else {
        $error = "Failed to add staff. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
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
        label.error {
    color: #ff4d4d;
    margin-top: 5px;
    font-size: 14px;
    display: block;
}

input.error, select.error, textarea.error {
    /* Remove red background and border */
    background-color: inherit !important;
    border: 1px solid #ccc !important;
    color: #fff;
}

    </style>
</head>
<body>

<h2>Add Staff</h2>

<div class="form-container">
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Role:</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="Doctor">Doctor</option>
            <option value="Nurse">Nurse</option>
            <option value="Receptionist">Receptionist</option>
            <option value="Lab Technician">Lab Technician</option>
            <option value="Pharmacist">Pharmacist</option>
            <option value="Admin Assistant">Admin Assistant</option>
        </select>

        <button type="submit">Add Staff</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<script>
$(document).ready(function () {
    $("form").validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            role: "required"
        },
        messages: {
            name: "Please enter the name",
            email: {
                required: "Please enter the email",
                email: "Enter a valid email"
            },
            role: "Please select a role"
        },
        errorClass: "text-danger",
            submitHandler: function(form) {
                form.submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
