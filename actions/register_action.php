<?php
session_start();
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");

// Checks if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: " . APPURL);
    exit();
}

$error = '';
$username = '';
$email = '';

// For extra security checks, add this: $_SERVER["REQUEST_METHOD"] == "POST"

if (isset($_POST["submit"])) {
    // Retrieve and sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Check for empty fields
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Please fill in all fields";
    } else {
        // Verify if user already exists
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "User already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $connection->prepare("INSERT INTO users (username, email, userpassword) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../auth/login.php");
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
