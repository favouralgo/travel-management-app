<?php
require '../../config/connection.php';

session_start(); 

// Define APPURL
define("ADMINURL", "http://localhost/wooxtravel/admin-panel/");

// Checks if admin is logged in already
if(isset($_SESSION["adminname"])){
    header("Location: ".ADMINURL."");
}

// Check if login button was clicked
if(isset($_POST['submit'])) {
    if(empty($_POST['email']) || empty($_POST['password'])){
        echo "<script>alert('Please fill in all fields');</script>"; // Login password: Test2024!; Email: favourmdev@gmail.com
    } else {
        // Collect form data and store in variables
        $adminEmail = $_POST['email'];
        $adminPassword = $_POST['password'];
        
        // Write a query to select a record from the users table using email
        $sqlAdmins = "SELECT * FROM admins WHERE email = '$adminEmail'";
                    
        // Execute the query using the connection from the connection file
        $adminResult = mysqli_query($connection, $sqlAdmins);
        
        // Fetch the record
        if (mysqli_num_rows($adminResult) > 0) {
            $adminRows = mysqli_fetch_assoc($adminResult);
            // Verify the password user provided against database record using the php method password_verify()
            if (password_verify($adminPassword, $adminRows['mypassword'])) {
                // If verification is successful, store the user details in a session
                $_SESSION['adminname'] = $adminRows['adminname'];
                $_SESSION['user_id'] = $adminRows['id'];

                // If login is successful, redirect to home page
                header("Location: ".ADMINURL."");
                exit(); // Make sure to exit after redirecting
            } else {
                // If verification fails, provide the response
                echo "<script>alert('Incorrect email or password');</script>";
            }  
        } else {
        // If no record found, provide response
        echo "<script>alert('Account not found');</script>";
        }
    }
}
?>