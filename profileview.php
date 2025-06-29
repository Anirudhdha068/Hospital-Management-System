<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Include header
include 'header2.php';

// Database connection and fetching user data
require 'config.php';

$user_id = $_SESSION['user_id']; // User ID from session
$error = '';

if (isset($conn)) {
    $stmt = $conn->prepare('SELECT first_name, middle_name, last_name, gender, age, blood_group, mobile_number, email FROM users WHERE id=?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($first_name, $middle_name, $last_name, $gender, $age, $blood_group, $mobile_number, $email);
            $stmt->fetch();
            $full_name = trim($first_name . ' ' . $middle_name . ' ' . $last_name); // Combine full name
        } else {
            $error = 'User not found!';
        }
        $stmt->close();
    } else {
        $error = 'Database query error!';
    }
} else {
    $error = 'Database connection error!';
}
?>

<div class="">
    <div class="row justify-content-center">
        <div class=" ">
            <div class="card shadow-lg p-4 form-container">
                <h2 class="text-center mb-4">My Profile</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php else: ?>
                    <!-- Display Profile Fields in Two Columns -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Full Name:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($full_name); ?></p>
                            </div>
                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Gender:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($gender); ?></p>
                            </div>
                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Blood Group:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($blood_group); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Email:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($email); ?></p>
                            </div>
                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Age:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($age) . ' years'; ?></p>
                            </div>

                            <div class="mb-3 p-3 border rounded bg-dark text-white">
                                <strong>Mobile Number:</strong>
                                <p class="mb-0"><?php echo htmlspecialchars($mobile_number); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Button -->
                    <div class="text-center mt-4">
                        <a href="editprofile.php" class="btn btn-primary btn-lg">Edit Profile</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
