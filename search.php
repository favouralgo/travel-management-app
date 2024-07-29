<?php 
require 'includes/header.php';  
require 'config/connection.php';

  if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Check for empty fields
        if (empty($_POST['region_id']) || empty($_POST['price'])) {
            echo "<script>alert('Please fill out all fields');</script>";
        } else{
            $region_id = $_POST['region_id'];
            $price = $_POST['price'];

            $search = $connection->prepare("SELECT * FROM cities WHERE region_id = $region_id AND price < $price");
            $search->execute();
            $result = $search->get_result();
            $finalResult = $result->fetch_all(MYSQLI_ASSOC);
        }
    } else {
        header("location: index.php");
      }
?>

<!--HERO SECTION START-->
  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Search Results</h4>
          <h2>Amazing Prices &amp; More</h2>
        </div>
      </div>
    </div>
  </div>
<!--HERO SECTION END-->

<!--DEALS SECTION START-->
  <div class="amazing-deals">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Get offers that you like</p>
          </div>
        </div>
        <?php foreach ($finalResult as $results) : ?>
            <div class="col-lg-6 col-sm-6">
                <div class="item">
                <div class="row">
                    <div class="col-lg-6">
                    <div class="image">
                        <img src="assets/images/<?php echo $results['image']; ?>" alt="">
                    </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                    <div class="content">
                        <span class="info">*Limited Offer Today</span>
                        <h4><?php echo $results['name']; ?></h4>
                        <div class="row">
                        <div class="col-6">
                            <i class="fa fa-clock"></i>
                            <span class="list"><?php echo $results['trip_days']; ?> days</span>
                        </div>
                        </div>
                        <p>Best deal price: GHC <?php echo $results['price']; ?></p>
                        <?php if(isset($_SESSION['username'])) : ?>
                            <div class="main-button">
                            <a href="reservation.php?id=<?php echo $results['id'];?>">Make a Reservation</a>
                            </div>
                        <?php else : ?>
                            <p> Login to make a reservation</p>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
                </div>
            </div> 
            </div>
        <?php endforeach; ?>
    </div>
  </div>
<!--DEALS SECTION END-->

<?php require 'includes/footer.php';?>
