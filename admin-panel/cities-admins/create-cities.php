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
$regionResult = $region->get_result();
$allRegions = $regionResult->fetch_all(MYSQLI_ASSOC);
?>

<!-- Add SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_POST['submit'])) {
    if (empty($_POST['cityname']) || empty($_POST['trip_days']) || empty($_POST['price']) || empty($_FILES['image']['name'])) {
        $error = "Some inputs are empty";
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

        // Get the original file name
        $original_name = basename($_FILES["image"]["name"]);
        $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $original_name);
        $target_file = $target_dir . $safe_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Error',
                        text: 'File is not an image.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            exit;
        }

        if ($_FILES["image"]["size"] > 5000000) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Size Error',
                        text: 'Sorry, your file is too large.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            exit;
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Type Error',
                        text: 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            exit;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $safe_name;
            $cityname = $connection->real_escape_string($cityname);
            $image = $connection->real_escape_string($image);
            $trip_days = $connection->real_escape_string($trip_days);
            $price = $connection->real_escape_string($price);
            $region_id = $connection->real_escape_string($region_id);

            $query = "INSERT INTO cities (name, image, trip_days, price, region_id) VALUES ('$cityname', '$image', $trip_days, $price, '$region_id')";
            if ($connection->query($query) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Record inserted successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'show-cities.php';
                        });
                    });
                </script>";
                exit();
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Database Error',
                            text: 'Error inserting record: " . $connection->error . "',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Error',
                        text: 'Sorry, there was an error uploading your file.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    }
}
?>

<div class="row-2">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <!-- Back button -->
        <a href="show-cities.php" class="btn btn-secondary mb-4">
                Back
          </a>
        <h5 class="card-title text-center mb-5">Create Cities</h5>
        <form method="POST" action="create-cities.php" enctype="multipart/form-data">
          <!-- City name input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="cityname" id="form2Example1" class="form-control" placeholder="City Name" />
          </div>
          <!-- Image input -->
          <div class="form-outline mb-4 mt-4">
            <input type="file" name="image" id="form2Example2" class="form-control" />
          </div>
          <!-- Trip days input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="trip_days" id="form2Example3" class="form-control" placeholder="Trip Days" />
          </div>
          <!-- Price input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="price" id="form2Example4" class="form-control" placeholder="Price" />
          </div>
          <!-- Region select which is dynamically fetched from database-->
          <div class="form-outline mb-4 mt-4">
            <select name="region_id" class="form-select form-control" aria-label="Choose Region">
              <option selected>Choose Region</option>
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

<?php require "../layout/footer.php"; ?>
