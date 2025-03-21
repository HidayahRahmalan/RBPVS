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


            // If individual assignment, insert submission directly for the student
            $sql = "INSERT INTO penyerahan (pelajar_id, projek_id, penyerahan_path1, tarikh_penyerahan1) 
                    VALUES ($pelajar_id, $tugasan_id, '$file_path', NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "Penyerahan berhasil!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

}
$conn->close();
?>