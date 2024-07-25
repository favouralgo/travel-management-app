<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?>
<?php

if (!isset($_SESSION["adminname"])) {
  header("location: " . ADMINURL);
  exit();
}

// QUERY TO
// Prepare and execute the query
$bookings = $connection->prepare("SELECT * FROM bookings");
$bookings->execute();

// Fetch results
$bookingResult = $bookings->get_result();
$allBookings = $bookingResult->fetch_all(MYSQLI_ASSOC);
?>


<div class="row-2">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Bookings</h5>
      
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Customer ID</th>
              <th scope="col">Name</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Number of Guests</th>
              <th scope="col">Checkin Date</th>
              <th scope="col">Destination</th>
              <th scope="col">Status</th>
              <th scope="col">Payment (GHC)</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>MOhamed</td>
              <td>33333</td>
              <td>4</td>
              <td>23-3-19</td>
              <td>Berlin</td>
              <td>Pending</td>
              <td>$104</td>
               <td><a href="delete-posts.html" class="btn btn-danger  text-center ">delete</a></td>
            </tr>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>