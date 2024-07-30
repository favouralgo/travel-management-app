<?php 
require 'includes/header.php';  
require 'config/connection.php'; 

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");


// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get city details
    $sqlforcities = "SELECT * FROM cities WHERE id = '$id'";
    $resultforcities = mysqli_query($connection, $sqlforcities);
    $specificcity = mysqli_fetch_assoc($resultforcities);
} else {
    header("location: 404.php");
}
?>

<div class="second-page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Book Preferred Deal Here</h4>
                <h2>Make Your Reservation</h2>
                <p>Travel to regions you never know existed in Ghana</p>
            </div>
        </div>
    </div>
</div>

<div class="more-info reservation-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="info-item">
                    <i class="fa fa-phone"></i>
                    <h4>Make a Phone Call</h4>
                    <a href="#">+233 456 789 (0)</a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="info-item">
                    <i class="fa fa-envelope"></i>
                    <h4>Contact Us via Email</h4>
                    <a href="mailto:favourmdev@email.com?subject=Booking%20Issue&body=Hi%20Admin">favourmdev@email.com</a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="info-item">
                    <i class="fa fa-map-marker"></i>
                    <h4>Visit Our Offices</h4>
                    <a href="#">1 University Avenue Berekuso, Ghana</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="reservation-form">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
                <form id="reservation-form" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Make Your <em>Reservation</em> Through This <em>Form</em></h4>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="Number" class="form-label">Your Phone Number</label>
                                <input type="text" name="phone_number" class="Number" placeholder="Ex. 0205678910" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="chooseGuests" class="form-label">Number Of Guests</label>
                                <select name="num_of_guests" class="form-select" aria-label="Default select example" id="chooseGuests" required>
                                    <option value="" disabled selected>ex. 3 or 4 or 5</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <label for="Number" class="form-label">Check In Date</label>
                                <input type="date" name="checkin_date" class="date" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="hidden" value="<?php echo $specificcity['name']; ?>" name="destination">
                            </fieldset>
                        </div>
                        <div class="col-lg-12">                        
                            <fieldset>
                                <?php if ($isLoggedIn): ?>
                                    <button type="submit" class="main-button">Make Your Reservation</button>
                                <?php else: ?>
                                    <button type="button" class="main-button" onclick="window.location.href='auth/login.php'">Login to Make a Reservation</button>
                                <?php endif; ?>
                            </fieldset>
                        </div>
                    </div>
                </form>
          </div>
      </div>
  </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('reservation-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);
    fetch('actions/reservation_action.php?id=<?php echo $_GET['id']; ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?php echo APPURL; ?>';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred.',
            confirmButtonText: 'OK'
        });
    });
});
</script>

<?php require 'includes/footer.php'; ?>
