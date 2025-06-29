<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$conn = new mysqli("localhost", "root", "root", "hms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$date = $conn->real_escape_string($_POST['date']);
$department = $conn->real_escape_string($_POST['department']);
$message = $conn->real_escape_string($_POST['message']);
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO appointments (name, email, phone, appointment_date, department, message, user_id) 
        VALUES ('$name', '$email', '$phone', '$date', '$department', '$message', '$user_id')";

if ($conn->query($sql) === TRUE) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = 'Youre E-mail ID';
        $mail->Password = 'Youre PassKey';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('Youre E-Mail ID', 'Hospital Management');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Appointment Confirmation';
        $mail->Body = "
            <h3>Hi $name,</h3>
            <p>Your appointment is confirmed on <strong>$date</strong> in <strong>$department</strong>.</p>
            <p><b>Phone:</b> $phone<br><b>Message:</b> $message</p>
            <p>Thanks for choosing our hospital.</p>
        ";

        $mail->send();
        header("Location: my_appointments.php");
        exit();
    } catch (Exception $e) {
        echo "Email error: {$mail->ErrorInfo}";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
