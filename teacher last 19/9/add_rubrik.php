<?php
session_start();
include 'connect.php'; 

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and validate input (adjust as needed)
    $nama_rubrik = $conn->real_escape_string($_POST['nama_rubrik']);
    $deskripsi_rubrik = $conn->real_escape_string($_POST['deskripsi_rubrik']);
    $markah = intval($_POST['markah']);

    // Prepare and execute the SQL query to insert the new rubric
    $sql = "INSERT INTO rubrik (nama_rubrik, deskripsi_rubrik, markah) 
            VALUES ('$nama_rubrik', '$deskripsi_rubrik', $markah)";

    if ($conn->query($sql) === TRUE) {
        $response = array('success' => true, 'message' => 'Rubrik baru berjaya ditambah!');
    } else {
        $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
    }

    // Send the JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>