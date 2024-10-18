<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kumpulan_id = $_POST['kumpulan_id'];

    // Check if pelajar_ids is set and is an array
    if (isset($_POST['pelajar_ids']) && is_array($_POST['pelajar_ids'])) {
        $pelajar_ids = $_POST['pelajar_ids'];
    } else {
        $pelajar_ids = []; 
    }

    // Fetch the maximum_ahli for this group
    $sql_get_max_ahli = "SELECT maksimum_ahli FROM kumpulan WHERE kumpulan_id = $kumpulan_id";
    $result_max_ahli = $conn->query($sql_get_max_ahli);
    $row_max_ahli = $result_max_ahli->fetch_assoc();
    $maksimum_ahli = $row_max_ahli['maksimum_ahli'];

    // Validate if the number of selected students exceeds the maximum allowed
    if (count($pelajar_ids) > $maksimum_ahli) {
        echo "Jumlah ahli kumpulan melebihi  maksimum ($maksimum_ahli).";
        exit;
    }

    // Delete existing group memberships for this group
    $sql_delete_memberships = "DELETE FROM ahli_kumpulan WHERE kumpulan_id = $kumpulan_id";
    $conn->query($sql_delete_memberships);

    // Insert new group memberships
    if (!empty($pelajar_ids)) {
        foreach ($pelajar_ids as $pelajar_id) {
            $sql_insert_membership = "INSERT INTO ahli_kumpulan (pelajar_id, kumpulan_id) 
                                      VALUES ($pelajar_id, $kumpulan_id)";
            $conn->query($sql_insert_membership);
        }
    }

    echo "Keahlian kumpulan berhasil diperbarui!"; 
}

$conn->close();
?>