<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'setupsprint_ecommerce_website';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        header("Location: ../pages/signinPage.php");
        exit(); // Add exit() to prevent further execution
    }
}

// Login
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $input_password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM Clients WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close(); // Close the previous statement

    if ($user) {
        if ($input_password == $user['Password']) { // Verify the password
            // Login successful, redirect to dashboard
            session_start();
            $_SESSION["email"] = $email;
            header("Location: ../pages/profilePage.php");
            exit(); // Add exit() to prevent further execution
        } else {
            echo "<script>alert('Invalid password')</script>";
        }
    } else {
        echo "<script>alert('User not found')</script>";
    }
}

// Close connection
$conn->close();
?>
