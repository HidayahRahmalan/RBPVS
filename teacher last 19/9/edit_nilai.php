<?php
session_start();

// Include the database connection file
require_once 'connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $penyerahan_id = $_POST["penyerahan_id"];
  $rubrik_id = $_POST["rubrik_id"];

  // Validate the input data
  if (empty($penyerahan_id) || empty($rubrik_id)) {
    echo "Error: Missing input data.";
    exit;
  }

  // Update the rubrik_id in the database
  $sql = "UPDATE penyerahan SET rubrik_id = ? WHERE penyerahan_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $rubrik_id, $penyerahan_id);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->affected_rows > 0) {
    echo "Rubrik berjaya dikemaskini!";
  } else {
    echo "Error: Unable to update rubrik_id.";
    echo "penyerahan_id: $penyerahan_id, rubrik_id: $rubrik_id";
    echo "Error message: " . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>