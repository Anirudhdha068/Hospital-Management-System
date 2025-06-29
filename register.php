<?php 
session_start();
include 'header.php'; 
?>

<div class="">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-0">
            <div class="form-container">
                <h2 class="text-center mb-4">Register</h2>
                <?php if(isset($_SESSION['signup_error']) && !empty($_SESSION['signup_error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['signup_error']; unset($_SESSION['signup_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($_SESSION['signup_success']) && !empty($_SESSION['signup_success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['signup_success']; unset($_SESSION['signup_success']); ?>
                    </div>
                <?php endif; ?>

                <form action="registerprocess.php" method="POST" id="registrationForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label"><i class="fas fa-user"></i> First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="middle_name" class="form-label"><i class="fas fa-user"></i> Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter your middle name" optional>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="last_name" class="form-label"><i class="fas fa-user"></i> Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label"><i class="fas fa-venus-mars"></i> Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" selected disabled>Select your gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="age" class="form-label"><i class="fas fa-calendar"></i> Age</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="blood_group" class="form-label"><i class="fas fa-tint"></i> Blood Group</label>
                            <select class="form-select" id="blood_group" name="blood_group" required>
                                <option value="" selected disabled>Select your blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mobile_number" class="form-label"><i class="fas fa-phone"></i> Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" pattern="[0-9]{10}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmpassword" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Re-enter your password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="signup">Register</button>
                    <p class="text-center mt-3">
                        Already have an account? <a href="login.php">Login now</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & Validation Plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<script>
    $(document).ready(function(){
        $("#registrationForm").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                middle_name: {
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                gender: {
                    required: true
                },
                age: {
                    required: true,
                    number: true,
                    min: 0
                },
                blood_group: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobile_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirmpassword: {
                    required: true,
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
                gender: {
                    required: "Please select your gender"
                },
                age: {
                    required: "Please enter your age",
                    number: "Age must be a number",
                    min: "Age cannot be negative"
                },
                blood_group: {
                    required: "Please select your blood group"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                mobile_number: {
                    required: "Please enter your mobile number",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits",
                    digits: "Mobile number must contain only digits"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters long"
                },
                confirmpassword: {
                    required: "Please confirm your password",
                    minlength: "Password must be at least 6 characters long",
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
