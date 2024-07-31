<?php 
require "../layout/header.php"; 
require "../../config/connection.php";

if (!isset($_SESSION["adminname"])) {
  header("location: " . ADMINURL);
  exit();
}

// Prepare and execute the query to fetch city and region data
$cities = $connection->prepare("
  SELECT cities.*, regions.name AS region_name
  FROM cities
  JOIN regions ON cities.region_id = regions.id
");
$cities->execute();

// Fetch results
$cityResult = $cities->get_result();
$allCities = $cityResult->fetch_all(MYSQLI_ASSOC);

?>

<!--Data fetched is dynamically displayed-->
<div class="row-2">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Cities</h5>
        <a href="create-cities.php" class="btn btn-primary mb-4 text-center float-right">Create cities</a>

        <table class="table">
          <thead>
            <tr>
              <!-- <th scope="col">City ID</th> -->
              <th scope="col">City Name</th>
              <th scope="col">Images</th>
              <th scope="col">Trip Days</th>
              <th scope="col">Price</th>
              <th scope="col">Region</th>
              <th scope="col">Actions</th> 
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allCities as $city): ?>  
            <tr id="<?php echo "row".$city['id']; ?>">
              <!-- <th scope="row"><?php echo htmlspecialchars($city['id']); ?></th> -->
              <td><?php echo htmlspecialchars($city['name']); ?></td>
              <td><img src="<?php echo CITYIMAGES . htmlspecialchars($city['image']); ?>" alt="City Image" style="width: 100px; height: 100px;"></td>
              <td><?php echo htmlspecialchars($city['trip_days']); ?></td>
              <td><?php echo htmlspecialchars($city['price']); ?></td>
              <td><?php echo htmlspecialchars($city['region_name']); ?></td>
              <td><button onclick="confirmDelete(<?php echo $city['id']; ?>)" class="btn btn-danger text-center">Delete</button></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>
<?php require "../layout/footer.php"; ?>

<!--SweetAlert library-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--jQuery library-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!--Script for displaying errors using SweetAlert-->
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this record?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete-cities.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Deleted!', response.message, 'success');
                        $("#row" + id).remove(); // Remove the row from the generated Document Object Model (DOM)
                    } else {
                        Swal.fire('Error!', response.message || 'There was an error deleting the record.', 'error');
                        if (response.debug) {
                            console.error('Debug info:', response.debug);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    Swal.fire('Error!', 'Failed to communicate with the server.', 'error');
                }
            });
        }
    });
}
</script>
