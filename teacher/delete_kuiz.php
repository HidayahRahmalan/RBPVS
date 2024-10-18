<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kuiz_id = $_POST['kuiz_id']; 

    // Check if the kuiz has any kandungan
    $sql_check = "SELECT kandungan_kuiz_id FROM kandungan_kuiz WHERE kuiz_id = $kuiz_id";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Kuiz ini mempunyai kandungan dan tidak boleh dihapuskan.";
    } else {
        $sql = "DELETE FROM kuiz WHERE kuiz_id = $kuiz_id";

        if ($conn->query($sql) === TRUE) {
            echo "Kuiz berjaya dihapus!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>