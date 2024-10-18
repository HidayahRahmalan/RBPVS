<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch the SK details based on the 'id' passed in the URL
if(isset($_GET['id'])) {
    $sk_id = $_GET['id'];
    $sql = "SELECT * FROM standard_kandungan WHERE sk_id = $sk_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch all Tugasan related to this SK
        $sql_tugasan = "SELECT * FROM tugasan WHERE sk_id = $sk_id ORDER BY tarikh_due DESC"; 
        $result_tugasan = $conn->query($sql_tugasan);
    } else {
        echo "Standard kandungan tidak dijumpai.";
        exit; 
    }
} else {
    echo "ID standard kandungan tidak disediakan.";
    exit; 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}


    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.01);
    }

    .card-header {
        background-color: #4C97FF; 
        color: white;
        border-radius: 10px 10px 0 0;
    }

    /* List group styling */
    #skNavList .list-group-item {
        border-radius: 0.25rem;
        transition: background-color 0.2s;
    }

    #skNavList .list-group-item:hover {
        background-color: #f0f0f0; 
    }

    #skNavList .badge {
        background-color: #28a745; /* Green badge */
    }
    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

        <?php include 'sidebar.php'; ?>



        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='tugasan.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Tugasan untuk <?= $row["nama_sk"] ?></h1> 
            </div>

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTugasanModal" data-sk-id="<?= $sk_id ?>">Tambah Tugasan</button>

            <div class="row" id="tugasanList"> 
                <?php if ($result_tugasan->num_rows > 0): ?>
                    <?php while ($row_tugasan = $result_tugasan->fetch_assoc()): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row_tugasan["nama_tugasan"] ?></h5>
                                    <p class="card-text"><?= $row_tugasan["deskripsi_tugasan"] ?></p>
                                    <p class="card-text"><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                                    <p class="card-text"><strong>Tarikh Akhir:</strong> <?= $row_tugasan["tarikh_due"] ?></p>
                                    <?php if (!empty($row_tugasan["lampiran_path"])): ?>
                                        <a href="<?= $row_tugasan["lampiran_path"] ?>" target="_blank" class="btn btn-info btn-sm">Lihat Lampiran</a>
                                    <?php endif; ?>

                                    <div class="mt-3"> 
                                        <a href="view_tugasan_detail.php?id=<?= $row_tugasan["tugasan_id"] ?>" class="btn btn-info btn-sm mr-2">Lihat</a>
                                        <button type='button' class='btn btn-warning btn-sm mr-2' 
                                                    data-toggle='modal' data-target='#editTugasanModal' 
                                                    data-tugasan-id="<?= $row_tugasan["tugasan_id"] ?>"
                                                    data-nama-tugasan="<?= $row_tugasan["nama_tugasan"] ?>"
                                                    data-deskripsi-tugasan="<?= $row_tugasan["deskripsi_tugasan"] ?>"
                                                    data-jenis-tugasan="<?= $row_tugasan["jenis_tugasan"] ?>"
                                                    data-tarikh-due="<?= $row_tugasan["tarikh_due"] ?>"
                                                    data-lampiran-path="<?= $row_tugasan["lampiran_path"] ?>">Edit</button>
                                        <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteTugasan(<?= $row_tugasan["tugasan_id"] ?>)'>Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12"> 
                        <center><p>Tiada tugasan dijumpai untuk SK ini.</p></center>
                    </div>
                <?php endif; ?>
            </div> 

        </main>
        </div>
    </div>



    <div class="modal fade" id="addTugasanModal" tabindex="-1" role="dialog" aria-labelledby="addTugasanModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTugasanModalLabel">Tambah Tugasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addTugasanForm" enctype="multipart/form-data"> 
          <div class="form-group">
            <label for="namaTugasan">Nama Tugasan:</label>
            <input type="text" class="form-control" id="namaTugasan" name="namaTugasan" required>
          </div>
          <div class="form-group">
            <label for="deskripsiTugasan">Deskripsi Tugasan:</label>
            <textarea class="form-control" id="deskripsiTugasan" name="deskripsiTugasan" rows="3"></textarea>
          </div>
                <div class="form-group">
            <label>Jenis Tugasan:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenisTugasan" id="individu" value="individu" checked>
                <label class="form-check-label" for="individu">
                    Individu
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenisTugasan" id="kumpulan" value="kumpulan">
                <label class="form-check-label" for="kumpulan">
                    Kumpulan
                </label>
            </div>
        </div>
          <div class="form-group">
            <label for="tarikhDue">Tarikh Akhir:</label>
            <input type="date" class="form-control" id="tarikhDue" name="tarikhDue" required>
          </div>
          <div class="form-group">
            <label for="lampiranPath">Lampiran (optional):</label>
            <input type="file" class="form-control-file" id="lampiranPath" name="lampiranPath">
          </div>
          <input type="hidden" id="skIDForTugasan" name="skIDForTugasan"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="addTugasanForm">Tambah</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="editTugasanModal" tabindex="-1" role="dialog" aria-labelledby="editTugasanModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTugasanModalLabel">Edit Tugasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  

      <div class="modal-body">
        <form id="editTugasanForm" enctype="multipart/form-data"> 
          <div class="form-group">
            <label for="editNamaTugasan">Nama Tugasan:</label>
            <input type="text" class="form-control" id="editNamaTugasan" name="editNamaTugasan" required>
          </div>
          <div class="form-group">
            <label for="editDeskripsiTugasan">Deskripsi Tugasan:</label>
            <textarea class="form-control" id="editDeskripsiTugasan" name="editDeskripsiTugasan" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="editJenisTugasan">Jenis Tugasan:</label>
            <select class="form-control" id="editJenisTugasan" name="editJenisTugasan">
              <option value="individu">Individu</option>
              <option value="kumpulan">Kumpulan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editTarikhDue">Tarikh Akhir:</label>
            <input type="date" class="form-control" id="editTarikhDue" name="editTarikhDue" required>
          </div>
          <div class="form-group">
            <label for="editLampiranPath">Lampiran (optional):</label>
            <input type="file" class="form-control-file" id="editLampiranPath" name="editLampiranPath">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
          </div>
          <input type="hidden" id="editTugasanId" name="editTugasanId">
          <input type="hidden" id="oldLampiranPath" name="oldLampiranPath"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="editTugasanForm">Simpan Perubahan</button>
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

document.getElementById('viewTugasanDetail').addEventListener('click', function(event) {
  event.preventDefault();

  var jenisTugasan = document.getElementById('jenisTugasan').value;
  var tugasanId = document.getElementById('tugasanId').value;

  if (jenisTugasan === 'individu') {
    window.location.href = 'view_individu_tugasan.php?id=' + tugasanId;
  } else if (jenisTugasan === 'kumpulan') {
    window.location.href = 'view_kumpulan_tugasan.php?id=' + tugasanId;
  }
});

    // Handle 'Tambah Tugasan' button click to set sk_id in the modal
$('#addTugasanModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var sk_id = button.data('sk-id');

    var modal = $(this);
    modal.find('.modal-body #skIDForTugasan').val(sk_id); 
});

// Handle 'addTugasanForm' submission using Fetch API
document.getElementById('addTugasanForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menambah Tugasan ini?")) {
        return; 
    }

    const formData = new FormData(this);

    fetch('add_tugasan.php', { // Make sure you have this PHP script ready
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.startsWith("Tugasan baru berjaya ditambah!")) {

            alert(data); 
            setTimeout(() => {
        location.reload(); 
    }, 100);
        } else {
            // Display the error message
            alert("Error: " + data); 
        }

        const addTugasanModal = document.getElementById('addTugasanModal');
        const modal = bootstrap.Modal.getInstance(addTugasanModal);
        modal.hide();
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully (e.g., display an error message to the user)
    });
});

// Handle 'Edit Tugasan' button click to populate the modal
$('#editTugasanModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var tugasan_id = button.data('tugasan-id');
  var nama_tugasan = button.data('nama-tugasan');
  var deskripsi_tugasan = button.data('deskripsi-tugasan');
  var jenis_tugasan = button.data('jenis-tugasan');
  var tarikh_due = button.data('tarikh-due');
  var lampiran_path = button.data('lampiran-path');

  var modal = $(this);
  modal.find('.modal-body #editTugasanId').val(tugasan_id);
  modal.find('.modal-body #editNamaTugasan').val(nama_tugasan);
  modal.find('.modal-body #editDeskripsiTugasan').val(deskripsi_tugasan);
  modal.find('.modal-body #editJenisTugasan').val(jenis_tugasan);
  modal.find('.modal-body #editTarikhDue').val(tarikh_due);
  // You might want to display the current file name or path here
  modal.find('.modal-body #oldLampiranPath').val(lampiran_path); 
});

// Handle 'editTugasanForm' submission
document.getElementById('editTugasanForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_tugasan.php', { 
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
});


function confirmDeleteTugasan(tugasan_id) {
    if (confirm("Anda yakin ingin menghapus Tugasan ini?")) {
        fetch('delete_tugasan.php', {
            method: 'POST', // Or 'DELETE' depending on your server setup
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `tugasan_id=${tugasan_id}`
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("berjaya dihapus")) {
                alert(data); // Display success message using a basic alert

                // Reload the page after a short delay
                setTimeout(() => {
                    location.reload(); 
                }, 100); // 1-second delay
            } else {
                alert("Error: " + data); // Display error message using a basic alert
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully (e.g., display an error message to the user)
        });
    }
}
</script>
</html>