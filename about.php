<?php
session_start();
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php'; // Header for logged-in users
} else {
    include 'header.php';  // Header for guests
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hospital Management System</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome for icons (optional, adds flair) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="about-container container">
        <h2><i class="fas fa-hospital icon-bullet"></i> About Our Hospital Management System</h2>
        
        <p>
            Our <span class="highlight">Hospital Management System (HMS)</span> is a powerful, all-in-one platform that transforms the way hospitals and clinics operate.  
            It streamlines <span class="highlight">patient management</span>, <span class="highlight">medical record keeping</span>, <span class="highlight">appointment scheduling</span>, and <span class="highlight">billing</span>, ensuring efficient and high-quality healthcare services.
        </p>

        <p>
            The system offers a secure <span class="highlight">cloud-based infrastructure</span>, allowing doctors, nurses, and administrators to access real-time data with ease.  
            Our <span class="highlight">AI-driven analytics</span> provide valuable insights, helping hospitals improve patient care and operational efficiency.
        </p>

        <p>
            Whether managing small clinics or large multi-specialty hospitals, our HMS is designed to adapt and scale.  
            By reducing manual paperwork, automating administrative tasks, and enhancing communication, we enable healthcare professionals to focus on what truly matters—<strong>saving lives</strong>.
        </p>

        <p>
            Experience a smarter way to manage healthcare with our state-of-the-art Hospital Management System!
        </p>
    </div>

<?php
include 'footer.php'
?>
</body>
</html>
