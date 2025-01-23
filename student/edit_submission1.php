<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input 
    $penyerahan_id = filter_var($_POST['submission_id'], FILTER_VALIDATE_INT);
    if ($penyerahan_id === false) {
        echo "Error: Invalid submission ID.";
        exit;
    }

    $target_dir = "../uploads/"; 
    $file_path = ""; 
    $uploadOk = true; // Flag variable to indicate upload success

    // Handle file upload if a new file is selected
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $original_filename = basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $original_filename;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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

                // Delete the old file if it exists and is not the same as the new one
                $old_path = $_POST['oldFilePath']; 
                if ($old_path != $file_path && file_exists($old_path)) {
                    if (!unlink($old_path)) {
                        echo "Error: Unable to delete old file.";
                        $uploadOk = false;
                    }
                }
            } else {
                echo "Error: Terjadi kesalahan saat mengunggah file Anda.";
                $uploadOk = false;
            }
        }
    } else {
        // If no new file is uploaded, keep the existing path
        $file_path = $_POST['oldFilePath']; 
    }

    if ($uploadOk) {
        // Update data in the database
        $stmt = $conn->prepare("UPDATE penyerahan
        SET penyerahan_path1 = ?, tarikh_penyerahan1 = NOW()
        WHERE penyerahan_id = ?");
            $stmt->bind_param("si", $file_path, $penyerahan_id);

        if ($stmt->execute() === TRUE) {
            echo "Penyerahan berjaya dikemaskini!";
        } else {
            // Log the error for debugging
            error_log("Error updating submission: " . $conn->error);

            // Provide a more user-friendly error message
            echo "Error: Maaf, terjadi kesalahan saat memperbarui penyerahan Anda. Silakan cuba lagi.";
        }
    }
}

$conn->close();
?>