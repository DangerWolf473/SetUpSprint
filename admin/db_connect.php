<?php
$servername = "localhost"; // Replace with your database server name if different
$username = "root";
$password = "";
$dbname = "setupsprint_ecommerce_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
