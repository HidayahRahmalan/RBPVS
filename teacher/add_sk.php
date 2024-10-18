<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_sk = $_POST['namaSK'];
    $urutan_sk = intval($_POST['urutanSK']); 
    $cikgu_id = $_SESSION['id']; // Retrieve from session

    $sql = "INSERT INTO standard_kandungan (nama_sk, kod_sk, urutan_sk, cikgu_id) 
            VALUES ('$nama_sk', $urutan_sk, $urutan_sk, $cikgu_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Kandungan baru berjaya ditambah!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>