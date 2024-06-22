<?php 
session_start();

if (isset($_SESSION["userFname"])) {
    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to the home page
    header("Location: ../homePage.php");
    exit(); // Ensure that no further code is executed after redirection
} else {
    // If session variable "userFname" is not set, handle the situation accordingly
    // For example, redirect to an error page or handle the logic as per your application's requirements
    header("Location: ../homePage.php"); // Redirect to home page if session variable is not set
    exit();
}
?>
