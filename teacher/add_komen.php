<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Process the form data
$penyerahan_id = $_POST['penyerahan_id'];
$komen = $_POST['komen'];

// Update the komen in the database
$sql = "UPDATE penyerahan SET komen = '$komen' WHERE penyerahan_id = '$penyerahan_id'";

if ($conn->query($sql) === TRUE) {
    echo "Komen berjaya ditambah!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();
?>