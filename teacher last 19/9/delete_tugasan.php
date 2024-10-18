<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Or 'DELETE' if your server setup requires it
    $tugasan_id = $_POST['tugasan_id'];

    // You might want to add checks here to ensure the user has permission to delete this assignment

    $sql = "DELETE FROM tugasan WHERE tugasan_id = $tugasan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tugasan berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>