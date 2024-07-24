<?php 
session_start();
require '../../config/connection.php';



// Define APPURL
define("ADMINURL", "http://localhost/wooxtravel/admin-panel");

// Checks if user is already logged in
if (isset($_SESSION['adminname'])) {
    header("Location: " . ADMINURL);
    exit();
}

$error = '';
$username = '';
$email = '';

// For extra security checks, I have to use this: $_SERVER["REQUEST_METHOD"] == "POST"

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
            $error = "Admin already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $connection->prepare("INSERT INTO admins (adminname, email, mypassword) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $adminname, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../admins/login-admins.php");
                exit();
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
