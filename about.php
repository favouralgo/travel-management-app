<?php require 'includes/header.php'; ?>
<?php require 'config/connection.php'; ?>

<?php
// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");

/**
 * Retrieves user information based on the provided ID.
 *
 * @param int $id The ID of the user to retrieve information for.
 * @return array|null Returns an associative array containing the user information if found, or null if no user is found.
 */
// Uses the request method type GET to READ from database
if($_SERVER["REQUEST_METHOD"] == "GET"){

  $id = $_GET['id'];

  //-------------Write query to retrieve regionID
  $sqlforregions = "SELECT * FROM regions WHERE id = '$id'";

  // Establish and verify connection
  $resultforregions = mysqli_query($connection, $sqlforregions);

  // Fetch the result
  $specificregion = mysqli_fetch_assoc($resultforregions);


  //--------------- Write query to retrieve city images
  $sqlforimages = "SELECT * FROM cities WHERE region_id = '$id'";

  // Establish and verify connection
  $resultforimages = mysqli_query($connection, $sqlforimages);

  // Fetch the result
  $specificimage = mysqli_fetch_all($resultforimages, MYSQLI_ASSOC);



  //------------ Write query to get number of bookings for display
  $sqlforbookings = "SELECT cities.id AS id, cities.name AS name, 
            cities.image AS image, cities.trip_days AS trip_days, cities.price AS price, 
            COUNT(bookings.city_id) AS booking_no 
            FROM cities LEFT JOIN bookings ON cities.id = bookings.city_id WHERE cities.region_id = '$id' GROUP BY(bookings.city_id)";
  
  // Establish and verify connection
  $resultforbookings = mysqli_query($connection, $sqlforbookings);

  // Fetch the result
  $bookings = mysqli_fetch_all($resultforbookings, MYSQLI_ASSOC);

} else {
  header("location: 404.php");
}

?>

  <!-- ***** MAIN BANNER START ***** -->
  <div class="about-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <div class="blur-bg"></div>
            <h4>EXPLORE OUR REGIONS</h4>
            <div class="line-dec"></div>
            <h2>Welcome To <?php echo $specificregion['name']; ?> Region</h2>
            <p><?php echo $specificregion['description']; ?></p>
            <div class="main-button">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** MAIN BANNER END ***** -->

  <!-- ***** DISPLAY REGION SECTION START ***** -->
  <div class="cities-town">
    <div class="container">
      <div class="row">
        <div class="slider-content">
          <div class="row">
            <div class="col-lg-12">
              <h2><?php echo $specificregion['name']; ?> Region’s <em>Cities</em></h2>
            </div>
            <div class="col-lg-12">
              <div class="owl-cites-town owl-carousel">
              <?php foreach($specificimage as $image): ?>
                <div class="item">
                  <div class="thumb">
                    <img src="assets/images/<?php echo $image['image']; ?>" alt="">
                    <h4><?php echo $image['name']; ?></h4>
                  </div>
                </div>
              <?php endforeach; ?>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** DISPLAY REGION SECTION END ***** -->

  <!-- ***** DISPLAY CITY OFFERINGS SECTION START ***** -->
  <div class="weekly-offers">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-weekly-offers owl-carousel">
            <?php foreach($bookings as $booking): ?>
              <div class="item">
              <div class="thumb">
                <img src="assets/images/<?php echo $booking['image']; ?>" alt="">
                <div class="text">
                  <h4><?php echo $booking['name']; ?><br><span><i class="fa fa-users"></i> <?php echo $booking['booking_no']; ?> Check Ins</span></h4>
                  <h6>GHC <?php echo $booking['price']; ?><br><span>/person</span></h6>
                  <div class="line-dec"></div>
                  <ul>
                    <li>Deal Includes:</li>
                    <li><i class="fa fa-taxi"></i> <?php echo $booking['trip_days']; ?> Days Trip > Hotel Included</li>
                    <!-- <li><i class="fa fa-plane"></i> Airplane Bill Included</li>
                    <li><i class="fa fa-building"></i> Daily Places Visit</li> -->
                  </ul>
                  <?php if(isset($_SESSION['username'])): ?>
                    <div class="main-button">
                      <a href="reservation.php?id=<?php echo $booking['id']; ?>">Make a Reservation</a>
                    </div>
                  <?php else: ?>
                    <div class="main-button">
                      <a href="auth/login.php">Login to Make a Reservation</a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- ***** DISPLAY CITY OFFERINGS SECTION END ***** -->


<?php require 'includes/footer.php';?>
