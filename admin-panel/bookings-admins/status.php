<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?>
<?php 

    if(!isset($_SESSION["adminname"])) {
        header("location: ".ADMINURL."");
    }

    if(isset($_GET['id']) && isset($_GET['status'])) {

        $id = $_GET['id'];
        $status = $_GET['status'];

        if($status == "Pending") {
            $update = $connection->prepare("UPDATE bookings SET status='Booked Successfully' WHERE
            id='$id'");

            $update->execute();

            header("location: show-bookings.php");

        } else {
            $update = $connection->prepare("UPDATE bookings SET status='Pending' WHERE
            id='$id'");

            $update->execute();

            header("location: show-bookings.php");
        }
    }
?>