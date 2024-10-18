<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST['url'];
    $tugasan_id = $_POST['tugasan_id'];

    // Get the student ID from the session (you'll need to implement how you store this)
    $pelajar_id = $_SESSION['id']; 

    // Check if the assignment is individual or group
    $sql_tugasan = "SELECT jenis_tugasan FROM tugasan WHERE tugasan_id = $tugasan_id";
    $result_tugasan = $conn->query($sql_tugasan);
    $row_tugasan = $result_tugasan->fetch_assoc();
    $jenis_tugasan = $row_tugasan['jenis_tugasan'];

    if ($jenis_tugasan == 'individu') {
        // If individual assignment, update submission directly for the student
        $sql = "UPDATE penyerahan SET url_video = '$url'
                WHERE pelajar_id = $pelajar_id AND tugasan_id = $tugasan_id";

        if ($conn->query($sql) === TRUE) {
            echo "Penyerahan berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else { // Group assignment
        // Get the student's group ID
        $sql_kumpulan = "SELECT k.kumpulan_id 
                         FROM ahli_kumpulan ak 
                         JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                         WHERE ak.pelajar_id = $pelajar_id";
        $result_kumpulan = $conn->query($sql_kumpulan);
        $kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];

        // Update the submission for the group
        $sql = "UPDATE penyerahan SET url_video = '$url'
                WHERE kumpulan_id = $kumpulan_id AND tugasan_id = $tugasan_id";

        if ($conn->query($sql) === TRUE) {
            echo "Penyerahan kumpulan berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>