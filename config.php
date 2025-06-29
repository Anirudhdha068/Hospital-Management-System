<!-- in my Sql perform following steps 
1. create database "hms"
command-: create database auth;
2.Create table "users" with Query 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
) -->
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