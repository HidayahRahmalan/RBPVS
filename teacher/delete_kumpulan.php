<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $kumpulan_id = $_POST['kumpulan_id'];

        // Check if the group has any members
        $sql_count_members = "SELECT COUNT(*) as total_ahli FROM ahli_kumpulan WHERE kumpulan_id = $kumpulan_id";
        $result_count = $conn->query($sql_count_members);
        $row_count = $result_count->fetch_assoc();
        $total_ahli = $row_count['total_ahli'];
    
        if ($total_ahli > 0) {
            echo " Kumpulan tidak boleh dihapus kerana mempunyai ahli anggota.";
            exit;
        }


    $sql_delete_memberships = "DELETE FROM ahli_kumpulan WHERE kumpulan_id = $kumpulan_id";
    $conn->query($sql_delete_memberships);

    $sql = "DELETE FROM kumpulan WHERE kumpulan_id = $kumpulan_id";

    if ($conn->query($sql) === TRUE) {
        echo "Kumpulan berjaya dihapus!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>