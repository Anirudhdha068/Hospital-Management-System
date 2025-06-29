<?php 
session_start();
include 'header.php'; 
?>


<div class="d-flex justify-content-center align-items-center ">
    <div class="card shadow-lg p-4 form-container" style="width: 450px;">
        <h2 class="text-center mb-4">Login</h2>



        <form id="loginForm" action="loginprocess.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required> <!-- Changed type to text -->
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            <p class="text-center mt-3">
                <a href="forgotpassword.php">Forgot Password?</a>
            </p>
        </form>
    </div>
</div>

<!-- jQuery and jQuery Validation Plugin -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<script>
    $(document).ready(function(){
        $("#loginForm").validate({
            rules:{
                email: {
                    required: true,
                    email: false // Disable HTML validation
                },
                password:{
                    required: true,
                    minlength: 6
                }  
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters long"
                }
            },
            errorClass: "text-danger",
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

<?php include 'footer.php'; ?>


