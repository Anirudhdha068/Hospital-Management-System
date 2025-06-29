<?php
session_start();
require 'config.php';

$error = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (isset($conn)) {
        $stmt = $conn->prepare('SELECT id, password FROM users WHERE email=?');
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['user_logged_in'] = true; // Set login status.
                    header('Location: index.php'); // Redirect to dashboard.
                    exit();
                } else {
                    $error = 'Incorrect password!';
                }
            } else {
                $error = 'Email not found!';
            }
            $stmt->close();
        } else {
            $error = 'Database query error!';
        }
    } else {
        $error = 'Database connection error!';
    }
    $conn->close();
}

$_SESSION['signin_error'] = $error;
header("Location: login.php"); // Redirect back to login with error.
exit();
?>
