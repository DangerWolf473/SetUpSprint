<?php
session_start();

// Check if user is not already logged in
if (!isset($_SESSION["userFname"])) {
    include '../includes/database.php'; // Include database connection

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // admin login credentials
        if ($email == "admin@gmail.com") {
            header('Location:../admin/adminDashboard.php');
            exit();
        }

        // Query to fetch user by email and password
        $query = 'SELECT * FROM clients WHERE Email = ? AND Password = ?';
        $statement = $connect->prepare($query);
        $statement->execute([$email, $password]);

        // Check if user exists
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            // Set session variables
            $_SESSION["userFname"] = $user['FirstName'];
            $_SESSION["userLname"] = $user['LastName'];
            $_SESSION["email"] = $user['Email'];
            $_SESSION["phone"] = $user['PhoneNumber'];
            $_SESSION["address"] = $user['Address'];
            $_SESSION["ClientID"] = $user['ClientID'];
            header('Location:../pages/profilePage.php');
            exit();
        } else {
            // Incorrect email or password
            echo "<script>alert('Incorrect email or password')</script>";
            header('location: ../pages/signinPage.php');
            exit();
        }
    }
} else {
    // Redirect if user is already logged in
    header('location:../pages/profilePage.php');
    exit();
}
?>
