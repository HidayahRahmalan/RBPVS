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

    $target_dir = "../uploads/"; 
    $lampiran_path = ""; 

    // Handle file upload if a new file is selected
    if (isset($_FILES["editLampiranPath"]) && $_FILES["editLampiranPath"]["error"] == 0) {
        $original_filename = basename($_FILES["editLampiranPath"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size 
        if ($_FILES["editLampiranPath"]["size"] > 5000000) { 
            echo "Error: File terlalu besar. Ukuran maksimum yang diizinkan adalah 5MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Hanya file JPG, JPEG, PNG, GIF, PDF, DOC, dan DOCX yang diizinkan.";
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
            if (move_uploaded_file($_FILES["editLampiranPath"]["tmp_name"], $target_file)) {
                $lampiran_path = $target_file; 

                // Delete the old file if it exists and is not the same as the new one
                $old_path = $_POST['oldLampiranPath']; 
                if ($old_path != $lampiran_path && file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
            }
        }
    } else {
        // If no new file is uploaded, keep the existing path
        $lampiran_path = $_POST['oldLampiranPath']; 
    }

    // Update data in the database
    $sql = "UPDATE tugasan 
            SET nama_tugasan='$nama_tugasan', deskripsi_tugasan='$deskripsi_tugasan', 
                jenis_tugasan='$jenis_tugasan', lampiran_path='$lampiran_path', tarikh_due='$tarikh_due'
            WHERE tugasan_id = $tugasan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tugasan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>