<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the email or display 'Guest'
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest';
$firstLetter = strtoupper($email[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* Custom styles to make the dropdown background black and text white */
        .dropdown-menu {
            background-color: black; /* Background color for dropdown */
        }

        .dropdown-menu .dropdown-item {
            color: white; /* Text color for dropdown items */
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: grey; /* Hover effect for dropdown items */
        }
    </style>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgb(1, 7, 136);">
<div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand logo" href="#">Hospital Management System</a>

        <!-- Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
         
            <ul class="navbar-nav ms-auto"> <!-- Added "ms-auto" to align links to the right -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book_appointment.php">Book Appoinment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_appointments.php">My Appoinment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
         

            <!-- Profile Dropdown -->
            <div class="dropdown ms-auto">
                <button class="btn btn-light dropdown-toggle avatar" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- Show the first letter of the logged-in user's email -->
                    <?php echo $firstLetter; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="profileview.php">My Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    
                </ul>
            </div>
        </div>
    </div>
</nav>
</header>
</body>
</html>
