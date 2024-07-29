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
              <th scope="col">Change Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allBookings as $booking): ?>
            <tr>
              <th scope="row"><?php echo $booking['id']; ?></th>
              <td><?php echo htmlspecialchars($booking['name']); ?></td>
              <td><?php echo htmlspecialchars($booking['phone_number']); ?></td>
              <td><?php echo htmlspecialchars($booking['num_of_guests']); ?></td>
              <td><?php echo htmlspecialchars($booking['checkin_date']); ?></td>
              <td><?php echo htmlspecialchars($booking['destination']); ?></td>
              <td><?php echo htmlspecialchars($booking['status']); ?></td>
              <td><?php echo htmlspecialchars($booking['payment']); ?></td>
              <?php if($booking['status'] == "Pending") :?>
                <td><a href="status.php?id=<?php echo $booking['id']; ?>&status=<?php echo $booking['status']; ?>" class="btn btn-danger  text-center ">Pending</a></td>
                      <?php else : ?>  
                        <td><a href="status.php?id=<?php echo $booking['id']; ?>&status=<?php echo $booking['status']; ?>" class="btn btn-success  text-center ">Booked Successfully</a></td>
              <?php endif; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>
