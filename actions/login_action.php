<?php
session_start();
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://51.20.181.20/wooxtravel/");
$errors = [];

// Checks if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: " . APPURL);
    exit();
}

// Check if login button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    }

    if (empty($errors)) { // Check if $errors is empty (no errors)
        // Query to select a record from the users table using email
        $sql = "SELECT * FROM users WHERE email = '$email'";

        // Execute the query using the connection from the connection file
        $result = mysqli_query($connection, $sql);

        // Fetch the record
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password user provided against database record using the PHP method password_verify()
            if (password_verify($password, $row['userpassword'])) {
                // If verification is successful, store the user details in a session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // If login is successful, redirect to home page
                header("Location: " . APPURL);
                exit();
            } else {
                // If verification fails, provide the response
                $errors[] = "Invalid email or password.";
            }
        } else {
            // If no record found, provide response
            $errors[] = "User does not exist";
        }
    }

    // Store errors in session
    $_SESSION['login_errors'] = $errors;
    header("Location: " . APPURL . "auth/login.php");
    exit();
}

$connection->close();
?>
