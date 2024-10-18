<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_rubrik = $conn->real_escape_string($_POST['nama_rubrik']);
    $deskripsi_rubrik = $conn->real_escape_string($_POST['deskripsi_rubrik']);
    $markahMin = intval($_POST['markahMin']);
    $markahMax = intval($_POST['markahMax']);

    // Validate input
    if ($markahMin > 100 || $markahMin < 1) {
        $response = array('success' => false, 'message' => 'Error: Markah minimum mestilah sekurang-kurangnya 1 hingga 100.');
    } elseif ($markahMax > 100 || $markahMax < 1) {
        $response = array('success' => false, 'message' => 'Error: Markah maksimum mestilah antara 0 hingga 100.');
    } else {
        $sql = "INSERT INTO rubrik (nama_rubrik, deskripsi_rubrik, markah_min, markah_max) 
                VALUES ('$nama_rubrik', '$deskripsi_rubrik', $markahMin, $markahMax)";

        if ($conn->query($sql) === TRUE) {
            $response = array('success' => true, 'message' => 'Rubrik baru berjaya ditambah!');
        } else {
            $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>