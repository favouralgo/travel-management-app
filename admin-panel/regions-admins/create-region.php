<?php 
require "../layout/header.php"; 
require "../../config/connection.php"; 


if (!isset($_SESSION["adminname"])) {
    header("location: " . ADMINURL);
    exit();
}

if (isset($_POST['submit'])) {
    if (empty($_POST['adminname']) || empty($_POST['population']) || empty($_POST['landmark']) || empty($_POST['description']) || empty($_FILES['image']['name'])) {
        echo "<script>alert('Some inputs are empty');</script>";
    } else {
        $adminname = htmlspecialchars(trim($_POST['adminname']));
        $population = intval($_POST['population']);
        $landmark = htmlspecialchars(trim($_POST['landmark']));
        $description = htmlspecialchars(trim($_POST['description']));

        // Handle file upload
        $target_dir = "uploads/";
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
            $adminname = $connection->real_escape_string($adminname);
            $image = $connection->real_escape_string($image);
            $population = $connection->real_escape_string($population);
            $landmark = $connection->real_escape_string($landmark);
            $description = $connection->real_escape_string($description);

            // Create the SQL query
            $query = "INSERT INTO regions (name, image, population, landmark, description) VALUES ('$adminname', '$image', $population, '$landmark', '$description')";

            // Execute the query
            if ($connection->query($query) === TRUE) {
                echo "<script>alert('Record inserted successfully');</script>";
                // Redirect to 'show-region.php' after successful insertion
                header("Location: show-region.php");
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
                <h5 class="card-title mb-5 d-inline">Create Regions</h5>
                <form method="POST" action="create-region.php" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="name" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" id="form2Example1" class="form-control" />
                    </div>  
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="population" id="form2Example1" class="form-control" placeholder="population" />
                    </div> 
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="landmark" id="form2Example1" class="form-control" placeholder="landmark" />
                    </div>
                    <div class="form-floating">
                        <textarea name="description" class="form-control" placeholder="description" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?> 
