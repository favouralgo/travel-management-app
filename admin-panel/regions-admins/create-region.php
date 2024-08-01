<?php 
require "../layout/header.php"; 
require "../../config/connection.php"; 

if (!isset($_SESSION["adminname"])) {
    header("location: " . ADMINURL);
    exit();
}
?>
<!-- Add SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_POST['submit'])) {
    $adminname = htmlspecialchars(trim($_POST['adminname']));
    $population = intval($_POST['population']);
    $landmark = htmlspecialchars(trim($_POST['landmark']));
    $description = htmlspecialchars(trim($_POST['description']));
    $imageError = '';

    if (empty($adminname) || empty($population) || empty($landmark) || empty($description) || empty($_FILES['image']['name'])) {
        $error = "Some inputs are empty";
    } else {
        // Handle file upload
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Get the original file name
        $original_name = basename($_FILES["image"]["name"]);
        $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $original_name);
        $target_file = $target_dir . $safe_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        //Handling the image files and error display using SweetAlert
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $imageError = "File is not an image.";
        } elseif ($_FILES["image"]["size"] > 5000000) {
            $imageError = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $imageError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $safe_name;
                $adminname = $connection->real_escape_string($adminname);
                $image = $connection->real_escape_string($image);
                $population = $connection->real_escape_string($population);
                $landmark = $connection->real_escape_string($landmark);
                $description = $connection->real_escape_string($description);

                $query = "INSERT INTO regions (name, image, population, landmark, description) VALUES ('$adminname', '$image', $population, '$landmark', '$description')";
                if ($connection->query($query) === TRUE) {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Region inserted successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'show-region.php';
                            });
                        });
                    </script>";
                    exit();
                } else {
                    $error = "Error inserting record: " . $connection->error;
                }
            } else {
                $imageError = "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (!empty($error)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }

    if (!empty($imageError)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Image Error',
                    text: '" . htmlspecialchars($imageError, ENT_QUOTES, 'UTF-8') . "',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}
?>


<!--Adding ADMINS-->
<div class="row-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <!-- Back button -->
                <a href="show-region.php" class="btn btn-secondary mb-4">
                     Back
                </a>
                <h5 class="card-title text-center mb-5">Create Regions</h5>
                <form method="POST" action="create-region.php" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="Name" />
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" name="image" id="form2Example1" class="form-control" />
                    </div>  
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="population" id="form2Example1" class="form-control" placeholder="Population" />
                    </div> 
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" name="landmark" id="form2Example1" class="form-control" placeholder="Landmark" />
                    </div>
                    <div class="form-floating">
                        <textarea name="description" class="form-control" placeholder="Description" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?>
