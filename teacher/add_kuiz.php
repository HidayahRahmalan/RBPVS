<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kuiz = $_POST['nama_kuiz'];
    $deskripsi_kuiz = $_POST['deskripsi_kuiz'];


    $sql = "INSERT INTO KUIZ (nama_kuiz, deskripsi_kuiz) 
            VALUES ('$nama_kuiz', '$deskripsi_kuiz')";

    if ($conn->query($sql) === TRUE) {
        echo "Kuiz baru berjaya ditambah!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>