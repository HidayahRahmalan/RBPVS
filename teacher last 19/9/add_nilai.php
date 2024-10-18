<?php
session_start();
include 'connect.php';

// Get the form data
$penyerahan_id = $_POST['penyerahan_id'];
$nama_pelajar = $_POST['nama_pelajar'];
$rubrik_id = $_POST['rubrik_id'];



// Check if the penyerahan_id exists in the database
$stmt = $conn->prepare("SELECT * FROM penyerahan WHERE penyerahan_id = ?");
$stmt->bind_param("i", $penyerahan_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo "Error: Penyerahan ID not found.";
  exit;
}

// Update the penyerahan table with the rubrik_id
$stmt = $conn->prepare("UPDATE penyerahan SET rubrik_id = ? WHERE penyerahan_id = ?");
$stmt->bind_param("ii", $rubrik_id, $penyerahan_id);
$stmt->execute();

if ($stmt->affected_rows == 1) {
  echo "Markah berjaya update!";
} else {
  echo "Error: Failed to update penyerahan.";
}
?>