<?php
session_start();
require '../../config/connection.php';

// Define APPURL
define("ADMINURL", "http://localhost/wooxtravel/admin-panel/");
$errors = [];

// Check if admin is logged in already
if (isset($_SESSION["adminname"])) {
    header("Location: " . ADMINURL);
    exit();
}

// Check if login button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and retrieve form data
    $adminEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $adminPassword = $_POST['password'];

    // Validate input
    if (empty($adminEmail) || empty($adminPassword)) {
        $errors[] = "Email and password are required.";
    }

    if (empty($errors)) {
        // Use prepared statements to prevent SQL Injection
        $stmt = $connection->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $adminEmail);
        $stmt->execute();
        $adminResult = $stmt->get_result();

        if ($adminResult->num_rows > 0) {
            $adminRows = $adminResult->fetch_assoc();
            // Verify the password user provided against database record
            if (password_verify($adminPassword, $adminRows['mypassword'])) {
                // If verification is successful, store the user details in a session
                $_SESSION['adminname'] = $adminRows['adminname'];
                $_SESSION['user_id'] = $adminRows['id'];

                // Redirect to home page
                header("Location: " . ADMINURL);
                exit(); // Make sure to exit after redirecting
            } else {
                // If verification fails, provide the response
                $errors[] = "Invalid email or password.";
            }
        } else {
            // If no record found, provide response
            $errors[] = "User does not exist.";
        }

        $stmt->close();
    }

    // Store errors in session and redirect back to login page
    $_SESSION['login_errors'] = $errors;
    header("Location: " . ADMINURL . "admins/login-admins.php");
    exit();
}

$connection->close();
?>
