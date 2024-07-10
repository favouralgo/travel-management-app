<?php require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");

// Start the session
session_start();

// Check if user is already logged in
if(!isset($_SESSION['username'])){
    header("Location: ".APPURL."");
}

// Get city ID
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Get region to display in the country dropdown menu in reservation form
    $sqlforcities = "SELECT * FROM cities WHERE id = '$id'";

    // Establish and verify connection
    $resultforcities = mysqli_query($connection, $sqlforcities);
  
    // Fetch the result
    $specificcity = mysqli_fetch_assoc($resultforcities);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Check that input is not empty
        if(empty($_POST['name']) || empty($_POST['phone_number']) || empty($_POST['num_of_guests']) || empty($_POST['checkin_date']) || empty($_POST['destination'])){
            echo "<script>alert('Please fill all fields'); history.back();</script>";
        } else {
            $name = $_POST['name'];
            $phone_number = $_POST['phone_number'];
            $num_of_guests = $_POST['num_of_guests'];
            $checkin_date = $_POST['checkin_date'];
            $destination = $_POST['destination'];
            $status = "Pending";
            $city_id = $id;
            $user_id = $_SESSION['user_id'];
            $payment = $num_of_guests * $specificcity['price'];

            // header("location: pay.php");

            if($checkin_date > date("Y-m-d")){
                // SQL to insert the new reservation into the database
                $reservation_sql = "INSERT INTO bookings (name, phone_number, num_of_guests, checkin_date, destination, status, city_id, user_id,payment) 
                                    VALUES ('$name', '$phone_number', '$num_of_guests', '$checkin_date', '$destination', '$status', '$city_id', '$user_id','$payment')";
                
                // Execute and verify the insertion query
                $reservation_result = mysqli_query($connection, $reservation_sql);
                if(!$reservation_result){
                    echo "Error: ".mysqli_error($connection);
                    exit();
                } else {
                    echo "<script>alert('Reservation successful'); window.location.href='".APPURL."';</script>";
                }
            } else {
                // Returns the user back to the form after throwing an error output
                echo "<script>alert('Check-in date cannot be in the past'); history.back();</script>";
            }
        }
    }
} else{
    header("location: 404.php");
}
?>
