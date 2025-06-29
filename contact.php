<?php
session_start();
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php'; // Yeh header login ke baad dikhega.
} else {
    include 'header.php'; // Yeh header login se pehle dikhega.
}
?>
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4 form-container" style="width: 450px;">
        <h1 class="text-center mb-4">Contact Us</h1>
        <form action="sendmessage.php" method="post" id="contactForm">
            <div class="mb-3">
                <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required minlength="3">
            </div>
            <div class="mb-3">

                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="textmessage" class="form-label"><i class="fas fa-comment"></i> Message</label>
                <textarea class="form-control" id="textmessage" name="textmessage" placeholder="Enter your message" required minlength="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</div>

<!-- jQuery and jQuery Validation Plugin -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<script>
    $(document).ready(function(){
        $("#contactForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true // Disable HTML validation
                },
                textmessage: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 3 characters long"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                textmessage: {
                    required: "Please enter your message",
                    minlength: "Message must be at least 10 characters long"
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