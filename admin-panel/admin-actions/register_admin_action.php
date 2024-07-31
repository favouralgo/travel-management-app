<?php 
session_start();
require '../../config/connection.php';

// Define APPURL
define("ADMINURL", "http://localhost/wooxtravel/admin-panel");
$errors = []; // Initialize errors array

// Checks if user is already logged in
if (!isset($_SESSION['adminname'])) {
    header("Location: " . ADMINURL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $adminname = filter_input(INPUT_POST, 'adminname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // HTML Form Validation
    if (empty($adminname) || empty($email) || empty($password)|| empty($confirm_password)) {
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

    // Check for empty fields
    if (count($errors) == 0){
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Verify if user already exists
        $stmt = $connection->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Admin already exists";
        } else {       
            // Insert the new admin into the database with a role of 1 for super admins
            $stmt = $connection->prepare("INSERT INTO admins (adminname, email, mypassword, role) VALUES (?, ?, ?, 1)");
            $stmt->bind_param("sss", $adminname, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../admins/login-admins.php");
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
    header("Location: ../admins/register-admins.php");
    exit();
}
}
$connection->close();
?>