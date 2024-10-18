<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kandungan_id = $_POST['kandungan_id'];

    // Query to get the file path from the database
    $sql = "SELECT kandungan_path FROM KANDUNGAN WHERE kandungan_id = '$kandungan_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['kandungan_path'];

        // Delete the file
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Query to delete the Kandungan
    $sql = "DELETE FROM KANDUNGAN WHERE kandungan_id = '$kandungan_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Kandungan berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>