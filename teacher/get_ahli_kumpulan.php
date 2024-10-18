<?php
session_start();
include 'connect.php';

if (isset($_GET['kumpulan_id'])) {
    $kumpulan_id = intval($_GET['kumpulan_id']);

    // Fetch students already in this group
    $sql_ahli = "SELECT p.* 
                 FROM ahli_kumpulan ak
                 JOIN pelajar p ON ak.pelajar_id = p.pelajar_id
                 WHERE ak.kumpulan_id = $kumpulan_id";
    $result_ahli = $conn->query($sql_ahli);

    if ($result_ahli->num_rows > 0) {
        while ($row_ahli = $result_ahli->fetch_assoc()) {
            echo "<option value='" . $row_ahli['pelajar_id'] . "'>" . $row_ahli['nama_pelajar'] . "</option>";
        }
    } 
}

$conn->close();
?>