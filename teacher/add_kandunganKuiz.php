<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deskripsi_kandungan = $conn->real_escape_string($_POST['deskripsi_kandungan']);
    $pautanURL = $conn->real_escape_string($_POST['pautan_URL']);
    $urutan_kandungan = intval($_POST['urutanKandungan']);
    $kuiz_id = intval($_POST['kuiz_id']);

    $target_dir = "../uploads/"; 
    $kandungan_path = "";

    if (isset($_FILES["kandunganPath"]) && $_FILES["kandunganPath"]["error"] === UPLOAD_ERR_OK) {
        $original_filename = basename($_FILES["kandunganPath"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["kandunganPath"]["size"] > 500000000) { 
            echo "Error: File terlalu besar. Ukuran maksimum yang diizinkan adalah 5MB.";
            $uploadOk = 0;
        }

        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "mp4");
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Hanya file JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, dan MP4 yang diizinkan.";
            $uploadOk = 0;
        }

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
    }

    $sql = "INSERT INTO kandungan_kuiz (deskripsi_kandungan, pautan_url, kandungan_path, urutan_kandungan, kuiz_id) 
            VALUES ('$deskripsi_kandungan', '$pautanURL', '$kandungan_path', $urutan_kandungan, $kuiz_id)"; 

    if ($conn->query($sql) === TRUE) {
        echo "Kandungan baru berjaya ditambah!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
}

$conn->close();
?>