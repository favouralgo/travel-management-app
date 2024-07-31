<?php
session_start();
require '../config/connection.php';

// Check if user is logged in
if(!isset($_SESSION['username'])){
    header("Location: ".APPURL."");
    exit();
}

// Check if delete button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $booking_id = intval($_POST['booking_id']);

    // Prepare and execute the delete statement
    $stmt = $connection->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        // Redirect to the bookings page
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle deletion error
        $_SESSION['error'] = "Failed to delete the booking.";
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: ../404.php");
    exit();
}

$connection->close();
?>
