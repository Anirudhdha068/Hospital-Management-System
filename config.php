<?php
$host="localhost";
$username="root";
$password="root";
$dbname="hms";
//create mysqli object
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
    // echo "Connected Successfully";
}
?>
