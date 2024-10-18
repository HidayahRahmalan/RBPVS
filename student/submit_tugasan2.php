<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tugasan_id = $_POST['tugasan_id'];

    // Get the student ID from the session (you'll need to implement how you store this)
    $pelajar_id = $_SESSION['id']; 

    $target_dir = "../uploads/"; 
    $file_path = ""; 
    $uploadOk = true; // Flag variable to indicate upload success

    // Handle file upload
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $original_filename = basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $original_filename;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check file size (adjust limit as needed)
        if ($_FILES["file"]["size"] > 5000000) { 
            echo "Error: File terlalu besar. Ukuran maksimum yang diizinkan adalah 5MB.";
            $uploadOk = false;
        }

        // Allow certain file formats (adjust as needed)
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Hanya file JPG, JPEG, PNG, GIF, PDF, DOC, dan DOCX yang diizinkan.";
            $uploadOk = false;
        }

        // Handle file name conflicts (rename if necessary)
        $counter = 1;
        while (file_exists($target_file)) {
            $filename_without_ext = pathinfo($original_filename, PATHINFO_FILENAME);
            $new_filename = $filename_without_ext . "_" . $counter . "." . $fileType;
            $target_file = $target_dir . $new_filename;
            $counter++;
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $file_path = $target_file; 
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
                $uploadOk = false;
            }
        }
    } else {
        echo "Error: Tidak ada file yang diunggah.";
        $uploadOk = false;
    }

    if ($uploadOk) {
        // Check if the assignment is individual or group
        $sql_tugasan = "SELECT jenis_tugasan FROM tugasan WHERE tugasan_id = $tugasan_id";
        $result_tugasan = $conn->query($sql_tugasan);
        $row_tugasan = $result_tugasan->fetch_assoc();
        $jenis_tugasan = $row_tugasan['jenis_tugasan'];

        if ($jenis_tugasan == 'individu') {
            // If individual assignment, insert submission directly for the student
            $sql = "UPDATE penyerahan
            SET penyerahan_path2 = '$file_path', tarikh_penyerahan2 = NOW()
            WHERE pelajar_id = $pelajar_id AND tugasan_id = $tugasan_id";

            if ($conn->query($sql) === TRUE) {
                echo "Penyerahan berhasil!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
 } else { // Group assignment
    // Get the student's group ID
    $sql_kumpulan = "SELECT k.kumpulan_id 
                     FROM ahli_kumpulan ak 
                     JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                     WHERE ak.pelajar_id = $pelajar_id";
    $result_kumpulan = $conn->query($sql_kumpulan);
    $kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];

    // Check if the group has already submitted
    $sql_submission = "SELECT * FROM penyerahan 
                       WHERE tugasan_id = $tugasan_id AND kumpulan_id = $kumpulan_id";
    $result_submission = $conn->query($sql_submission);

    if ($result_submission->num_rows > 0) {
        echo "Error: Kumpulan Anda telah menghantar tugasan ini sebelumnya.";
    } else {
        // Insert the submission for the group
        $sql = "UPDATE penyerahan
        SET penyerahan_path2 = '$file_path', tarikh_penyerahan2 = NOW()
        WHERE kumpulan_id = $kumpulan_id AND tugasan_id = $tugasan_id";

        if ($conn->query($sql) === TRUE) {
            echo "Penyerahan kumpulan berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
    }
}

$conn->close();
?>