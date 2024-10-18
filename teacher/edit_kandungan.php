<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $kandungan_id = intval($_POST['kandungan_id']);
    $nama_kandungan = mysqli_real_escape_string($conn, $_POST['nama_kandungan']);
    $deskripsi_kandungan = mysqli_real_escape_string($conn, $_POST['deskripsi_kandungan']);
    $urutan_kandungan = intval($_POST['urutan_kandungan']); 

    $target_dir = "../uploads/"; 
    $kandungan_path = ""; 

    // Handle file upload if a new file is selected
    if (isset($_FILES["kandungan_path"]) && $_FILES["kandungan_path"]["error"] == 0) {
        $original_filename = basename($_FILES["kandungan_path"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size 
        if ($_FILES["kandungan_path"]["size"] > 5000000) { 
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
            if (move_uploaded_file($_FILES["kandungan_path"]["tmp_name"], $target_file)) {
                $kandungan_path = $target_file; 

                // Delete the old file if it exists and is not the same as the new one
                $old_path = $_POST['oldKandunganPath']; // Assuming you're passing the old path from the form
                if ($old_path != $kandungan_path && file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
            }
        }
    } else {
        // If no new file is uploaded, keep the existing path
        $kandungan_path = $_POST['oldKandunganPath']; 
    }

    // Fetch the original kandungan_path from the database
$sql_original_path = "SELECT kandungan_path FROM KANDUNGAN WHERE kandungan_id = $kandungan_id";
$result_original_path = $conn->query($sql_original_path);
if ($result_original_path->num_rows > 0) {
    $row_original_path = $result_original_path->fetch_assoc();
    $original_kandungan_path = $row_original_path['kandungan_path'];
} else {
    echo "Error: Kandungan tidak ditemukan.";
    exit;
}

if (empty($kandungan_path)) {
    // If no new file is uploaded, use the original path from the database
    $kandungan_path = $original_kandungan_path; 
} else {
    // If a new file is uploaded, delete the old file if it exists
    if ($original_kandungan_path != $kandungan_path && file_exists($original_kandungan_path)) {
        unlink($original_kandungan_path);
    }
}

    // Update data in the database
    $sql = "UPDATE KANDUNGAN 
            SET NAMA_KANDUNGAN='$nama_kandungan', DESKRIPSI_KANDUNGAN='$deskripsi_kandungan', 
                KANDUNGAN_PATH='$kandungan_path', URUTAN_KANDUNGAN=$urutan_kandungan 
            WHERE kandungan_id = $kandungan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Kandungan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>