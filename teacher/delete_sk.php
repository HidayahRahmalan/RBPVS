<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sk_id = $_POST['sk_id']; 

    // You might want to add checks here to ensure the user has permission to delete this SK

    $sql = "DELETE FROM standard_kandungan WHERE sk_id = $sk_id";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Kandungan berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>