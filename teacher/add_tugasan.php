<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $nama_tugasan = mysqli_real_escape_string($conn, $_POST['namaTugasan']);
    $deskripsi_tugasan = mysqli_real_escape_string($conn, $_POST['deskripsiTugasan']);
    $tarikh_due = $_POST['tarikhDue']; 
    $jenis_tugasan = $_POST['jenisTugasan'];


    // Insert data into the database
    $sql = "INSERT INTO tugasan (nama_tugasan, deskripsi_tugasan, jenis_tugasan, tarikh_due) 
            VALUES ('$nama_tugasan', '$deskripsi_tugasan', '$jenis_tugasan', '$tarikh_due')";



    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; 
        echo "Projek baru berjaya ditambah!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>