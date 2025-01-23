<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kandungan_tugasan_id = intval($_POST['kandungan_tugasan_id']);
    $deskripsi_kandungan = $conn->real_escape_string($_POST['deskripsi_kandungan']);
    $urutan_kandungan = intval($_POST['urutan_kandungan']);
    $pautan_url = $conn->real_escape_string($_POST['pautan_url']);

    $target_dir = "../uploads/"; 
    $kandungan_path = ""; 

    if (isset($_FILES["kandunganPath"]) && $_FILES["kandunganPath"]["error"] == 0) {
        $original_filename = basename($_FILES["kandunganPath"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["kandunganPath"]["size"] > 5000000) { 
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
        } else {
            if (move_uploaded_file($_FILES["kandunganPath"]["tmp_name"], $target_file)) {
                $kandungan_path = $target_file; 

                $old_path = $_POST['oldKandunganPath']; 
                if ($old_path != $kandungan_path && file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
            }
        }
    } else {
        $kandungan_path = $_POST['oldKandunganPath']; 
    }

    // Fetch the original kandungan_path from the database
    $sql_original_path = "SELECT kandungan_path FROM kandungan_projek WHERE kandungan_projek_id = $kandungan_tugasan_id";
    $result_original_path = $conn->query($sql_original_path);
    if ($result_original_path->num_rows > 0) {
        $row_original_path = $result_original_path->fetch_assoc();
        $original_kandungan_path = $row_original_path['kandungan_path'];
    } else {
        echo "Error: Kandungan tidak ditemukan.";
        exit;
    }

    if (empty($kandungan_path)) {
        $kandungan_path = $original_kandungan_path; 
    } else {
        if ($original_kandungan_path != $kandungan_path && file_exists($original_kandungan_path)) {
            unlink($original_kandungan_path);
        }
    }

    $sql = "UPDATE kandungan_projek 
            SET deskripsi_kandungan = '$deskripsi_kandungan', 
                kandungan_path = '$kandungan_path', 
                urutan_kandungan = $urutan_kandungan,
                pautan_url = '$pautan_url' 
            WHERE kandungan_projek_id = $kandungan_tugasan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Kandungan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>