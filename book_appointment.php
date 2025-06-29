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

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php';
} else {
    include 'header.php';
}

// AJAX: Get available slots based on date and department
if (isset($_POST['fetch_slots'])) {
    $date = $_POST['date'];
    $department = $_POST['department'];
    $slots = ["9:00 AM - 11:00 AM", "12:00 PM - 2:00 PM", "4:00 PM - 6:00 PM"];
    $available = [];

    foreach ($slots as $slot) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE date = ? AND department = ? AND timeslot = ?");
        $stmt->bind_param("sss", $date, $department, $slot);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result['total'] < 3) {
            $available[] = $slot;
        }
    }

    foreach ($available as $slot) {
        echo "<option value=\"$slot\">$slot</option>";
    }
    if (empty($available)) {
        echo "<option value=\"\">No slots available</option>";
    }
    exit;
}

// Handle appointment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_appointment'])) {
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $date       = $_POST['date'];
    $timeslot   = $_POST['timeslot'];
    $department = $_POST['department'];
    $message    = $_POST['message'];
    $userId     = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE date = ? AND timeslot = ? AND department = ?");
    $stmt->bind_param("sss", $date, $timeslot, $department);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] >= 2) {
        echo "<script>alert('This slot is full. Please choose another.');</script>";
    } else {
        $insert = $conn->prepare("INSERT INTO appointments (user_id, name, email, phone, date, timeslot, department, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("isssssss", $userId, $name, $email, $phone, $date, $timeslot, $department, $message);
        if ($insert->execute()) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'anirudhdha068@gmail.com';
                $mail->Password   = 'oefu slql oxgn ztco';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('anirudhdha00@gmail.com', 'Hospital Management');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = "Appointment Confirmation - HMS";
                $mail->Body    = "
                    <h3>Dear $name,</h3>
                    <p>Your appointment has been successfully booked.</p>
                    <p><strong>Date:</strong> $date<br>
                    <strong>Time Slot:</strong> $timeslot<br>
                    <strong>Department:</strong> $department</p>
                    <p>Thank you for using our system.</p>
                    <br><p>Regards,<br>HMS Team</p>
                ";
                $mail->send();
                echo "<script>alert('Appointment booked & confirmation email sent!');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Booked but email failed to send.');</script>";
            }
        } else {
            echo "<script>alert('Error booking appointment.');</script>";
        }
    }
}
?>

<!-- ===== HTML FORM ===== -->
<div class="container mt-5 mb-5">
    <h2 class="text-center">Book Appointment</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name:</label>
                <input type="text" name="name" required class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
                <label>Email:</label>
                <input type="email" name="email" required class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone:</label>
                <input type="text" name="phone" required class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
                <label>Date:</label>
                <input type="date" name="date" id="appointment_date" required class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
                <label>Department:</label>
                <select name="department" id="department" class="form-control" required disabled>
                    <option value="">-- Select Department --</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="ENT">ENT</option>
                    <option value="Dermatology">Dermatology</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Time Slot:</label>
                <select name="timeslot" id="timeslot" class="form-control" required disabled>
                    <option value="">-- Select Time Slot --</option>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label>Message:</label>
                <textarea name="message" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" name="submit_appointment" class="btn btn-primary">Book Appointment</button>
            </div>
        </div>
    </form>
</div>

<!-- ===== JS for dynamic dropdowns ===== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#appointment_date').on('change', function () {
        $('#department').prop('disabled', false);
    });

    $('#department').on('change', function () {
        const date = $('#appointment_date').val();
        const department = $(this).val();

        if (date !== "" && department !== "") {
            $('#timeslot').prop('disabled', false);
            $.ajax({
                type: "POST",
                url: "book_appointment.php",
                data: {
                    fetch_slots: true,
                    date: date,
                    department: department
                },
                success: function (response) {
                    $('#timeslot').html(response);
                }
            });
        }
    });
</script>

<?php include 'footer.php'; ?>
