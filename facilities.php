<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php';
} else {
    include 'header.php';
}
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Facilities - Hospital Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 60px 20px;
    }

    h2.section-title {
        font-size: 36px;
        text-align: center;
        color: #00e6e6;
        margin-bottom: 20px;
    }

    .section-subtitle {
        text-align: center;
        color: #ccc;
        margin-bottom: 50px;
        font-size: 18px;
    }

    .facility-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .facility-card {
        flex: 1 1 calc(33.333% - 30px);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 20px;
        margin: 15px;
        text-align: center;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .facility-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 35px rgba(0, 255, 255, 0.2);
    }

    .facility-card img {
        max-width: 100px;
        margin-bottom: 15px;
    }

    .facility-card h3 {
        color: #00ffff;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .facility-card p {
        color: #ddd;
        font-size: 15px;
    }


    @media (max-width: 992px) {
        .facility-card {
            flex: 1 1 45%;
        }
    }

    @media (max-width: 600px) {
        .facility-card {
            flex: 1 1 100%;
        }
        h2.section-title {
            font-size: 28px;
        }
    }
</style>

</head>
<body><div class="container">
    <h2 class="section-title"><i class="fas fa-hospital-user"></i> Our Facilities</h2>
    <p class="section-subtitle">Experience world-class healthcare infrastructure with our specialized departments and expert teams</p><div class="facility-section">

    <div class="facility-card">
        <img src="img/emergency.png" alt="Emergency Services">
        <h3><i class="fas fa-ambulance"></i> Emergency Services</h3>
        <p>24/7 emergency care with highly trained staff, ready for critical cases and urgent medical needs.</p>
    </div>

    <div class="facility-card">
        <img src="img/icu.png" alt="Intensive Care Unit">
        <h3><i class="fas fa-procedures"></i> ICU</h3>
        <p>State-of-the-art ICU with continuous monitoring and advanced life support equipment.</p>
    </div>

    <div class="facility-card">
        <img src="img/maternity.png" alt="Maternity Ward">
        <h3><i class="fas fa-baby"></i> Maternity Ward</h3>
        <p>Modern maternity ward offering complete prenatal, delivery, and postnatal care for mothers and newborns.</p>
    </div>

    <div class="facility-card">
        <img src="img/surgery.png" alt="Surgery Department">
        <h3><i class="fas fa-user-md"></i> Surgical Facilities</h3>
        <p>Equipped operating theatres and top surgeons ensure safe and efficient surgical procedures.</p>
    </div>

    <div class="facility-card">
        <img src="img/diagnostics_facility.jfif" alt="Diagnostics">
        <h3><i class="fas fa-x-ray"></i> Diagnostic Services</h3>
        <p>In-house imaging (MRI, CT, X-Ray) and lab tests for timely and precise diagnosis.</p>
    </div>

    <div class="facility-card">
        <img src="img/rehabilitation.jfif" alt="Rehab Center">
        <h3><i class="fas fa-dumbbell"></i> Rehabilitation Center</h3>
        <p>Specialized therapies and recovery programs for injury, surgery, or chronic illness.</p>
    </div>

    <div class="facility-card">
        <img src="img/gc.jpg" alt="General Consultation">
        <h3><i class="fas fa-user-check"></i> General Consultation</h3>
        <p>Meet our experienced general physicians for routine health checkups and primary care guidance.</p>
    </div>

    <div class="facility-card">
        <img src="img/dental.jpg" alt="Dental Treatment">
        <h3><i class="fas fa-tooth"></i> Dental Treatment</h3>
        <p>Comprehensive dental services including cleaning, fillings, root canals, and orthodontics.</p>
    </div>

    <div class="facility-card">
        <img src="img/lab.jpg" alt="Lab Test">
        <h3><i class="fas fa-vials"></i> Lab Test</h3>
        <p>Accurate and fast testing services with automated lab equipment and expert technicians.</p>
    </div>

    <div class="facility-card">
        <img src="img/x-ray.jpg" alt="X-Ray">
        <h3><i class="fas fa-x-ray"></i> X-Ray</h3>
        <p>Advanced X-Ray imaging for quick and safe internal diagnostics and analysis.</p>
    </div>

    <div class="facility-card">
        <img src="img/physio.jpg" alt="Physiotherapy">
        <h3><i class="fas fa-walking"></i> Physiotherapy</h3>
        <p>Restorative physical therapy to enhance movement, strength, and recovery from injury.</p>
    </div>

</div>

</div></body>
</html>
<?php
include 'footer.php';
?>