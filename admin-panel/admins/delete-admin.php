<?php
require "../../config/connection.php";

// Ensure the session is started and the user is logged in
session_start();

if (!isset($_SESSION["adminname"]) || !isset($_POST["admin_id"])) {
    header("Location: ".ADMINURL."");
    exit();
}

// Get current admin's role
$currentAdminQuery = "SELECT role FROM admins WHERE adminname = ?";
$stmt = $connection->prepare($currentAdminQuery);
$stmt->bind_param("s", $_SESSION["adminname"]);
$stmt->execute();
$currentAdminResult = $stmt->get_result();
$currentAdmin = $currentAdminResult->fetch_assoc();
$stmt->close();

// Check if current admin is Super Admin
$isSuperAdmin = ($currentAdmin["role"] == 1);

if ($isSuperAdmin) {
    $admin_id = $_POST["admin_id"];
    
    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM admins WHERE id = ?";
    $stmt = $connection->prepare($deleteQuery);
    $stmt->bind_param("i", $admin_id);
    $result = $stmt->execute();
    $stmt->close();

    // Output handled using JSON with document object model
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Admin deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting admin']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized action']);
}
?>