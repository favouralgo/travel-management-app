<?php
session_start();
require '../config/connection.php';

// Check if user is logged in
if(!isset($_SESSION['username'])){
    header("Location: ".APPURL."");
    exit();
}

// Check if delete button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["booking_id"])) {
    $booking_id = intval($_POST['booking_id']);

    // Prepare and execute the delete statement
    $stmt = $connection->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        $stmt->close();
        $user_id = $_SESSION['user_id'];
        header("Location: dashboard.php?id=" . $user_id);
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}

$connection->close();
?>
