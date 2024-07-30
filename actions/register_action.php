<?php
session_start();
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://localhost/wooxtravel/");
$errors = []; // Initialize errors array

// Checks if user is already logged in
if (!isset($_SESSION['username'])) {
    header("Location: " . APPURL);
}


// For extra security checks, I have to use this: $_SERVER["REQUEST_METHOD"] == "POST"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // HTML Form Validation
    if (empty($username) || empty($email) || empty($password)|| empty($confirm_password)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif (is_numeric($email)) {
        $errors[] = "Email cannot be numeric.";
    } elseif (is_numeric($first_name) || is_numeric($last_name)) {
        $errors[] = "Your name should not be numbers only.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@(yahoo\.com|gmail\.com)$/", $email)) {
        $errors[] = "Email must end with @yahoo.com or @gmail.com.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if(count($errors) == 0){
        // Hash Password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Verify if user already exists
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "This user already signed up";
        } else {

            // Insert the new user into the database
            $stmt = $connection->prepare("INSERT INTO users (username, email, userpassword) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../auth/login.php");
                exit();
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
        }
    }

    // If there was an error, use JavaScript to alert the user and redirect back to the form
    if (count($errors) > 0){
        $_SESSION['signup_errors'] = $errors;
        $_SESSION['signup_data'] = [
            'username' => $username,
            'email' => $email
        ];
        header("Location: ../auth/register.php");
        exit();
    }
}
$connection->close();
?>
