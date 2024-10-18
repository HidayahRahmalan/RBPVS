<?php
session_start();
include 'connect.php';

if (isset($_POST['submit'])) {
    $nama_kumpulan = $_POST['nama_kumpulan'];

    $sql = "INSERT INTO kumpulan (nama_kumpulan) VALUES ('$nama_kumpulan')";
    $result = $conn->query($sql);

    if ($result) {
        echo "Group created successfully!";
    } else {
        echo "Error creating group: " . $conn->error;
    }
}

?>

<form action="create_group.php" method="post">
    <label for="nama_kumpulan">Nama Kumpulan:</label>
    <input type="text" id="nama_kumpulan" name="nama_kumpulan"><br><br>
    <input type="submit" name="submit" value="Create Group">
</form>