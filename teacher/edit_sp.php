<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sp_id = $_POST['editSpID'];
    $nama_sp = $_POST['editNamaSP'];
    $deskripsi_sp = $_POST['editDeskripsiSP'];
    $urutan_sp = $_POST['editUrutanSP'];

    // Sanitize and validate input here (implementation depends on your specific sanitization/validation methods)

    $sql = "UPDATE standard_pembelajaran 
            SET NAMA_SP='$nama_sp', DESKRIPSI_SP='$deskripsi_sp', URUTAN_SP=$urutan_sp 
            WHERE sp_id = $sp_id";

    if ($conn->query($sql) === TRUE) {
        echo "Standard Pembelajaran berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>