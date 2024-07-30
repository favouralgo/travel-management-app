<?php require 'includes/header.php'; ?>
<?php require 'config/connection.php'; 

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");


if(isset($_GET['id'])){

  $id = $_GET['id'];

  // Get region to display in the country dropdown menu in reservation form
  $sqlforcities = "SELECT * FROM cities WHERE id = '$id'";

  // Establish and verify connection
  $resultforcities = mysqli_query($connection, $sqlforcities);

  // Fetch the result
  $specificcity = mysqli_fetch_assoc($resultforcities);
}else{
  header("location: 404.php");

}

?>

  <div class="second-page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Book Prefered Deal Here</h4>
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
            <a href="mailto:favourmdev@email.com?subject=Ticket%20Issue&body=Hi%20Admin">favourmdev@email.com</a>
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
          <form id="reservation-form" method="POST" role="search" action="actions/reservation_action.php?id=<?php echo $_GET['id']; ?>">
            <div class="row">
              <div class="col-lg-12">
                <h4>Make Your <em>Reservation</em> Through This <em>Form</em></h4>
              </div>
              <!-- <div class="col-lg-6">
                  <fieldset>
                      <label for="Name" class="form-label">Your Name</label>
                      <input type="text" name="name" class="Name" placeholder="Ex. Kwame Badoo" autocomplete="on" required>
                  </fieldset>
              </div> -->
              <div class="col-lg-6">
                <fieldset>
                    <label for="Number" class="form-label">Your Phone Number</label>
                    <input type="text" name="phone_number" class="Number" placeholder="Ex. 0205678910" autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-6">
                  <fieldset>
                      <label for="chooseGuests" class="form-label">Number Of Guests</label>
                      <select name="num_of_guests" class="form-select" aria-label="Default select example" id="chooseGuests" onChange="this.form.click()">
                          <option selected>ex. 3 or 4 or 5</option>
                          <option type="checkbox" name="option1" value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-6">
                <fieldset>
                    <label for="Number" class="form-label">Check In Date</label>
                    <input type="date" name="checkin_date" class="date" required>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                    <input type="hidden" value="<?php echo $specificcity['name'];?>" name="destination" class="Number" placeholder="" autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">                        
                  <fieldset>
                      <button name="submit" type="submit" class="main-button">Make Your Reservation</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php require 'includes/footer.php';?>

