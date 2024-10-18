<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_sp = $_POST['namaSP'];
    $deskripsi_sp = $_POST['deskripsiSP'];
    $urutan_sp = $_POST['urutanSP'];
    $sk_id = $_POST['skID'];

    $sql = "INSERT INTO standard_pembelajaran (NAMA_SP, DESKRIPSI_SP, URUTAN_SP, SK_ID) 
            VALUES ('$nama_sp', '$deskripsi_sp', $urutan_sp, $sk_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Pembelajaran baru berjaya ditambah!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>