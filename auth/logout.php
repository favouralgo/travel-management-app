<?php
// include_once "../config/connection.php";  


session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page or any other page
header("Location: http://51.20.181.20/wooxtravel/");
// exit;
?>