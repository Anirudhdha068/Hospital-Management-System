<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php'; // Show logged-in header.
} else {
    include 'header.php'; // Show default header.
}

// Database connection and fetching existing user data
require 'config.php';

$user_id = $_SESSION['user_id']; // User ID from session
$error = '';
$success = '';

if (isset($conn)) {
    $stmt = $conn->prepare('SELECT first_name, middle_name, last_name, gender, age, blood_group, mobile_number, email FROM users WHERE id=?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($first_name, $middle_name, $last_name, $gender, $age, $blood_group, $mobile_number, $email);
            $stmt->fetch();
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

<div class="d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-lg p-4 form-container" style="width: 600px;">
        <h2 class="text-center mb-4">Edit Profile</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form action="editprofileprocess.php" method="POST" id="editProfileForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label"><i class="fas fa-user"></i> First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="middle_name" class="form-label"><i class="fas fa-user"></i> Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($middle_name); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="last_name" class="form-label"><i class="fas fa-user"></i> Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="gender" class="form-label"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($gender === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="age" class="form-label"><i class="fas fa-calendar"></i> Age</label>
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" min="0" required>
                </div>
                <div class="col-md-6">
                    <label for="blood_group" class="form-label"><i class="fas fa-tint"></i> Blood Group</label>
                    <select class="form-select" id="blood_group" name="blood_group" required>
                        <option value="A+" <?php echo ($blood_group === 'A+') ? 'selected' : ''; ?>>A+</option>
                        <option value="A-" <?php echo ($blood_group === 'A-') ? 'selected' : ''; ?>>A-</option>
                        <option value="B+" <?php echo ($blood_group === 'B+') ? 'selected' : ''; ?>>B+</option>
                        <option value="B-" <?php echo ($blood_group === 'B-') ? 'selected' : ''; ?>>B-</option>
                        <option value="O+" <?php echo ($blood_group === 'O+') ? 'selected' : ''; ?>>O+</option>
                        <option value="O-" <?php echo ($blood_group === 'O-') ? 'selected' : ''; ?>>O-</option>
                        <option value="AB+" <?php echo ($blood_group === 'AB+') ? 'selected' : ''; ?>>AB+</option>
                        <option value="AB-" <?php echo ($blood_group === 'AB-') ? 'selected' : ''; ?>>AB-</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="mobile_number" class="form-label"><i class="fas fa-phone"></i> Mobile Number</label>
                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($mobile_number); ?>" pattern="[0-9]{10}" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label"><i class="fas fa-lock"></i> New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                </div>
                <div class="col-md-6">
                    <label for="confirmpassword" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Re-enter new password (optional)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="update">Update Profile</button>
        </form>
    </div>
</div>

<!-- jQuery & Validation Plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<script>
    $(document).ready(function() {
        $("#editProfileForm").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                mobile_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                password: {
                    minlength: 6
                },
                confirmpassword: {
                    minlength: 6,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                    minlength: "First name must be at least 2 characters long"
                },
                last_name: {
                    required: "Please enter your last name",
                    minlength: "Last name must be at least 2 characters long"
                },
                mobile_number: {
                    required: "Please enter your mobile number",
                    digits: "Mobile number must contain only digits",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits"
                },
                password: {
                    minlength: "Password must be at least 6 characters long"
                },
                confirmpassword: {
                    equalTo: "Passwords do not match"
                }
            },
            errorClass: "text-danger",
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>

<?php include 'footer.php'; ?>
