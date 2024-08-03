<?php
session_start();
require '../config/connection.php';

// Define APPURL
define("APPURL", "http://51.20.181.20/wooxtravel/");
$errors = []; // Initialize errors array
$response = ['success' => false, 'errors' => [], 'message' => '']; // Initialize response array

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
    } elseif (is_numeric($username)) {
        $errors[] = "Your name should not be numbers only.";
    } elseif (is_numeric($email)) {
        $errors[] = "Email cannot be numeric.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@(yahoo\.com|gmail\.com)$/", $email)) {
        $errors[] = "Email must end with @yahoo.com or @gmail.com.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } elseif (strlen($password) < 8 || 
            !preg_match('/[A-Z]/', $password) || 
            !preg_match('/[a-z]/', $password) || 
            !preg_match('/[0-9]/', $password) || 
            !preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one digit, and one special character.";
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
                $response['success'] = true;
                $response['message'] = "Registration successful! You can now sign in.";
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
        }
    }

    if (count($errors) > 0){
        $response['errors'] = $errors;
    }
}

$connection->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>