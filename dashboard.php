<?php
session_start();
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    include 'header2.php'; // Yeh header login ke baad dikhega.
} else {
    include 'header.php'; // Yeh header login se pehle dikhega.
}
?>
<?php

if (isset($_SESSION['dashboard_message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['dashboard_message'] . "</div>";
    unset($_SESSION['dashboard_message']); // Clear the message after displaying it
}
?>



<?php
include'footer.php';
?>