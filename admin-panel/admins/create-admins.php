<?php 
require "../layout/header.php";
require "../../config/connection.php";

if(!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."");
}

$error = '';
$adminname = '';
$email = '';

if (isset($_POST["submit"])) {
    // Retrieve and sanitize inputs
    $adminname = filter_input(INPUT_POST, 'adminname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Check for empty fields
if (empty($_POST['adminname']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Please fill in all fields";
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
            $stmt = $connection->prepare("INSERT INTO admins (adminname, email, mypassword) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $adminname, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: admins.php");
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }

    // If there was an error, use JavaScript to alert the user and redirect back to the form
    if (!empty($error)) {
        echo "<script>
            alert('" . htmlspecialchars($error) . "');
            window.history.back();
        </script>";
        exit();
    }
}  
?>

<div class="row-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Admins</h5>
                <form method="POST" action="create-admins.php">
                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />
                    
                    </div>

                    <div class="form-outline mb-4">
                    <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" />
                    </div>
                    <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Add</button>

            
                </form>

            </div>
        </div>
    </div>
</div>
<?php require "../layout/footer.php"; ?>