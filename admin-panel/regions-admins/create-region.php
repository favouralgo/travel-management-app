<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?> 

<?php

if(!isset($_SESSION["adminname"])) {
  header("location: ".ADMINURL."");
}





if (isset($_POST['submit'])) {
  if (empty($_POST['name']) || empty($_POST['population']) || empty($_POST['landmark']) || empty($_POST['description']) || empty($_FILES['image']['name'])) {
    echo "<script>alert('Some inputs are empty');</script>";
  } else {
    $name = htmlspecialchars(trim($_POST['name']));
    $population = intval($_POST['population']);
    $landmark = htmlspecialchars(trim($_POST['landmark']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Handle file upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $unique_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $unique_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
      echo "<script>alert('File is not an image.');</script>";
      exit;
    }

    // Check file size (e.g., max 5MB)
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

    // Try to upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      // Assign the image path to a variable
      $image = $target_file;

      // File is uploaded, proceed to insert data
      $stmt = $conn->prepare("INSERT INTO regions (name, image, population, landmark, description) VALUES (?, ?, ?, ?, ?)");
      if ($stmt) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sisss", $name, $image, $population, $landmark, $description);

        // Execute the prepared statement
        if ($stmt->execute()) {
          echo "<script>alert('Record inserted successfully');</script>";
        } else {
          echo "<script>alert('Error inserting record: " . $stmt->error . "');</script>";
        }

        // Close the statement
        $stmt->close();
      } else {
        echo "<script>alert('Database error: Could not prepare statement');</script>";
      }
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    }
  }
}

?>

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5 d-inline">Create Regions</h5>
        <form method="POST" action="" enctype="multipart/form-data">
            <!-- Email input -->
            <div class="form-outline mb-4 mt-4">
              <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
             
            </div>
            <div class="form-outline mb-4 mt-4">
              <input type="file" name="image" id="form2Example1" class="form-control" />
             
            </div>  
            <div class="form-outline mb-4 mt-4">
              <input type="text" name="population" id="form2Example1" class="form-control" placeholder="population" />
             
            </div> 
             <div class="form-outline mb-4 mt-4">
              <input type="text" name="landmark" id="form2Example1" class="form-control" placeholder="landmark" />
             
            <div class="form-floating">
              <textarea name="description" class="form-control" placeholder="description" id="floatingTextarea2" style="height: 100px"></textarea>
            </div>
            <br>
  
            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Add</button>
      
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php require "../layout/footer.php"; ?> 