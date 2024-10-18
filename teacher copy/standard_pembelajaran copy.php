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


            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSPModal">Tambah SP</button>
            
            <div class="card">
    <div class="card-body">
    <div class="card"> 
    <div class="card-body"> 

        <?php if ($result_sp->num_rows > 0) { ?>
            <ul class="nav nav-pills mb-3" id="spTabs" role="tablist">
                <?php 
                $active = 'active'; // Set the first tab as active
                while($row_sp = $result_sp->fetch_assoc()) { 
                ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= $active ?>" id="sp-tab-<?= $row_sp["sp_id"] ?>" data-toggle="pill" href="#sp-<?= $row_sp["sp_id"] ?>" role="tab" aria-controls="sp-<?= $row_sp["sp_id"] ?>" aria-selected="true">
                            <?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] ?>
                        </a>
                    </li>
                <?php
                    $active = ''; // Reset active for subsequent tabs
                } 
                ?>
            </ul>

            <div class="tab-content" id="spTabsContent">
                <?php
                $active = 'active show'; // Set the first tab content as active
                $result_sp->data_seek(0); // Reset the result pointer to the beginning
                while($row_sp = $result_sp->fetch_assoc()) {
                ?>
                    <div class="tab-pane fade <?= $active ?>" id="sp-<?= $row_sp["sp_id"] ?>" role="tabpanel" aria-labelledby="sp-tab-<?= $row_sp["sp_id"] ?>">
                        <div class="card">
                            <div class="card-body">
                                <h3><?= $row_sp["nama_sp"] ?></h3>
                                <p><?= $row_sp['deskripsi_sp'] ?></p>

                                <?php
                                // ... (Your existing code to fetch and display Kandungan) ...
                                ?>

                                <button type='button' class='btn btn-warning btn-sm mt-2' data-toggle='modal' data-target='#editSPModal' 
                                    data-sp-id="<?= $row_sp["sp_id"] ?>" 
                                    data-nama-sp="<?= $row_sp["nama_sp"] ?>"
                                    data-deskripsi-sp="<?= $row_sp["deskripsi_sp"] ?>"
                                    data-urutan-sp="<?= $row_sp["urutan_sp"] ?>">Edit</button>
                            </div> 
                        </div> 
                    </div>
                <?php
                    $active = ''; // Reset active for subsequent tab content
                } 
                ?>
            </div>

        <?php } else { ?>
            <p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>
        <?php } ?>

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

$(document).ready(function() {
    // Initially hide all tab panes except the first one
    $('.tab-pane').not('.active').hide();

    // Handle tab clicks to show/hide content
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        $('.tab-pane').hide();
        $($(this).attr('href')).show();
    });
});

</script>


</html>