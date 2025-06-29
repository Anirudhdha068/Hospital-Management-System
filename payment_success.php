<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "hms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$razorpay_payment_id = $_POST['razorpay_payment_id'];

if (isset($_SESSION['last_billing_id'])) {
    $billing_id = $_SESSION['last_billing_id'];

    $stmt = $conn->prepare("UPDATE billing SET razorpay_payment_id = ? WHERE id = ?");
    $stmt->bind_param("si", $razorpay_payment_id, $billing_id);
    $stmt->execute();
    $stmt->close();

    echo "Payment successful. Payment ID saved.";
} else {
    echo "Session expired or billing ID not found.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body {
            background: #f0fff0;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 100px;
            color: #2c662d;
        }
        .success-box {
            background-color: #d4edda;
            padding: 40px;
            margin: auto;
            width: 50%;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h1>Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction has been completed successfully.</p>
        <a href="billing.php">Go Back to Billing</a>
    </div>
</body>
</html>