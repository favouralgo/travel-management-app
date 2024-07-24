<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?> 

<?php

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
              <th scope="col">Region ID</th>
              <th scope="col">Name</th>
              <th scope="col">Population</th>
              <th scope="col">Landmark</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allRegions as $region): ?>
              <tr>
                <th scope="row"><?php echo htmlspecialchars($region['id']); ?></th>
                <td><?php echo htmlspecialchars($region['name']); ?></td>
                <td><?php echo htmlspecialchars($region['population']); ?></td>
                <td><?php echo htmlspecialchars($region['landmark']); ?></td>
                <td><?php echo htmlspecialchars($region['description']); ?></td>
                <td><a href="delete-region.php?id=<?php echo $region['id']; ?>" class="btn btn-danger text-center">Delete</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>

<?php require "../layout/footer.php"; ?>
