<?php
session_start();
include 'connect.php';

// Get the form data
$penyerahan_id = $_POST['penyerahan_id'];
$markah = $_POST['markah'];

// Check if the penyerahan_id exists in the database
$stmt = $conn->prepare("SELECT * FROM penyerahan WHERE penyerahan_id = ?");
$stmt->bind_param("i", $penyerahan_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Error: Penyerahan ID not found.";
    exit;
}

// Fetch the rubrik_id based on the markah
$stmt = $conn->prepare("SELECT rubrik_id FROM rubrik WHERE markah_min <= ? AND markah_max >= ?");
$stmt->bind_param("ii", $markah, $markah);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Error: Markah tidak dapat dijumpai di dalam rubrik yang tersedia.";
    exit;
}

$row = $result->fetch_assoc();
$rubrik_id = $row['rubrik_id'];

// Update the penyerahan table with the rubrik_id and markah
$stmt = $conn->prepare("UPDATE penyerahan SET rubrik_id = ?, markah = ? WHERE penyerahan_id = ?");
$stmt->bind_param("iis", $rubrik_id, $markah, $penyerahan_id);
$stmt->execute();

if ($stmt->affected_rows == 1) {
    echo "Markah berjaya dikemaskini!";
} else {
    echo "Error: Gagal mengemaskini penyerahan.";
}
?>