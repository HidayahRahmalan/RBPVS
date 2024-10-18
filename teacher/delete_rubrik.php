<?php
session_start();
include 'connect.php'; 

// Check if the rubrik_id is provided in the query string
if (isset($_GET['rubrik_id'])) {

    // Sanitize and validate input
    $rubrik_id = intval($_GET['rubrik_id']);

    // Prepare and execute the SQL query to delete the rubric
    $sql = "DELETE FROM rubrik WHERE rubrik_id=$rubrik_id";

    if ($conn->query($sql) === TRUE) {
        $response = array('success' => true, 'message' => 'Rubrik berjaya dipadam!');
    } else {
        $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
    }

    // Send the JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>