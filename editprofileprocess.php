<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id']; // User ID from session
$error = '';
$success = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $age = intval($_POST['age']);
    $blood_group = $_POST['blood_group'];
    $mobile_number = trim($_POST['mobile_number']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Validate password match if provided
    if (!empty($password) && $password !== $confirmpassword) {
        $error = 'Passwords do not match!';
    } else {
        // Begin database operations
        if (isset($conn)) {
            // Update user details
            $query = 'UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, gender = ?, age = ?, blood_group = ?, mobile_number = ?';

            // Check if password needs to be updated
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query .= ', password = ? WHERE id = ?';
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ssssisssi', $first_name, $middle_name, $last_name, $gender, $age, $blood_group, $mobile_number, $hashed_password, $user_id);
            } else {
                $query .= ' WHERE id = ?';
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ssssissi', $first_name, $middle_name, $last_name, $gender, $age, $blood_group, $mobile_number, $user_id);
            }

            if ($stmt->execute()) {
                $success = 'Profile updated successfully!';
                $_SESSION['dashboard_message'] = $success; // Set the success message for the dashboard
            } else {
                $error = 'Error updating profile. Please try again.';
            }
            $stmt->close();
        } else {
            $error = 'Database connection error!';
        }
    }

    $conn->close();
}

// Store error or success message in session
if (!empty($error)) {
    $_SESSION['edit_error'] = $error;
    header('Location: editprofile.php'); // Redirect back to edit profile in case of error
} else {
    header('Location: index.php'); // Redirect to dashboard on success
}
exit();
?>
