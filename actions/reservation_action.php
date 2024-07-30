<?php
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");

// Start the session
session_start();

// Check if user is already logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

// Get city ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get city details
    $sqlforcities = "SELECT * FROM cities WHERE id = '$id'";
    $resultforcities = mysqli_query($connection, $sqlforcities);
    $specificcity = mysqli_fetch_assoc($resultforcities);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check that input is not empty
        if (empty($_POST['phone_number']) || empty($_POST['num_of_guests']) || empty($_POST['checkin_date']) || empty($_POST['destination'])) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill all fields']);
            exit();
        } else {
            $name = $_SESSION['username']; // Username from the session
            $phone_number = $_POST['phone_number'];
            $num_of_guests = $_POST['num_of_guests'];
            $checkin_date = $_POST['checkin_date'];
            $destination = $_POST['destination'];
            $status = "Pending";
            $city_id = $id;
            $user_id = $_SESSION['user_id'];
            $payment = $num_of_guests * $specificcity['price'];

            // Validate phone number to ensure it's all digits
            if (!ctype_digit($phone_number)) {
                echo json_encode(['status' => 'error', 'message' => 'Phone number must contain only numbers']);
                exit();
            }

            if ($checkin_date > date("Y-m-d")) {
                // SQL to insert the new reservation into the database
                $reservation_sql = "INSERT INTO bookings (name, phone_number, num_of_guests, checkin_date, destination, status, city_id, user_id, payment) 
                                    VALUES ('$name', '$phone_number', '$num_of_guests', '$checkin_date', '$destination', '$status', '$city_id', '$user_id', '$payment')";
                
                // Execute and verify the insertion query
                $reservation_result = mysqli_query($connection, $reservation_sql);
                if (!$reservation_result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($connection)]);
                    exit();
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Reservation successful']);
                    exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Check-in date cannot be in the past']);
                exit();
            }
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
