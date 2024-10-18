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
    <?php
if ($result_sp->num_rows > 0) {
    while($row_sp = $result_sp->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-body">
                <h3><?php echo $row["kod_sk"] . "." . $row_sp["urutan_sp"] . "  " . $row_sp["nama_sp"]; ?></h3>
                <span><?php echo $row_sp['deskripsi_sp']; ?></span>

                <!-- Navigation list for this SP -->
                <ul class='nav nav-tabs'>
                    <li class='nav-item'><a class='nav-link active' data-toggle='tab' href='#sp-<?php echo $row_sp["sp_id"]; ?>'>Details</a></li>
                    <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#kandungan-<?php echo $row_sp["sp_id"]; ?>'>Kandungan</a></li>
                    <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#edit-<?php echo $row_sp["sp_id"]; ?>'>Edit</a></li>
                </ul>

                <!-- Tab content for this SP -->
                <div class='tab-content'>
                    <div class='tab-pane fade show active' id='sp-<?php echo $row_sp["sp_id"]; ?>'>
                        <p>Details of SP <?php echo $row_sp["nama_sp"]; ?></p>
                    </div>

                    <!-- Fetch Kandungan for this SP -->
                    <?php
                    $sp_id = $row_sp["sp_id"];
                    $sql_kandungan = "SELECT * FROM KANDUNGAN WHERE SP_ID = $sp_id ORDER BY URUTAN_KANDUNGAN"; 
                    $result_kandungan = $conn->query($sql_kandungan);

                    ?>
                    <div class='tab-pane fade' id='kandungan-<?php echo $row_sp["sp_id"]; ?>'>
                        <?php if ($result_kandungan->num_rows > 0) { ?>
                            <ul>
                                <?php while($row_kandungan = $result_kandungan->fetch_assoc()) { ?>
                                    <li><?php echo $row_kandungan["nama_kandungan"]; ?></li> 
                                    <!-- You can add more details or actions here as needed -->
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p>Tiada kandungan dijumpai untuk SP ini.</p>
                        <?php } ?>
                    </div>

                    <div class='tab-pane fade' id='edit-<?php echo $row_sp["sp_id"]; ?>'>
                        <button type='button' class='btn btn-warning btn-sm mt-2' data-toggle='modal' data-target='#editSPModal' 
                                data-sp-id='<?php echo $row_sp["sp_id"]; ?>' 
                                data-nama-sp='<?php echo $row_sp["nama_sp"]; ?>' 
                                data-deskripsi-sp='<?php echo $row_sp["deskripsi_sp"]; ?>' 
                                data-urutan-sp='<?php echo $row_sp["urutan_sp"]; ?>'>Edit</button>
                    </div>

                </div> <!-- end tab-content -->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
        <?php
    }
} else {
    echo "<p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>";
}
?>
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

</script>


</html>