<?php require 'includes/header.php'; 
require 'config/connection.php';
session_start();


        /**
         * Retrieves all cities from the database and orders them by price in descending order.
         *
         * @param mysqli $connection The database connection object.
         * @return array An array of cities, each represented as an associative array.
         */
        // Prepare a query
        $city = $connection->prepare("SELECT * FROM cities ORDER BY price ASC LIMIT 5");

        // Execute the query
        $city->execute();

        // Fetch results
        $result = $city->get_result();
        $allCities = $result->fetch_all(MYSQLI_ASSOC);


        // Prepare a query
        $region = $connection->prepare("SELECT * FROM regions");
        
        // Execute the query
        $region->execute();
      
        // Fetch results
        $regionResult = $region->get_result();
        $allRegions = $regionResult->fetch_all(MYSQLI_ASSOC);


?>

<!--HERO SECTION START-->
  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Discover Our Weekly Offers</h4>
          <h2>Amazing Prices &amp; More</h2>
        </div>
      </div>
    </div>
  </div>
<!--HERO SECTION END-->

<!--SEARCH BAR START-->
  <div class="search-form">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <form id="search-form" method="POST" role="search" action="search.php">
            <div class="row">
              <div class="col-lg-2">
                <h4>Sort Deals By:</h4>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                      <select name="region_id" class="form-select" aria-label="Default select example" id="chooseLocation" onChange="this.form.click()">
                          <option selected>Destinations</option>
                          <?php foreach($allRegions as $region) : ?>
                            <option value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                      <select name="price" class="form-select" aria-label="Default select example" id="choosePrice" onChange="this.form.click()">
                          <option selected>Price range</option>
                          <option value="100">Less than GHC 100</option>
                          <option value="200">Less than GHC 200</option>
                          <option value="300">Less than GHC 300</option>
                          <option value="400">Less than GHC 400</option>
                          <option value="500">Less than GHC 500</option>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-2">                        
                  <fieldset>
                      <button type="submit" name="submit" class="border-button">Search Results</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--SEARCH BAR END-->

<!--DEALS SECTION START-->
  <div class="amazing-deals">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Get the best deals you like</p>
          </div>
        </div>
        <?php foreach($allCities as $city) : ?>
          <div class="col-lg-6 col-sm-6">
            <div class="item">
              <div class="row">
                <div class="col-lg-6">
                  <div class="image">
                    <img src="assets/images/<?php echo $city['image']; ?>" alt=""> <!--Change file path to fetch dynamically from city_images folder in cities-admins as directory path has changed. fetch from DB-->
                  </div>
                </div>
                <div class="col-lg-6 align-self-center">
                  <div class="content">
                    <span class="info">*Limited Offer Today</span>
                    <h4><?php echo $city['name']; ?></h4>
                    <div class="row">
                      <div class="col-6">
                        <i class="fa fa-clock"></i>
                        <span class="list"><?php echo $city['trip_days']; ?> days</span>
                      </div>
                    </div>
                    <p>Best deal price: GHC <?php echo $city['price']; ?></p>
                    <?php if(isset($_SESSION['username'])): ?>
                    <div class="main-button">
                      <a href="reservation.php?id=<?php echo $city['id'];?>">Make a Reservation</a>
                    </div>
                    <?php else: ?>
                    <div class="main-button">
                      <a href="auth/login.php">Login to Make a Reservation</a>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div> 
        <?php endforeach; ?>      
      </div>
    </div>
  </div>
<!--DEALS SECTION END-->


<?php require 'includes/footer.php';?>
