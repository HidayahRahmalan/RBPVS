<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $nama_tugasan = mysqli_real_escape_string($conn, $_POST['namaTugasan']);
    $deskripsi_tugasan = mysqli_real_escape_string($conn, $_POST['deskripsiTugasan']);
    $tarikh_due = $_POST['tarikhDue']; 
    $jenis_tugasan = $_POST['jenisTugasan'];

    $target_dir = "../uploads/"; 
    $lampiran_path = ""; 

    // Handle file upload (if any)
    if (isset($_FILES["lampiranPath"]) && $_FILES["lampiranPath"]["error"] == 0) {
        $original_filename = basename($_FILES["lampiranPath"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size (adjust limit as needed)
        if ($_FILES["lampiranPath"]["size"] > 5000000) { 
            echo "Error: File terlalu besar. Ukuran maksimum yang diizinkan adalah 5MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats (adjust as needed)
        $allowed_types = array( "pdf");
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Hanya file  PDF yang diizinkan.";
            $uploadOk = 0;
        }

        // Handle file name conflicts (rename if necessary)
        $counter = 1;
        while (file_exists($target_file)) {
            $filename_without_ext = pathinfo($original_filename, PATHINFO_FILENAME);
            $new_filename = $filename_without_ext . "_" . $counter . "." . $fileType;
            $target_file = $target_dir . $new_filename;
            $counter++;
        }

        if ($uploadOk == 0) {
            echo "Error: File Anda tidak terunggah.";
        } else {
            if (move_uploaded_file($_FILES["lampiranPath"]["tmp_name"], $target_file)) {
                $lampiran_path = $target_file; 
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
            }
        }
    } 

    // Insert data into the database
    $sql = "INSERT INTO tugasan (nama_tugasan, deskripsi_tugasan, jenis_tugasan, sijil_path, tarikh_due) 
            VALUES ('$nama_tugasan', '$deskripsi_tugasan', '$jenis_tugasan', '$lampiran_path', '$tarikh_due')";



    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; 
        echo "Projek baru berjaya ditambah!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>