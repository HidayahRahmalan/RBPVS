<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kumpulan_id = $_POST['editGroupId'];
    $nama_kumpulan = $_POST['editNamaKumpulan'];
    $new_maksimum_ahli = intval($_POST['editMaxAhli']);

    // Fetch the current number of members in the group
    $sql_count_ahli = "SELECT COUNT(*) as total_ahli FROM ahli_kumpulan WHERE kumpulan_id = $kumpulan_id";
    $result_count_ahli = $conn->query($sql_count_ahli);
    $row_count_ahli = $result_count_ahli->fetch_assoc();
    $current_total_ahli = $row_count_ahli['total_ahli'];

    // Validate if new maximum is less than current members
    if ($new_maksimum_ahli < $current_total_ahli) {
        echo " Maksimum ahli tidak boleh kurang dari jumlah ahli saat ini ($current_total_ahli).";
        exit;
    }

    // Update group details
    $sql_update_group = "UPDATE kumpulan 
                         SET nama_kumpulan='$nama_kumpulan', maksimum_ahli=$new_maksimum_ahli 
                         WHERE kumpulan_id = $kumpulan_id";

    if ($conn->query($sql_update_group) === TRUE) {
        echo "Kumpulan berjaya dikemaskini!";
    } else {
        echo "Error: " . $sql_update_group . "<br>" . $conn->error;
    }
}

$conn->close();
?>