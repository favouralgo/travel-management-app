<?php 
require "layout/header.php";
require '../config/connection.php';


if (!isset($_SESSION["adminname"])) {
    header("Location: ".ADMINURL."admins/login-admins.php");
    exit();
}
// Query for regions
$regionsQuery = "SELECT COUNT(*) AS region_count FROM regions";
$regionsResult = $connection->query($regionsQuery);
$allRegions = $regionsResult->fetch_object();

// Query for cities
$citiesQuery = "SELECT COUNT(*) AS city_count FROM cities";
$citiesResult = $connection->query($citiesQuery);
$allCities = $citiesResult->fetch_object();

// Query for admins
// $adminsQuery = "SELECT COUNT(*) AS admin_count FROM admins";
// $adminsResult = $connection->query($adminsQuery);
// $allAdmins = $adminsResult->fetch_object();

// Query for bookings
$bookingsQuery = "SELECT COUNT(*) AS booking_count FROM bookings";
$bookingsResult = $connection->query($bookingsQuery);
$allBookings = $bookingsResult->fetch_object();
?>

<!--Landing page for all ADMINS-->
<div class="container-fluid">
    <div class="row-2">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Regions</h5>
                    <p class="card-text">No. of Regions: <?php echo htmlspecialchars($allRegions->region_count); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cities</h5>
                    <p class="card-text">No. of cities: <?php echo htmlspecialchars($allCities->city_count); ?></p>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Admins</h5>
                    <p class="card-text">No. of Admins: <?php echo htmlspecialchars($allAdmins->admin_count); ?></p>
                </div>
            </div>
        </div> -->

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">No. of bookings: <?php echo htmlspecialchars($allBookings->booking_count); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "layout/footer.php"; ?>
