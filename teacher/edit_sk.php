<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sk_id = $_POST['editSkID'];
    $nama_sk = $_POST['editNamaSK'];
    $urutan_sk = intval($_POST['editUrutanSK']);

    $sql = "UPDATE standard_kandungan 
            SET nama_sk='$nama_sk', urutan_sk=$urutan_sk, kod_sk=$urutan_sk  
            WHERE sk_id = $sk_id";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Kandungan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>