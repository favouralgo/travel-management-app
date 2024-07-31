<!--THIS PAGE IS FOR SUPER ADMINS, ADMINS ADDED THROUGH THIS PAGE ARE AUTOMATICALLY GIVEN A ROLE OF 2 AS THEY ARE SUBADMINS-->
<?php 
require "../layout/header.php";
require "../../config/connection.php";

if (!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."");
    exit();
}

$error = '';
$adminname = '';
$email = '';
$password = '';
$confirm_password = '';
?>

<!-- Add SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_POST["submit"])) {
    // Retrieve and sanitize inputs
    $adminname = filter_input(INPUT_POST, 'adminname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check for empty fields
    if (empty($adminname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Verify if user already exists
        $stmt = $connection->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "User already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $connection->prepare("INSERT INTO admins (adminname, email, mypassword, role) VALUES (?, ?, ?, 2)");
            $stmt->bind_param("sss", $adminname, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Admin created successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'admins.php';
                        });
                    });
                </script>";
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }

    // If there was an error, use SweetAlert to alert the user
    if (!empty($error)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back();
                });
            });
        </script>";
    }
}  
?>

<div class="row-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <!-- Back button -->
                <a href="admins.php" class="btn btn-secondary mb-4">
                     Back
                </a>
                <h5 class="card-title text-center mb-5">Create Admins</h5>
                <form method="POST" action="create-admins.php">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" required />
                    </div>

                    <!-- Username input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="adminname" id="form2Example2" class="form-control" placeholder="Admin name" required />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="form2Example3" class="form-control" placeholder="Password" required />
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="confirm_password" id="form2Example4" class="form-control" placeholder="Confirm Password" required />
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layout/footer.php"; ?>