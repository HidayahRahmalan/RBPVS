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

        // Fetch all SPs related to this SK
        $sql_sp = "SELECT * FROM standard_pembelajaran WHERE sk_id = $sk_id ORDER BY URUTAN_SP"; 
        $result_sp = $conn->query($sql_sp);
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
    <title>Standard Pembelajaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

        <?php include 'sidebar.php'; ?>



        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">
  <a href='modul.php' class='btn btn-secondary btn-sm mr-2'>Kembali</a>
  <center><h1><?php echo '6.'.$row['kod_sk'] . ' ' . $row['nama_sk']; ?></h1></center><br>

  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card shadow mb-4">
          <div class="card-header">
            <h5 class="card-title">Navigasi Kandungan</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush" id="spNavList">
              <li class="list-group-item">
                <a href="#" onclick="showAllContent()">All</a>
              </li>
              <?php
              if ($result_sp->num_rows > 0) {
                while ($row_sp = $result_sp->fetch_assoc()) {
                  ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" data-sp-id="<?= $row_sp["sp_id"] ?>">
                      <?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . "  " . $row_sp["nama_sp"] ?>
                    </a>
                    <div>
                      <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editSPModal'
                        data-sp-id="<?= $row_sp["sp_id"] ?>"
                        data-nama-sp="<?= $row_sp["nama_sp"] ?>"
                        data-deskripsi-sp="<?= $row_sp["deskripsi_sp"] ?>"
                        data-urutan-sp="<?= $row_sp["urutan_sp"] ?>">Edit</button>

                      <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteSP(" . $row_sp["sp_id"] . ")'>Hapus SP</button>
                    </div>
                  </li>
                  <?php
                }
              } else {
                echo "<p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>";
              }
              ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2>Standard Pembelajaran</h2>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSPModal">Tambah SP</button>
        </div>

        <div id="content-area">
          <?php
          if ($result_sp->num_rows > 0) {
            $result_sp->data_seek(0);
            while ($row_sp = $result_sp->fetch_assoc()) {
              // Fetch Kandungan for this SP
              $sp_id = $row_sp["sp_id"];
              $sql_kandungan = "SELECT * FROM KANDUNGAN WHERE SP_ID = $sp_id ORDER BY URUTAN_KANDUNGAN";
              $result_kandungan = $conn->query($sql_kandungan);
              ?>
              <div class="content-section" id="content-title<?= $row_sp["sp_id"] ?>" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h2><?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . "  " . $row_sp["nama_sp"] ?></h2>
                  <div>
                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#addKandunganModal'
                      data-sp-id='" . $row_sp["sp_id"] . "'>Tambah Kandungan</button>
                  </div>
                </div>

                <p><?= $row_sp['deskripsi_sp'] ?></p>

                <?php if ($result_kandungan->num_rows > 0) { ?>
                  <div class="card">
                    <div class="card-body">
                      <h3>Kandungan</h3>
                      <ul>
                        <?php
                        while ($row_kandungan = $result_kandungan->fetch_assoc()) {
                          $path = $row_kandungan["kandungan_path"];
                          $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                          ?>
                          <li>
                            <h4><?= $row_kandungan["nama_kandungan"] ?></h4>
                            <p><?= $row_kandungan["deskripsi_kandungan"] ?></p>
                            <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                              <img src='<?= $path ?>' alt='<?= $row_kandungan["nama_kandungan"] ?>' style='max-width: 100px; height: auto;'>
                            <?php } else { ?>
                              <a href='<?= $path ?>' target='_blank'><?= $path ?></a>
                            <?php } ?>
                            <div>
                              <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editKandunganModal'
                                data-kandungan-id="<?= $row_kandungan["kandungan_id"] ?>"
                                data-nama-kandungan="<?= $row_kandungan["nama_kandungan"] ?>"
                                data-deskripsi-kandungan="<?= $row_kandungan["deskripsi_kandungan"] ?>"
                                data-kandungan-path="<?= $row_kandungan["kandungan_path"] ?>">Edit</button>

                              <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKandungan(" . $row_kandungan["kandungan_id"] . ")'>Hapus Kandungan</button>
                            </div>
                          </li>
                          <?php
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                <?php } else { ?>
                  <p>Tiada kandungan dijumpai untuk SP ini.</p>
                <?php } ?>
              </div>
            <?php
            }
          } else {
            echo "<p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</main>
        </div>
    </div>

    <!-- Add Standard pembelajranP modal -->
    <div class="modal fade" id="addSPModal" tabindex="-1" role="dialog" aria-labelledby="addSPModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSPModalLabel">Tambah Standard Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addSPForm">
          <div class="form-group">
            <label for="namaSP">Nama SP:</label>
            <input type="text" class="form-control" id="namaSP" name="namaSP" required>
          </div>
          <div class="form-group">
            <label for="deskripsiSP">Deskripsi SP:</label>
            <textarea class="form-control" id="deskripsiSP" name="deskripsiSP" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="urutanSP">Urutan SP:</label>
            <input type="number" class="form-control" id="urutanSP" name="urutanSP" required>
          </div>
          <input type="hidden" id="skID" name="skID" value="<?php echo $sk_id; ?>"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="addSPForm">Tambah</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Standard pembelajranP modal -->
<div class="modal fade" id="editSPModal" tabindex="-1" role="dialog" aria-labelledby="editSPModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSPModalLabel">Edit Standard Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 

      </div>
      <div class="modal-body">
        <form id="editSPForm">
          <div class="form-group">
            <label for="editNamaSP">Nama SP:</label>
            <input type="text" class="form-control" id="editNamaSP" name="editNamaSP" required>
          </div>
          <div class="form-group">
            <label for="editDeskripsiSP">Deskripsi SP:</label>
            <textarea class="form-control" id="editDeskripsiSP" name="editDeskripsiSP" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="editUrutanSP">Urutan SP:</label>
            <input type="number" class="form-control" id="editUrutanSP" name="editUrutanSP" required>
          </div>
          <input type="hidden" id="editSpID" name="editSpID"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" 
 form="editSPForm">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Kandungan SP modal -->
<div class="modal fade" id="addKandunganModal" tabindex="-1" role="dialog" aria-labelledby="addKandunganModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKandunganModalLabel">Tambah Kandungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 

      </div>
      <div class="modal-body">
        <form id="addKandunganForm">
          <div class="form-group">
            <label for="namaKandungan">Nama Kandungan:</label>
            <input type="text" class="form-control" id="namaKandungan" name="namaKandungan" required>
          </div>
          <div class="form-group">
            <label for="deskripsiKandungan">Deskripsi Kandungan:</label>
            <textarea class="form-control" id="deskripsiKandungan" name="deskripsiKandungan" rows="3"></textarea>
          </div>
          <div class="form-group">
                        <label for="kandunganPath">Fail Kandungan:</label>
                        <input type="file" class="form-control-file" id="kandunganPath" name="kandunganPath">
                    </div>
          <div class="form-group">
            <label for="urutanKandungan">Urutan Kandungan:</label>
            <input type="number" class="form-control" id="urutanKandungan" name="urutanKandungan" required>
          </div>
          <input type="hidden" id="spIDForKandungan" name="spIDForKandungan"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" 
 form="addKandunganForm">Tambah</button>
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

    document.addEventListener('DOMContentLoaded', function() {
    const addSPForm = document.getElementById('addSPForm');

    addSPForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('add_sp.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === "Standard Pembelajaran baru berjaya ditambah!") {
        alert(data); // Display the success message in a basic alert

        setTimeout(() => {
            window.location.reload();
        }, 100); 
    } else {
        // Display the error message in a basic alert
        alert("Error: " + data); 
    }
            const addSPModal = document.getElementById('addSPModal');
            const modal = bootstrap.Modal.getInstance(addSPModal);
            modal.hide();
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully (e.g., display an error message to the user)
        });
    });
});


$('#editSPModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var sp_id = button.data('sp-id');
  var nama_sp = button.data('nama-sp');
  var deskripsi_sp = button.data('deskripsi-sp');
  var urutan_sp = button.data('urutan-sp');

  var modal = $(this);
  modal.find('.modal-body #editSpID').val(sp_id);
  modal.find('.modal-body #editNamaSP').val(nama_sp);
  modal.find('.modal-body #editDeskripsiSP').val(deskripsi_sp);
  modal.find('.modal-body #editUrutanSP').val(urutan_sp);
});

$('#editSPForm').submit(function(event) {
  event.preventDefault(); 

  var formData = $(this).serialize();

  $.ajax({
    type: 'POST',
    url: 'edit_sp.php', // Buat file PHP ini untuk menangani pembaruan
    data: formData,
    success: function(response) {
      alert(response); 
      $('#editSPModal').modal('hide'); 
      // Perbarui tampilan SP atau muat ulang halaman di sini
    }
  });
});

// Handle 'Tambah Kandungan' button click to set sp_id in the modal
$('#addKandunganModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var sp_id = button.data('sp-id');

    var modal = $(this);
    modal.find('.modal-body #spIDForKandungan').val(sp_id);
});

// Handle 'addKandunganForm' submission using Fetch API
document.getElementById('addKandunganForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('add_kandungan.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.startsWith("Kandungan baru berjaya ditambah!")) {
            // Extract the new Kandungan ID from the response
            const newKandunganId = data.split(":")[1].trim();

            // Dynamically add new Kandungan to the list 
            const newKandunganName = document.getElementById('namaKandungan').value; 
            const spId = document.getElementById('spIDForKandungan').value;

            const kandunganList = document.querySelector(`#sp-${sp_id} ul`); // Find the ul within the corresponding SP section
            const newKandunganItem = document.createElement('li');
            newKandunganItem.textContent = newKandunganName;
            kandunganList.appendChild(newKandunganItem);

            // Clear the form
            this.reset();

        } else {
            // Display the error message in a basic alert
            alert("Error: " + data); 
        }

        const addKandunganModal = document.getElementById('addKandunganModal');
        const modal = bootstrap.Modal.getInstance(addKandunganModal);
        modal.hide();
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully
    });
});

// Function to handle delete confirmation and AJAX request for deleting SP
function confirmDeleteSP(sp_id) {
    if (confirm("Anda yakin ingin menghapus Standard Pembelajaran ini?")) {
        fetch('delete_sp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `sp_id=${sp_id}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Reload the page after deletion
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully
        });
    }
}


$(document).ready(function() {
    // Initially show only the first content section
    $('.content-section').first().show();

    // Attach click handler to navigation links
    $('#spNavList a[data-sp-id]').click(function(e) {
        e.preventDefault();
        var spId = $(this).data('sp-id');
        showSpecificContent('content-title' + spId);
    });

    function showAllContent() {
        $('.content-section').show();
    }

    function showSpecificContent(contentId) {
        $('.content-section').hide();
        $('#' + contentId).show();
    }
});
</script>


</html>