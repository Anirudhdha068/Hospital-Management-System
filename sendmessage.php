<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['textmessage']);

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'anirudhdha068@gmail.com'; // 👈 Apna Gmail ID
        $mail->Password   = 'oefu slql oxgn ztco';   // 👈 App Password (Not your Gmail password!)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom($email, $name); // From user
        $mail->addAddress('anirudhdha068@gmail.com', 'HMS'); // 👈 Jis email pe message receive karna hai

        // Content
        $mail->isHTML(true);
$mail->Subject = "New Contact Message from $name";
$mail->Body = '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; background-color: #f9f9f9;">
        <h2 style="color: #007BFF; text-align: center;">📬 New Contact Form Submission</h2>
        <hr style="border-top: 1px solid #ccc;">
        <p><strong style="color: #333;">👤 Name:</strong> <span style="color: #555;">'.htmlspecialchars($name).'</span></p>
        <p><strong style="color: #333;">📧 Email:</strong> <span style="color: #555;">'.htmlspecialchars($email).'</span></p>
        <p><strong style="color: #333;">📝 Message:</strong></p>
        <p style="background-color: #fff; padding: 10px; border-radius: 5px; color: #444; border: 1px solid #ddd;">'.nl2br(htmlspecialchars($message)).'</p>
        <hr style="border-top: 1px solid #ccc;">
        <p style="font-size: 12px; text-align: center; color: #999;">This message was sent via your website contact form</p>
    </div>
';

        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='contact.php';</script>";
    }
} else {
    header("Location: contact.php");
    exit();
}
?>
