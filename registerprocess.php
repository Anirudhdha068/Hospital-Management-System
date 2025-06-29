<?php 
session_start();
require 'config.php';

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $age = intval($_POST['age']);
    $blood_group = $_POST['blood_group'];
    $mobile_number = trim($_POST['mobile_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Validate password match
    if ($password !== $confirmpassword) {
        $error = "Passwords do not match!";
    } else {
        // Check if the email or mobile number already exists
        $query = $conn->prepare("SELECT id FROM users WHERE email=? OR mobile_number=?");
        $query->bind_param('ss', $email, $mobile_number);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $error = "Email or mobile number is already taken!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user record
            $insert = $conn->prepare(
                "INSERT INTO users (first_name, middle_name, last_name, gender, age, blood_group, mobile_number, email, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $insert->bind_param(
                "ssssissss",
                $first_name,
                $middle_name,
                $last_name,
                $gender,
                $age,
                $blood_group,
                $mobile_number,
                $email,
                $hashed_password
            );

            if ($insert->execute()) {
                $success = "Sign-up successful! You can now <a href='login.php'>Sign in</a>.";
            } else {
                $error = "An error occurred. Please try again.";
            }

            $insert->close();
        }

        $query->close();
    }

    $conn->close();

    $_SESSION['signup_error'] = $error;
    $_SESSION['signup_success'] = $success;

    header("Location: register.php");
    exit();
}
?>
