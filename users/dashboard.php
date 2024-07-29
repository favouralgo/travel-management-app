<?php 
require '../includes/header.php';
require '../config/connection.php';
    if(!isset($_SESSION['username'])){
        header("Location: ".APPURL."");
    }
    /**
     * Retrieves and displays the username of a user's booking based on the provided user ID.
     *
     * @param int $id The ID of the user.
     * @return void
     */
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Use a prepared statement
        $allBookings = $connection->prepare("SELECT * FROM bookings WHERE user_id = '$id'");
        //$allBookings->bind_param("i", $id);
        $allBookings->execute();
        $result = $allBookings->get_result();
        $userBookinginfo = $result->fetch_all(MYSQLI_ASSOC);
        // $allBookings->close();
    }else{
        header("location: ../404.php");
    }


?>


<div class="container">
    <div class="row">
        <div class="col-md-12">

            <table class="table" style="margin-top: 150px; margin-bottom: 400px">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Number of guests</th>
                <th scope="col">Check-in Date</th>
                <th scope="col">Destination</th>
                <th scope="col">Status</th>
                <th scope="col">Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($userBookinginfo as $booking):?>
                    <tr>
                        <td><?php echo  $booking['name'];?></td>
                        <td><?php echo  $booking['phone_number'];?></td>
                        <td><?php echo  $booking['num_of_guests'];?></td>
                        <td><?php echo  $booking['checkin_date'];?></td>
                        <td><?php echo  $booking['destination'];?></td>
                        <td><?php echo  $booking['status'];?></td>
                        <td>GHC <?php echo  $booking['payment'];?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php require '../includes/footer.php';?>