<?php
session_start();
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php';
} else {
    include 'header.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Management System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f1c2e;
            color: #fff;
        }

        .hero {
            background: linear-gradient(120deg, #005bea, #00c6fb);
            text-align: center;
            padding: 80px 20px;
            color: #fff;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-in-out;
        }

        .hero p {
            font-size: 20px;
            max-width: 600px;
            margin: auto;
            animation: fadeInUp 1s ease-in-out;
        }

        .btn {
            margin-top: 30px;
            background-color: #fff;
            color: #0077cc;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0077cc;
            color: #fff;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: auto;
        }

        h2 {
            color: #00ffff;
            text-align: center;
            margin-bottom: 40px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            text-align: center;
        }

        .feature-card {
            width: 30%;
            margin: 20px 10px;
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid #444;
        }

        .feature-card i {
            font-size: 40px;
            color: #00ffff;
            margin-bottom: 10px;
        }

        .testimonials {
            background: #132030;
            border-radius: 15px;
        }

        .testimonial {
            text-align: center;
            margin: 20px auto;
            max-width: 600px;
        }

        .testimonial p {
            font-style: italic;
            color: #ccc;
        }

        .testimonial h4 {
            margin-top: 10px;
            color: #00bfff;
        }

        @media (max-width: 768px) {
            .feature-card {
                width: 100%;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero p {
                font-size: 16px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>

<!-- Hero Section -->
<div class="hero">
    <h1>🏥 Welcome to Civil Medical Care</h1>
    <p>Your trusted partner in modern, secure, and smart healthcare solutions.</p>
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
        <a href="book_appointment.php" class="btn">📅 Book Appointment</a>
    <?php else: ?>
        <a href="login.php" class="btn">📅 Book Appointment</a>
    <?php endif; ?>
</div>

<!-- Features Section -->
<div class="section">
    <h2>Why Choose Us</h2>
    <div class="features">
        <div class="feature-card">
            <i class="fas fa-notes-medical"></i>
            <h3>Online Medical Records</h3>
            <p>Access and manage your medical history securely from anywhere.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-user-md"></i>
            <h3>Expert Doctors</h3>
            <p>Consult with top professionals and specialists in all departments.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-clock"></i>
            <h3>24/7 Support</h3>
            <p>Emergency services and helpline support available around the clock.</p>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="section testimonials">
    <h2>What Our Patients Say</h2>
    <div class="testimonial">
        <p>"The booking system is so easy, and I was able to get an appointment within minutes. Excellent service!"</p>
        <h4>- Priya S.</h4>
    </div>
    <div class="testimonial">
        <p>"Doctors are very professional and polite. The entire process is transparent and smooth."</p>
        <h4>- Rahul M.</h4>
    </div>
</div>

<!-- Call to Action -->
<div class="hero" style="background: #00bfff;">
    <h1 style="color: #fff;">Ready to Take Charge of Your Health?</h1>
    <p style="color: #f0f8ff;">Join Civil Medical Care today and experience the future of healthcare!</p>
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
        <a href="book_appointment.php" class="btn">Book Now</a>
    <?php else: ?>
        <a href="register.php" class="btn">Register</a>
    <?php endif; ?>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
