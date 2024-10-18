<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sp_id = $_POST['sp_id'];

    $sql = "DELETE FROM standard_pembelajaran WHERE sp_id = $sp_id";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Pembelajaran berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>