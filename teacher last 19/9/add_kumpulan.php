<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input (implementation depends on your specific sanitization/validation methods)
    $nama_kumpulan = $_POST['namaKumpulan'];
    $maksimum_ahli = intval($_POST['maxAhli']);

    $sql = "INSERT INTO kumpulan (nama_kumpulan, maksimum_ahli) 
            VALUES ('$nama_kumpulan', $maksimum_ahli)";

    if ($conn->query($sql) === TRUE) {
        echo "Kumpulan baru berjaya ditambah!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>