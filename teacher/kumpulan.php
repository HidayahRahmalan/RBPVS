<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

$sql_kumpulan = "SELECT * FROM kumpulan";
$result_kumpulan = $conn->query($sql_kumpulan);

// Fetch all students (pelajar)
$sql_pelajar = "SELECT * FROM pelajar";
$result_pelajar = $conn->query($sql_pelajar);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Kumpulan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

.card-header .btn-link {
    text-decoration: none; /* Remove underline from accordion button */
    color: #212529; /* Dark text color */
}

.card-header .btn-link:hover {
    text-decoration: none; /* Keep underline removed on hover */
}

.card-header .badge {
    background-color: #28a745; /* Green badge */
    font-size: 0.8rem;
}

/* Button styling */
.btn-primary {
    background-color: #4C97FF; /* Scratch-like blue */
    border-color: #4C97FF;
}

.btn-primary:hover {
    background-color: #337ab7; /* Slightly darker blue on hover */
    border-color: #2e6da4;
}

    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

        <?php include 'sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Senarai Kumpulan</li>
            </ol>
        </nav>

            <h1 class="text-center mb-4">Senarai Kumpulan</h1>

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addGroupModal">Tambah Kumpulan</button>
            <a href='add_pelajarGP.php' class='btn btn-secondary mb-3'>Tambah/Sunting Ahli Kumpulan</a>

            <?php if ($result_kumpulan->num_rows > 0): ?>
                <div id="accordion">
                    <?php 
                    $groupNumber = 1;
                    while ($row_kumpulan = $result_kumpulan->fetch_assoc()): 
                        $kumpulan_id = $row_kumpulan["kumpulan_id"];

                        // Fetch students in this group
                        $sql_ahli = "SELECT p.* 
                                     FROM ahli_kumpulan ak
                                     JOIN pelajar p ON ak.pelajar_id = p.pelajar_id
                                     WHERE ak.kumpulan_id = $kumpulan_id";
                        $result_ahli = $conn->query($sql_ahli);

                        // Count the number of members in this group
                        $total_ahli = $result_ahli->num_rows;
                    ?>
<div class="card mb-3"> <div class="card-header d-flex justify-content-between align-items-center" id="heading<?= $kumpulan_id ?>"> 
                    <div>
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?= $kumpulan_id ?>" aria-expanded="false" aria-controls="collapse<?= $kumpulan_id ?>">
                                 <?= $groupNumber ?>. <?= $row_kumpulan["nama_kumpulan"] ?> 
                                <span class="badge badge-pill badge-primary ml-2">
                                    <?= $total_ahli ?>/<?= $row_kumpulan["maksimum_ahli"] ?>
                                </span>
                            </button>
                        </h5>
                    </div>
                    <div>
                        <button type='button' class='btn btn-warning btn-sm mr-2' 
                            data-toggle='modal' data-target='#editGroupModal' 
                            data-kumpulan-id="<?= $kumpulan_id ?>"
                            data-nama-kumpulan="<?= $row_kumpulan["nama_kumpulan"] ?>"
                            data-maksimum-ahli="<?= $row_kumpulan["maksimum_ahli"] ?>">
                            <i class="fas fa-edit"></i> 
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDeleteGroup(<?= $kumpulan_id ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse<?= $kumpulan_id ?>" class="collapse" aria-labelledby="heading<?= $kumpulan_id ?>" data-parent="#accordion">
                    <div class="card-body">
                        <?php if ($total_ahli > 0): ?>
                            <ul>
                                <?php while ($row_ahli = $result_ahli->fetch_assoc()): ?>
                                    <li><?= $row_ahli["nama_pelajar"] ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>Tiada ahli dalam kumpulan ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php 
            $groupNumber++; // Increment group number for the next iteration
        endwhile; ?>
    </div>
<?php else: ?>
    <center><p>Tiada kumpulan dijumpai.</p></center>
<?php endif; ?>

        </main>
        </div>
    </div>


    <div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="addGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 

                <h5 class="modal-title" id="addGroupModalLabel">Tambah Kumpulan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 

            <div class="modal-body">
                <form id="addGroupForm">
                    <div class="form-group">
                        <label for="namaKumpulan">Nama Kumpulan:</label>
                        <input type="text" class="form-control" id="namaKumpulan" name="namaKumpulan" required>
                    </div>
                    <div class="form-group">
                        <label for="maxAhli">Maksimum Ahli:</label>
                        <input type="number" class="form-control" id="maxAhli" name="maxAhli" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> 

                <button type="submit" class="btn btn-primary" form="addGroupForm">Tambah</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editGroupModalLabel">Edit Kumpulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editGroupForm">
          <div class="form-group">
            <label for="editNamaKumpulan">Nama Kumpulan:</label>
            <input type="text" class="form-control" id="editNamaKumpulan" name="editNamaKumpulan" required>
          </div>
          <div class="form-group">
            <label for="editMaxAhli">Maksimum Ahli:</label>
            <input type="number" class="form-control" id="editMaxAhli" name="editMaxAhli" required>
          </div>
          <input type="hidden" id="editGroupId" name="editGroupId"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="editGroupForm">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable();
    });

    document.getElementById('addGroupForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('add_kumpulan.php', { 
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        setTimeout(() => {
        location.reload(); 
    }, 100);
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully (e.g., display an error message to the user)
    });
});

$('#editGroupModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var kumpulan_id = button.data('kumpulan-id');
  var nama_kumpulan = button.data('nama-kumpulan');
  var maksimum_ahli = button.data('maksimum-ahli');

  var modal = $(this);
  modal.find('.modal-body #editGroupId').val(kumpulan_id);
  modal.find('.modal-body #editNamaKumpulan').val(nama_kumpulan);
  modal.find('.modal-body #editMaxAhli').val(maksimum_ahli);
});

document.getElementById('editGroupForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (confirm("Anda yakin ingin mengemaskini kumpulan ini?")) {
        const formData = new FormData(this);

        fetch('edit_kumpulan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
        alert(data);
        setTimeout(() => {
        location.reload(); 
    }, 100);
    })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully
        });
    }
});

function confirmDeleteGroup(kumpulan_id) {
    if (confirm("Anda yakin ingin menghapus Kumpulan ini?")) {
        fetch('delete_kumpulan.php', {
            method: 'POST', // Or 'DELETE' depending on your server setup
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `kumpulan_id=${kumpulan_id}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Reload the page after deletion
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully (e.g., display an error message to the user)
        });
    }
}
</script>
</html>