<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kuiz_id = $_POST['kuiz_id'];
    $nama_kuiz = $_POST['nama_kuiz'];
    $deskripsi_kuiz = $_POST['deskripsi_kuiz'];

    $sql = "UPDATE kuiz 
            SET nama_kuiz='$nama_kuiz', deskripsi_kuiz = '$deskripsi_kuiz'  
            WHERE kuiz_id = $kuiz_id";

    if ($conn->query($sql) === TRUE) {
        echo "Kuiz berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>