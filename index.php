<?php 
require 'includes/header.php';
require 'config/connection.php'; 

// Getting regions and displaying them --- TRUNCATE THE PRICES
$query = $connection->prepare("SELECT regions.id AS id, regions.name AS name, 
            regions.image AS image, regions.population AS population, regions.landmark AS landmark, 
            regions.description AS description, AVG(cities.price) AS average_price 
            FROM regions JOIN cities ON regions.id = cities.region_id GROUP BY regions.id, regions.name, regions.image, regions.population, regions.landmark, regions.description");
$query->execute();
$result = $query->get_result();
$regions = $result->fetch_all(MYSQLI_ASSOC);

?>

<!-- ***** Main Banner Area Start ***** (cities.region_id)-->
  <section id="section-1">
    <div class="content-slider">
    <?php foreach($regions as $region): ?>
      <input type="radio" id="banner<?php echo $region['id']; ?>" class="sec-1-input" name="banner" checked>
    <?php endforeach; ?>
      <div class="slider">
        <?php foreach($regions as $region): ?>
        <div id="top-banner-<?php echo $region['id']; ?>" class="banner">
          <div class="banner-inner-wrapper header-text">
            <div class="main-caption">
              <h2>Take a Glimpse Of The Different Regions in Ghana:</h2>
              <h1><?php echo $region['name']; ?></h1>
              <div class="border-button"><a href="about.php?id=<?php echo $region['id']; ?>">Go There</a></div>
            </div>
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="more-info">
                    <div class="row">
                      <div class="col-lg-3 col-sm-6 col-6">
        <!--Dynamically fetch data from database-->
                        <!-- Population -->
                        <h4><span>Population:</span><br><?php echo $region['population']; ?></h4>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-6">
                        <!-- Landmark -->
                        <h4><span>Landmark:</span><br><?php echo $region['landmark']; ?></h4>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-6">
                        <!-- Average price from joined tables -->
                        <h4><span>AVG Price:</span><br>GHC <?php echo $region['average_price']; ?></h4>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-6">
                        <div class="main-button">
                          <a href="about.php?id=<?php echo $region['id']; ?>">Explore More</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <nav>
        <div class="controls">
        <?php foreach($regions as $region): ?>
          <label for="banner<?php echo $region['id']; ?>"><span class="progressbar"><span class="progressbar-fill"></span></span><span class="text"><?php echo $region['name']; ?></span></label>
        <?php endforeach; ?>
        </div>
      </nav>
    </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->
  
  <div class="visit-country">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="section-heading">
            <h2>Visit One Of the Regions in Ghana Now</h2>
            <p>Explore diversity, food, and culture. Get a glimpse of everything good</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div class="items">
            <div class="row">
            <?php foreach($regions as $region): ?>
              <div class="col-lg-12">
                <div class="item">
                  <div class="row">
                    <div class="col-lg-4 col-sm-5">
                      <div class="image">
                      <img src="<?php echo REGIONIMAGES . htmlspecialchars($region['image']); ?>" alt="">
                      </div>
                    </div>
                    <div class="col-lg-8 col-sm-7">
                      <div class="right-content">
                        <h4><?php echo htmlspecialchars($region['landmark']); ?></h4>
                        <span><?php echo htmlspecialchars($region['name']); ?> Region</span>
                        <div class="main-button">
                          <a href="about.php?id=<?php echo $region['id']; ?>">Explore More</a>
                        </div>
                        <p>
                        <?php echo htmlspecialchars($region['description']); ?>
                        </p>
                        <ul class="info">
                          <li><i class="fa fa-user"></i> <?php echo htmlspecialchars($region['population']);?> People</li>
                          <li><i class="fa fa-globe"></i> <?php echo htmlspecialchars($region['landmark']); ?></li>
                          <li><i class="fa fa-home"></i> GHC <?php echo htmlspecialchars($region['average_price']); ?></li>
                        </ul>
                        <div class="text-button">
                          <a href="about.php?id=<?php echo $region['id']; ?>">Need Directions ? <i class="fa fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
              
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="side-bar-map">
            <div class="row">
              <div class="col-lg-12">
                <div id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1985148.059477!2d-3.5070830954442633!3d7.946527686299236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfdf9b6bcf8c9bf3%3A0x4a5e6dd28f6b3d41!2sGhana!5e0!3m2!1sen!2sth!4v1642869952544!5m2!1sen!2sth" width="100%" height="550px" frameborder="0" style="border:0; border-radius: 23px;" allowfullscreen=""></iframe>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require 'includes/footer.php'; ?>