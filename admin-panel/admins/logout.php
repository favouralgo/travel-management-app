<?php
// include_once "../config/core.php"; 

session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page or any other page
header("Location: http://localhost/wooxtravel/admin-panel/admins/login-admins.php");
// exit;
?>