<?php 
require 'includes/header.php'; 
require 'config/connection.php';
session_start();

// Fetch all cities
$city = $connection->prepare("SELECT * FROM cities ORDER BY price ASC");
$city->execute();
$result = $city->get_result();
$allCities = $result->fetch_all(MYSQLI_ASSOC);

// Fetch regions (unchanged)
$region = $connection->prepare("SELECT * FROM regions");
$region->execute();
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
        <form id="search-form" role="search">
          <div class="row">
            <div class="col-lg-2">
              <h4>Sort Deals By:</h4>
            </div>
            <div class="col-lg-3">
              <fieldset>
                <select name="region_id" class="form-select" aria-label="Default select example" id="chooseLocation">
<!--Dynamically fetch data from database-->
                  <option value="">Destinations</option>
                  <?php foreach($allRegions as $region) : ?>
                    <option value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-3">
              <fieldset>
                <select name="price" class="form-select" aria-label="Default select example" id="choosePrice">
                  <option value="">Price range</option>
                  <option value="200">Less than GHC 200</option>
                  <option value="300">Less than GHC 300</option>
                  <option value="400">Less than GHC 400</option>
                  <option value="500">Less than GHC 500</option>
                  <option value="600">Less than GHC 600</option>
                  <option value="700">Less than GHC 700</option>
                  <option value="800">Less than GHC 800</option>
                  <option value="900">Less than GHC 900</option>
                  <option value="1000">Less than GHC 1000</option>
                  <option value="3000">Less than GHC 3000</option>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-2">                        
              <fieldset>
                <button type="submit" name="submit" class="border-button">Search</button>
              </fieldset>
              
            </div>
            <div class="col-lg-2">                        
              <fieldset>
                <button type="button" id="clear-button" class="border-button">Clear</button>
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
                  <!--Dynamically fetch data from database-->
      <?php foreach($allCities as $city) : ?>
          <div class="col-lg-6 col-sm-6 deal-item" data-region="<?php echo $city['region_id']; ?>" data-price="<?php echo $city['price']; ?>">
            <div class="item">
              <div class="row">
                <div class="col-lg-6">
                  <div class="image">
                    <img src="<?php echo CITYIMAGES . htmlspecialchars($city['image']); ?>" alt="">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('search-form');
    var clearButton = document.getElementById('clear-button');
    var deals = document.querySelectorAll('.deal-item');

    function filterDeals() {
        var selectedRegion = document.getElementById('chooseLocation').value;
        var selectedPrice = document.getElementById('choosePrice').value;

        deals.forEach(function(deal) {
            var regionMatch = !selectedRegion || deal.dataset.region === selectedRegion;
            var priceMatch = !selectedPrice || parseInt(deal.dataset.price) < parseInt(selectedPrice);

            if (regionMatch && priceMatch) {
                deal.style.display = '';
            } else {
                deal.style.display = 'none';
            }
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        filterDeals();
    });

    clearButton.addEventListener('click', function() {
        form.reset();
        deals.forEach(function(deal) {
            deal.style.display = '';
        });
    });
});
</script>

<?php require 'includes/footer.php';?>
