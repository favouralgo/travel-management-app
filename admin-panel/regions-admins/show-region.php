<?php 
require "../layout/header.php"; 
require "../../config/connection.php"; 

if (!isset($_SESSION["adminname"])) {
  header("location: " . ADMINURL);
  exit();
}

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
        <h5 class="card-title mb-4 d-inline">Regions</h5>
        <a href="create-region.php" class="btn btn-primary mb-4 text-center float-right">Create Region</a>
        <table class="table">
          <thead>
            <tr>
              
              <th scope="col">Name</th>
              <th scope="col">Population</th>
              <th scope="col">Image</th>
              <th scope="col">Landmark</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allRegions as $region): ?>
              <tr id="<?php echo "row".$region['id']; ?>">
                <td><?php echo htmlspecialchars($region['name']); ?></td>
                <td><?php echo htmlspecialchars($region['population']); ?></td>
                <td><img src="<?php echo REGIONIMAGES . htmlspecialchars($region['image']); ?>" alt="Region Image" style="width: 100px; height: 100px;"></td>
                <td><?php echo htmlspecialchars($region['landmark']); ?></td>
                <td><?php echo htmlspecialchars($region['description']); ?></td>
                <td><button onclick="confirmDelete(<?php echo $region['id']; ?>)" class="btn btn-danger text-center">Delete</button></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>

<?php require "../layout/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                url: 'delete-region.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Deleted!', response.message, 'success');
                        $("#row" + id).remove(); // Remove the row from the DOM
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
