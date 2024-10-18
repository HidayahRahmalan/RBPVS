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
                            echo "<div class='mb-4'>"; 
                            echo "<h3>6.".$row['kod_sk'] .".". $row_sp["urutan_sp"] . " " . $row_sp["nama_sp"] . "</h3>";
                            echo "<span>".$row_sp['deskripsi_sp'] . "</span>";
                    
                            // Edit Button (Existing)
                            echo "<button type='button' class='btn btn-warning btn-sm mt-2 mr-2' data-toggle='modal' data-target='#editSPModal' 
                                  data-sp-id='" . $row_sp["sp_id"] . "' 
                                  data-nama-sp='" . $row_sp["nama_sp"] . "'
                                  data-deskripsi-sp='" . $row_sp["deskripsi_sp"] . "'
                                  data-urutan-sp='" . $row_sp["urutan_sp"] . "'>Edit</button>";
                    
                            // Add Kandungan Button
                            echo "<button type='button' class='btn btn-success btn-sm mt-2 mr-2' data-toggle='modal' data-target='#addKandunganModal' 
                                  data-sp-id='" . $row_sp["sp_id"] . "'>Tambah Kandungan</button>";
                    
                            // Delete SP Button
                            echo "<button type='button' class='btn btn-danger btn-sm mt-2' onclick='confirmDeleteSP(" . $row_sp["sp_id"] . ")'>Hapus SP</button>";

                            // Fetch Kandungan for this SP
                            $sp_id = $row_sp["sp_id"];
                            $sql_kandungan = "SELECT * FROM KANDUNGAN WHERE SP_ID = $sp_id ORDER BY URUTAN_KANDUNGAN"; 
                            $result_kandungan = $conn->query($sql_kandungan);

                            if ($result_kandungan->num_rows > 0) {
                                echo "<ul>";
                                while($row_kandungan = $result_kandungan->fetch_assoc()) {
                                    echo "<li>" . $row_kandungan["nama_kandungan"] . "</li>"; 
                                    // You can add more details or actions here as needed
                                }
                                echo "</ul>";
                            } else {
                                echo "<p>Tiada kandungan dijumpai untuk SP ini.</p>";
                            }

                            echo "</div>"; 
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
            <label for="kandunganPath">Kandungan Path:</label>
            <input type="text" class="form-control" id="kandunganPath" name="kandunganPath">
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


document.addEventListener('DOMContentLoaded', function() {
    const editSPModal = document.getElementById('editSPModal');

    editSPModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const spId = button.dataset.spId;
        const namaSP = button.dataset.namaSp;
        const deskripsiSP = button.dataset.deskripsiSp;
        const urutanSP = button.dataset.urutanSp;

        // Populate the modal's input fields
        this.querySelector('#editSpID').value = spId;
        this.querySelector('#editNamaSP').value = namaSP;
        this.querySelector('#editDeskripsiSP').value = deskripsiSP;
        this.querySelector('#editUrutanSP').value = urutanSP;
    });

    editSPForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('edit_sp.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            const modal = bootstrap.Modal.getInstance(editSPModal);
            modal.hide();

            // Refresh halaman atau perbarui daftar SP secara dinamis di sini
            // Contoh: location.reload(); untuk memuat ulang halaman
        })
        .catch(error => {
            console.error('Error:', error);
            // Tangani error dengan baik (misalnya, tampilkan pesan error kepada pengguna)
        });
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

</script>


</html>