<?php
// Include database connection
include_once '../admin/db_connect.php';


// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Start the session at the beginning
session_start();

// Registration
if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmpassword"]) && $_POST["password"] == $_POST["confirmpassword"]) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $phonenumber = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Store the original password

    $stmt = $conn->prepare("SELECT * FROM Clients WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close(); // Close the previous statement

    if ($user) {
        echo "<script>alert('User already exists in database')</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO Clients (FirstName, LastName, Email, Password, Address, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?)");
        $address = "Avenue Habib Bourgiba 8050 Hammamet";
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $password, $address, $phonenumber);
        $stmt->execute();
        $stmt->close(); // Close the previous statement
        header("Location: ../config/login.php");
        exit(); // Add exit() to prevent further execution
    }
}


