<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input pengguna (gunakan fungsi atau library yang sesuai)
    $nama_kandungan = mysqli_real_escape_string($conn, $_POST['namaKandungan']);
    $deskripsi_kandungan = mysqli_real_escape_string($conn, $_POST['deskripsiKandungan']);
    $urutan_kandungan = intval($_POST['urutanKandungan']); // Pastikan urutan_kandungan adalah integer
    $sp_id = intval($_POST['spIDForKandungan']); // Pastikan sp_id adalah integer

    $target_dir = "../uploads/"; 
    $kandungan_path = "";

    // Handle file upload jika ada
    if (isset($_FILES["kandunganPath"]) && $_FILES["kandunganPath"]["error"] === UPLOAD_ERR_OK) {
        $original_filename = basename($_FILES["kandunganPath"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size 
        if ($_FILES["kandunganPath"]["size"] > 500000000) { 
            echo "Error: File terlalu besar. Ukuran maksimum yang diizinkan adalah 5MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "mp4");
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Hanya file JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, dan MP4 yang diizinkan.";
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
            exit();
        } else {
            if (move_uploaded_file($_FILES["kandunganPath"]["tmp_name"], $target_file)) {
                $kandungan_path = $target_file; 
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
                exit();
            }
        }
    } else {
        echo "Error: File tidak terunggah.";
        exit();
    }

    // Insert data into the database
    $sql = "INSERT INTO KANDUNGAN (NAMA_KANDUNGAN, DESKRIPSI_KANDUNGAN, KANDUNGAN_PATH, URUTAN_KANDUNGAN, SP_ID) 
            VALUES ('$nama_kandungan', '$deskripsi_kandungan', '$kandungan_path', $urutan_kandungan, $sp_id)";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; 
        echo "Kandungan baru berjaya ditambah!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>