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


if (isset($_POST['submit'])) {
    if (empty($_POST['cityname']) || empty($_POST['trip_days']) || empty($_POST['price']) || empty($_FILES['image']['name'])) {
        echo "<script>alert('Some inputs are empty');</script>";
    } else {
        $cityname = htmlspecialchars(trim($_POST['cityname']));
        $trip_days = intval($_POST['trip_days']);
        $price = intval($_POST['price']);
        $region_id = $_POST['region_id'];

        // Handle file upload
        $target_dir = "city_images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }   

        // Sanitize and generate a unique file name
        $original_name = basename($_FILES["image"]["name"]);
        $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $original_name);
        $unique_name = uniqid() . "_" . $safe_name;
        $target_file = $target_dir . $unique_name;

        // Get file extension and convert to lowercase
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            exit;
        }

        // Check file size (should not exceed maximum of 5MB)
        if ($_FILES["image"]["size"] > 5000000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            exit;
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            exit;
        }

        // File is uploaded, proceed to insert data
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Assign the image path to a variable
            $image = $target_file;

            // Sanitize the input data for SQL query
            $cityname = $connection->real_escape_string($cityname);
            $image = $connection->real_escape_string($image);
            $trip_days = $connection->real_escape_string($trip_days);
            $price = $connection->real_escape_string($price);
            $region_id = $connection->real_escape_string($region_id);

            // Create the SQL query
            $query = "INSERT INTO cities (name, image, trip_days, price, region_id) VALUES ('$cityname', '$image', $trip_days, '$price', '$region_id')";

            // Execute the query
            if ($connection->query($query) === TRUE) {
                echo "<script>alert('Record inserted successfully');</script>";
                // Redirect to 'show-region.php' after successful insertion
                header("Location: show-cities.php");
            } else {
                echo "<script>alert('Error inserting record: " . $connection->error . "');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

?>



<div class="row-2">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Create Cities</h5>
    <form method="POST" action="create-cities.php" enctype="multipart/form-data">
          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="cityname" id="form2Example1" class="form-control" placeholder="name" />
           
          </div>
          <div class="form-outline mb-4 mt-4">
            <input type="file" name="image" id="form2Example1" class="form-control"  />
           
          </div>
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="trip_days" id="form2Example1" class="form-control" placeholder="trip_days" />
           
          </div>
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" />
          </div>

          <div class="form-outline mb-4 mt-4">
            <select name="region_id" class="form-select  form-control" aria-label="Default select example">
              <option selected>Choose Region</option> <!--Regions and their ID is fetched dynamically here and when the user selects a region, the corresponding city ID is sent to the cities table in the DB-->
              <?php foreach($allRegions as $region) :?>
              <option value="<?php echo htmlspecialchars($region['id']); ?>"><?php echo htmlspecialchars($region['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <br>
          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Add</button>
    
        </form>
      </div>
    </div>
  </div>
</div>