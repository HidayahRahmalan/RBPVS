<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Or 'DELETE' if your server setup requires it
    $submission_id = $_POST['submission_id'];

    // You might want to add checks here to ensure the user has permission to delete this submission

    // Get the file path from the database
    $sql = "SELECT penyerahan_path1 FROM penyerahan WHERE penyerahan_id = $submission_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['penyerahan_path1'];

        // Delete the file
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Delete the submission from the database
    $sql = "DELETE FROM penyerahan WHERE penyerahan_id = $submission_id";

    if ($conn->query($sql) === TRUE) {
        echo "Penyerahan berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>