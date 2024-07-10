<?php
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");



// Checks if user is already logged in
if(isset($_SESSION['username'])){
    header("Location: ".APPURL."");
}

// Check if login button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and store in variables
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    // Write a query to select a record from the users table using email
    $sql = "SELECT * FROM users WHERE email = '$email'";
  
    // Execute the query using the connection from the connection file
    $result = mysqli_query($connection, $sql);
  
    // Fetch the record
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password user provided against database record using the php method password_verify()
        if (password_verify($password, $row['userpassword'])) {
            // If verification is successful, store the user details in a session
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            
            // If login is successful, redirect to home page
            header("Location: ".APPURL."");
        } else {
            // If verification fails, provide the response
            echo "<script>alert('Incorrect email or password');</script>";
            exit(); // Stop processing
        }
    } else {
        // If no record found, provide response
        echo "<script>alert('User not registered: Email not found');</script>";
        exit(); // Stop processing
    }

    exit();
}
?>
