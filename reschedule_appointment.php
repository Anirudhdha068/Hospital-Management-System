<?php
session_start();
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Admin authentication
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- AJAX Time Slot Response ---
if (isset($_GET['ajax_date'])) {
    $date = $_GET['ajax_date'];
    $timeSlots = ["9:00 AM - 11:00 AM", "12:00 PM - 2:00 PM", "4:00 PM - 6:00 PM"];
    $availableSlots = [];

    foreach ($timeSlots as $slot) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE date = ? AND timeslot = ?");
        $stmt->bind_param("ss", $date, $slot);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count == 0) {
            $availableSlots[] = $slot;
        }
    }

    echo json_encode($availableSlots);
    exit();
}

// --- Normal Appointment Reschedule Form Handling ---
if (!isset($_GET['id'])) {
    header("Location: admin_manage_appointments.php");
    exit();
}

$appointmentId = intval($_GET['id']);

// Fetch existing appointment
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();
if (!$appointment) {
    echo "<p style='color:red;padding:100px;'>Appointment not found.</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newDate = $_POST['new_date'];
    $newTime = $_POST['new_time'];

    $updateStmt = $conn->prepare("UPDATE appointments SET date = ?, timeslot = ? WHERE id = ?");
    $updateStmt->bind_param("ssi", $newDate, $newTime, $appointmentId);

    if ($updateStmt->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username   = 'anirudhdha068@gmail.com';
            $mail->Password   = 'oefu slql oxgn ztco';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('pt867987@gmail.com', 'HMS Admin');
            $mail->addAddress($appointment['email'], $appointment['name']);

            $mail->isHTML(true);
            $mail->Subject = 'Your Appointment Has Been Rescheduled';
            $mail->Body = "
                <h3>Dear {$appointment['name']},</h3>
                <p>Your appointment has been rescheduled to <strong>{$newDate}</strong> at <strong>{$newTime}</strong>.</p>
                <p>If you have any questions, please contact us.</p>
                <br><p>Regards,<br>HMS Team</p>
            ";
            $mail->AltBody = "Dear {$appointment['name']},\n\nYour appointment has been rescheduled to {$newDate} at {$newTime}.\n\nRegards,\nHMS Team";

            $mail->send();
        } catch (Exception $e) {
            echo "<script>alert('Email sending failed: {$mail->ErrorInfo}');</script>";
        }

        echo "<script>alert('Appointment rescheduled successfully. Email sent!'); window.location='appointments.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating appointment. Try again.');</script>";
    }
}
?>

<?php include('header3.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Reschedule Appointment</title>
    <style>
        body {
            background: #111;
            color: #fff;
            font-family: Arial;
            padding: 100px 30px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #00d9ff;
        }
        label {
            display: block;
            margin-bottom: 10px;
            margin-top: 20px;
            color: #00ffcc;
        }
        input[type="date"], select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background: #333;
            color: #fff;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #00d9ff;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #00aacc;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #ccc;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Reschedule Appointment</h2>
    <p><strong>User:</strong> <?= htmlspecialchars($appointment['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($appointment['email']) ?></p>
    <p><strong>Current Date:</strong> <?= htmlspecialchars($appointment['date']) ?></p>
    <p><strong>Current Time Slot:</strong> <?= htmlspecialchars($appointment['timeslot']) ?></p>

    <form method="POST">
        <label for="new_date">Select New Date:</label>
        <input type="date" name="new_date" id="new_date" required min="<?= date('Y-m-d') ?>">

        <label for="new_time">Select New Time Slot:</label>
        <select name="new_time" id="new_time" required>
            <option value="">Select a Time Slot</option>
        </select>

        <button type="submit">Save New Date and Time</button>
    </form>

    <div class="back-link">
        <a href="appointments.php">← Back to Appointments</a>
    </div>
</div>

<script>
    document.getElementById('new_date').addEventListener('change', function () {
        const date = this.value;
        const timeDropdown = document.getElementById('new_time');
        timeDropdown.innerHTML = '<option>Loading...</option>';

        fetch(`reschedule_appointment.php?ajax_date=${date}`)
            .then(response => response.json())
            .then(slots => {
                timeDropdown.innerHTML = '<option value="">Select a Time Slot</option>';
                if (slots.length === 0) {
                    timeDropdown.innerHTML += '<option disabled>No slots available</option>';
                } else {
                    slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeDropdown.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                timeDropdown.innerHTML = '<option disabled>Error loading slots</option>';
            });
    });
</script>

</body>
</html>

<?php include('footer.php'); ?>
