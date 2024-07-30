<?php 
require '../includes/header.php';
require '../config/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: " . APPURL);
    exit();
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
    $allBookings = $connection->prepare("SELECT * FROM bookings WHERE user_id = ?");
    $allBookings->bind_param("i", $id);
    $allBookings->execute();
    $result = $allBookings->get_result();
    $userBookinginfo = $result->fetch_all(MYSQLI_ASSOC);
    $allBookings->close();
} else {
    header("location: ../404.php");
    exit();
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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userBookinginfo as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['name']);?></td>
                            <td><?php echo htmlspecialchars($booking['phone_number']);?></td>
                            <td><?php echo htmlspecialchars($booking['num_of_guests']);?></td>
                            <td><?php echo htmlspecialchars($booking['checkin_date']);?></td>
                            <td><?php echo htmlspecialchars($booking['destination']);?></td>
                            <td><?php echo htmlspecialchars($booking['status']);?></td>
                            <td>GHC <?php echo htmlspecialchars($booking['payment']);?></td>
                            <td>
                                <!-- Delete button -->
                                <form class="delete-form" action="delete_booking.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']);?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        const form = this; // Reference to the form

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#008000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });
});
</script>

<?php require '../includes/footer.php';?>
