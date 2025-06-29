<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

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

$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? '';
    $treatment = isset($_POST['treatment']) ? (is_array($_POST['treatment']) ? implode(', ', $_POST['treatment']) : $_POST['treatment']) : '';
    $amount = $_POST['amount'] ?? '';
    $razorpay_payment_id = $_POST['razorpay_payment_id'] ?? null;

    $stmt = $conn->prepare("SELECT first_name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $stmt->bind_result($full_name, $email);
    $stmt->fetch();
    $stmt->close();

    if ($email && $full_name) {
        $stmt2 = $conn->prepare("INSERT INTO billing (patient_id, services, amount, razorpay_payment_id, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt2->bind_param("isds", $patient_id, $treatment, $amount, $razorpay_payment_id);

        if ($stmt2->execute()) {
            $stmt2->close();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Youre E-mail ID';
                $mail->Password = 'Youre PassKey';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('Youre E-mail ID', 'Hospital Management');
                $mail->addAddress($email, $full_name);

                $mail->isHTML(true);
                $mail->Subject = 'Your Hospital Bill';
                $mail->Body = "
                    <h3>Dear $full_name,</h3>
                    <p>Thank you for using our hospital services.</p>
                    <p><strong>Treatment(s):</strong> $treatment</p>
                    <p><strong>Total Amount:</strong> ₹$amount</p>
                    <br><p>Payment ID: $razorpay_payment_id</p>
                    <br><p>Regards,<br>Hospital Management System</p>
                ";
                $mail->send();
                $success = "Billing completed and email sent to $email.";
            } catch (Exception $e) {
                $error = "Billing saved but email failed. Error: " . $mail->ErrorInfo;
            }
        } else {
            $error = "Failed to save billing info.";
        }
    } else {
        $error = "Invalid patient ID. Patient not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Bill</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .billing-form {
            background: #1e1e1e;
            padding: 40px;
            border-radius: 16px;
            max-width: 700px;
            margin: auto;
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        .billing-form h2 {
            text-align: center;
            color: #00d9ff;
            margin-bottom: 25px;
        }
        .billing-form label {
            font-weight: bold;
            margin-top: 20px;
            display: block;
        }
        .billing-form select,
        .billing-form input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #444;
            background: #2e2e2e;
            color: #fff;
            border-radius: 8px;
            margin-top: 8px;
        }
        .treatments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-top: 15px;
        }
        .treatment-card {
            display: flex;
            align-items: center;
            background: #2a2a2a;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #444;
            transition: 0.3s ease;
            cursor: pointer;
        }
        .treatment-card:hover {
            background: #3a3a3a;
        }
        .treatment-card input[type="checkbox"] {
            margin-right: 12px;
            transform: scale(1.2);
            accent-color: #00d9ff;
        }
        .billing-form button {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            background: #00d9ff;
            color: #000;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .billing-form button:hover {
            background: #00b8e6;
        }
        .success, .error {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #28a745;
        }
        .error {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="billing-form">
    <h2>Generate Bill</h2>

    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <form id="billingForm" method="post">
        <label for="patient_id">Select Patient:</label>
        <select name="patient_id" id="patient_id" required>
            <option value="">-- Select Patient --</option>
            <?php
            $result = $conn->query("SELECT id, first_name FROM users");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['first_name']} (ID: {$row['id']})</option>";
            }
            ?>
        </select>

        <label>Select Treatments:</label>
        <div class="treatments-grid">
            <?php
            $treatments = [
                "General Consultation",
                "Surgery",
                "Dental Treatment",
                "Lab Test",
                "X-Ray",
                "Physiotherapy",
                "Emergency Services",
                "Maternity Treatment",
                "Diagnostic Service",
                "Rehabilitation Treatment"
            ];
            foreach ($treatments as $item) {
                echo "<label class='treatment-card'><input type='checkbox' name='treatment[]' value='$item'> $item</label>";
            }
            ?>
        </div>

        <label for="amount">Amount (₹):</label>
        <input type="number" step="0.01" name="amount" id="amount" required>
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <button type="button" onclick="payNow()">Pay & Generate Bill</button>
    </form>
</div>

<script>
    const treatmentPrices = {
        "General Consultation": 300,
        "Surgery": 5000,
        "Dental Treatment": 800,
        "Lab Test": 600,
        "X-Ray": 400,
        "Physiotherapy": 700,
        "Emergency Services": 1500,
        "Maternity Treatment":5000,
        "Diagnostic Service":3000,
        "Rehabilitation Treatment":5500
    };

    const checkboxes = document.querySelectorAll('input[name="treatment[]"]');
    const amountInput = document.getElementById('amount');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) total += treatmentPrices[cb.value];
            });
            amountInput.value = total;
        });
    });

    function payNow() {
        const amount = parseFloat(amountInput.value);
        const patientSelect = document.getElementById("patient_id");
        if (!patientSelect.value) {
            alert("Please select a patient.");
            return;
        }
        if (amount <= 0 || isNaN(amount)) {
            alert("Please select treatments.");
            return;
        }

        const options = {
            key: "rzp_test_FUijwPsI1t6dUR", //Razorpay Key ID
            amount: amount * 100,
            currency: "INR",
            name: "Hospital Management",
            description: "Bill Payment",
            handler: function (response) {
                document.getElementById("razorpay_payment_id").value = response.razorpay_payment_id;
                document.getElementById("billingForm").submit();
            },
            theme: { color: "#00d9ff" }
        };
        const rzp = new Razorpay(options);
        rzp.open();
    }
</script>
</body>
</html>
<?PHP include "footer.php" ?>
