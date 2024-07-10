<?php
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");

// Checks if user is already logged in
if(isset($_SESSION['username'])){
    header("Location: ".APPURL."");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert the new user into the database
    $reg_sql = "INSERT INTO users (username, email, userpassword) VALUES ('$username', '$email', '$hashed_password')";

    // Verify if user already exists
    $email_exists = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $email_exists);

    if(mysqli_num_rows($result) > 0){
        echo "User already exists";
        exit();
    }

    // Execute the insertion query
    if(mysqli_query($connection, $reg_sql)){
        header("Location: ../auth/login.php");
        exit();
    } else {
        echo "Error: " . $reg_sql . "<br>" . $connection->error;
    }
}
?>
