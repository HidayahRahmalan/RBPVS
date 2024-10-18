<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $penyerahan_id = filter_var($_POST['submission_id'], FILTER_VALIDATE_INT);

    if ($penyerahan_id === false) {
        echo "Error: Invalid submission ID.";
        exit;
    }

    // Get the new URL from the form data
    $new_url = $_POST['editUrl'];

    // Update data in the database (only update url)
    $stmt = $conn->prepare("UPDATE penyerahan SET url_video = ? WHERE penyerahan_id = ?");
    $stmt->bind_param("si", $new_url, $penyerahan_id);

    if ($stmt->execute() === TRUE) {
        echo "Pautan URL berjaya dikemaskini!";
    } else {
        // Log the error for debugging
        error_log("Error updating submission: " . $conn->error);

        // Provide a more user-friendly error message
        echo "Error: Maaf, terdapat ralat saat memperbarui ppautan URL Anda.";
    }
}

$conn->close();