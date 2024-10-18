<?php
session_start();
include 'connect.php';

// Check if 'id' is set in the query parameters
if (isset($_GET['id'])) {
    $kumpulan_id = $_GET['id'];

    // Fetch the group details
    $sql_kumpulan = "SELECT * FROM kumpulan WHERE kumpulan_id = $kumpulan_id";
    $result_kumpulan = $conn->query($sql_kumpulan);

    if ($result_kumpulan->num_rows > 0) {
        $row_kumpulan = $result_kumpulan->fetch_assoc();

        // Fetch all students
        $sql_pelajar = "SELECT * FROM pelajar";
        $result_pelajar = $conn->query($sql_pelajar);

        // Fetch students already in this group
        $sql_ahli = "SELECT pelajar_id FROM ahli_kumpulan WHERE kumpulan_id = $kumpulan_id";
        $result_ahli = $conn->query($sql_ahli);
        $existingMemberIds = [];
        while ($member_row = $result_ahli->fetch_assoc()) {
            $existingMemberIds[] = $member_row['pelajar_id'];
        }
    } else {
        echo "Kumpulan tidak dijumpai.";
        exit;
    }
} else {
    echo "ID kumpulan tidak disediakan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kumpulan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        main {
            background-color: #e0f2ff; 
        }
    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">
            <h1 class="text-center mb-4">Edit Kumpulan</h1>

            <div class="card">
                <div class="card-body">
                    <form id="editGroupForm">
                        <div class="form-group">
                            <label for="editNamaKumpulan">Nama Kumpulan:</label>
                            <input type="text" class="form-control" id="editNamaKumpulan" name="editNamaKumpulan" value="<?= $row_kumpulan['nama_kumpulan'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="editMaxAhli">Maksimum Ahli:</label>
                            <input type="number" class="form-control" id="editMaxAhli" name="editMaxAhli" value="<?= $row_kumpulan['maksimum_ahli'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="editGroupMembers">Ahli Kumpulan:</label>
                            <select class="form-control" id="editGroupMembers" name="editGroupMembers[]" multiple required>
                                <?php while ($row_pelajar = $result_pelajar->fetch_assoc()): 
                                    $selected = in_array($row_pelajar['pelajar_id'], $existingMemberIds) ? 'selected' : '';
                                ?>
                                    <option value="<?= $row_pelajar['pelajar_id'] ?>" <?= $selected ?>><?= $row_pelajar['nama_pelajar'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <input type="hidden" id="editGroupId" name="editGroupId" value="<?= $kumpulan_id ?>">
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn btn-primary" form="editGroupForm">Simpan Perubahan</button>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Handle 'editGroupForm' submission
document.getElementById('editGroupForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('update_group.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        // You might want to refresh the page or update the group list dynamically here
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully
    });
});
</script>

</html>