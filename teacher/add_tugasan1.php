<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $nama_tugasan = mysqli_real_escape_string($conn, $_POST['namaTugasan']);
    $deskripsi_tugasan = mysqli_real_escape_string($conn, $_POST['deskripsiTugasan']);
    $tarikh_due = $_POST['tarikhDue']; 


    // Insert data into the database
    $sql = "INSERT INTO projek (nama_projek, deskripsi_projek, tarikh_due) 
            VALUES ('$nama_tugasan', '$deskripsi_tugasan', '$tarikh_due')";



    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; 
        echo "Tugasan baru berjaya ditambah!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>