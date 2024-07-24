<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?>

<?php

if (!isset($_SESSION["adminname"])) {
  header("location: " . ADMINURL);
  exit();
}

// QUERY TO
// Prepare and execute the query
$cities = $connection->prepare("SELECT * FROM cities");
$cities->execute();

// Fetch results
$cityResult = $cities->get_result();
$allCities = $cityResult->fetch_all(MYSQLI_ASSOC);


// Prepare and execute the query
$region = $connection->prepare("SELECT * FROM regions");
$region->execute();

// Fetch results
$regionResult = $region->get_result();
$allRegions = $regionResult->fetch_all(MYSQLI_ASSOC);

?>
      <div class="row-2">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Cities</h5>
              <a  href="create-cities.html" class="btn btn-primary mb-4 text-center float-right">Create cities</a>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">City ID</th>
                    <th scope="col">City Name</th>
                    <th scope="col">image</th>
                    <th scope="col">Trip Days</th>
                    <th scope="col">Price</th>
                    <th scope="col">Region ID</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Berlin</td>
                    <td>image</td>
                    <td>3</td>
                    <td>$1300</td>
                     <td><a href="delete-posts.html" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>
<?php require "../layout/footer.php"; ?>