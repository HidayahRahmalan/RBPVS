<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'connect.php';

if (isset($_POST['tugasan_id'])) {
    $tugasan_id = intval($_POST['tugasan_id']);

    $sql = "SELECT 
                p.nama_pelajar, 
                k.nama_kumpulan, 
                py.penyerahan_id, 
                py.rubrik_id, 
                r.markah 
            FROM pelajar p
            LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.tugasan_id = ?
            LEFT JOIN kumpulan k ON py.kumpulan_id = k.kumpulan_id
            LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tugasan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $studentData = array();
    while ($row = $result->fetch_assoc()) {
        $studentData[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($studentData);
}
?>