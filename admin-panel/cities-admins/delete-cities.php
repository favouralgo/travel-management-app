<?php
require "../../config/connection.php";
session_start();

if (!isset($_SESSION["adminname"])) {
    header("location: " . ADMINURL);
    exit();
}

header('Content-Type: application/json');

// Start output buffering to capture any unexpected output
ob_start();

$response = ['status' => 'error', 'message' => 'Unknown error occurred.'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    try {
        // Fetch the image associated with the region
        $stmt = $connection->prepare("SELECT image FROM cities WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $getImage = $result->fetch_object();
        
        if ($getImage && !empty($getImage->image) && file_exists("uploads/" . $getImage->image)) {
            if (!unlink("uploads/" . $getImage->image)) {
                throw new Exception('Error deleting image file.');
            }
        }
        
        // Delete the region
        $deleteStmt = $connection->prepare("DELETE FROM cities WHERE id=?");
        $deleteStmt->bind_param('i', $id);
        if ($deleteStmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Region deleted successfully.';
        } else {
            throw new Exception('Error deleting record: ' . $connection->error);
        }
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'ID parameter missing.';
}

// Get any unexpected output
$unexpected_output = ob_get_clean();
if (!empty($unexpected_output)) {
    $response['debug'] = $unexpected_output;
}

// Send the response
echo json_encode($response);
exit();