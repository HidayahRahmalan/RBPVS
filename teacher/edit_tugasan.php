<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $tugasan_id = intval($_POST['editTugasanId']);
    $nama_tugasan = mysqli_real_escape_string($conn, $_POST['editNamaTugasan']);
    $deskripsi_tugasan = mysqli_real_escape_string($conn, $_POST['editDeskripsiTugasan']);
    $jenis_tugasan = $_POST['editJenisTugasan'];
    $tarikh_due = $_POST['editTarikhDue'];


    

    // Update data in the database
    $sql = "UPDATE tugasan 
            SET nama_tugasan='$nama_tugasan', deskripsi_tugasan='$deskripsi_tugasan', 
                jenis_tugasan='$jenis_tugasan', tarikh_due='$tarikh_due'
            WHERE tugasan_id = $tugasan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tugasan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>