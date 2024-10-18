<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch the Kuiz details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $kuiz_id = intval($_GET['id']);
    $sql_kuiz = "SELECT * FROM kuiz WHERE kuiz_id = $kuiz_id";
    $result_kuiz = $conn->query($sql_kuiz);

    if ($result_kuiz->num_rows > 0) {
        $row_kuiz = $result_kuiz->fetch_assoc();


    } else {
        echo "Kuiz tidak dijumpai.";
        exit;
    }
} else {
    echo "ID kuiz tidak disediakan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail kuiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
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

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="tugasan.php">Tugasan</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="kuiz.php">Kuiz</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row_kuiz["nama_kuiz"] ?></li>
            </ol>
        </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='kuiz.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto"><?= $row_kuiz["nama_kuiz"] ?></h1> 
            </div>

            <button type='button' class='btn btn-success btn-sm mr-2 mb-3' data-toggle='modal' data-target='#addKandunganModal' 
            data-kuiz-id="<?php echo $kuiz_id; ?>">Tambah Kandungan Kuiz</button>

            <div class="card">
                <div class="card-body">

                <h3><strong><?= $row_kuiz["nama_kuiz"] ?></strong></h3><br>

                <p><?= $row_kuiz["deskripsi_kuiz"] ?></p><br>

<hr class ="bg-dark">

                                <!-- Fetch Kandungan for this kuiz -->
                                <?php
                                $kuiz_id = $row_kuiz["kuiz_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN_KUIZ WHERE kuiz_id = $kuiz_id ORDER BY URUTAN_KANDUNGAN";
                                $result_kandungan = $conn->query($sql_kandungan);
                                ?>

                                    <?php if ($result_kandungan->num_rows > 0) : ?>

        <?php while ($row_kandungan = $result_kandungan->fetch_assoc()) : ?>
            <p class="mb-4"><?= $row_kandungan["deskripsi_kandungan"] ?></p>

            <a href="<?= $row_kandungan["pautan_url"]?>"><?= $row_kandungan["pautan_url"]?></a>

            <!-- If using button for the url -->
 <!--             if (!empty($row_kandungan["pautan_url"])): ?> 
    <div class="mt-3">
        <a href=" $row_kandungan["pautan_url"]" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-link"></i> Pautan URL
        </a>
    </div>
 endif; -->

            <?php
            $path = $row_kandungan["kandungan_path"];
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!empty($path)) : ?>
                <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                    <img src="<?= $path ?>" width="100%" height="500px" class="mb-4">
                <?php elseif ($extension == 'docx') : ?>
                    <!-- You can add code to handle docx files here -->
                <?php elseif ($extension == 'mp4') : ?>
                    <video width="100%" height="500px" controls>
                        <source src="<?= $path ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else : ?>
                    <iframe src="<?= $path ?>" width="100%" height="500px" class="mb-4"></iframe>
                <?php endif; ?>
            <?php endif; ?>
                        <div class="d-flex justify-content-center">
                        <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editKandunganModal'
                        data-kandungan='<?= json_encode($row_kandungan) ?>'>Edit</button>

                                    <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKandungan(<?php echo $row_kandungan["kandungan_kuiz_id"]; ?>)'>Hapus Kandungan</button>
                        </div>
                    <?php endwhile; ?>
             <?php else : ?>
            <p>Tiada kandungan dijumpai untuk kuiz ini.</p>
            <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>


    <!-- Add Kandungan Kuiz modal -->
    <div class="modal fade" id="addKandunganModal" tabindex="-1" role="dialog" aria-labelledby="addKandunganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKandunganModalLabel">Tambah Kandungan Kuiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <kuizan aria-hidden="true">&times;</kuizan>
                </button>
            </div>
            <div class="modal-body">
                <form id="addKandunganForm">
                    <div class="form-group">
                        <label for="deskripsiKandungan">Deskripsi Kandungan:</label>
                        <textarea class="form-control" id="deskripsiKandungan" name="deskripsi_kandungan" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pautanURL">Pautan URL:</label>
                        <textarea class="form-control" id="pautanURL" name="pautan_URL" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
            <label for="kandunganPath">Kandungan Fail:</label>
            <input type="file" class="form-control-file" id="kandunganPath" name="kandunganPath"> 
          </div>
          <div class="form-group">
            <label for="urutanKandungan">Urutan Kandungan:</label>
            <input type="number" class="form-control" id="urutanKandungan" name="urutanKandungan" required>
          </div>
                    <input type="hidden" id="kuizID" name="kuiz_id" value=""> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="addKandunganForm">Tambah</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Kandungan Kuiz modal -->
<div class="modal fade" id="editKandunganModal" tabindex="-1" role="dialog" aria-labelledby="editKandunganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKandunganModalLabel">Edit Kandungan Kuiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editKandunganForm" enctype="multipart/form-data">
                    <input type="hidden" id="editKandunganId" name="kandungan_kuiz_id">
                    <div class="form-group">
                        <label for="editDeskripsiKandungan">Deskripsi Kandungan:</label>
                        <textarea class="form-control" id="editDeskripsiKandungan" name="deskripsi_kandungan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editPautanUrl">Pautan URL:</label>
                        <textarea class="form-control" id="editPautanUrl" name="pautan_url" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editKandunganPath">Kandungan Fail:</label>
                        <input type="file" class="form-control-file" id="editKandunganPath" name="kandunganPath"> 
                        <input type="hidden" id="oldKandunganPath" name="oldKandunganPath">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
                    </div>
                    <div class="form-group">
                        <label for="editUrutanKandungan">Urutan Kandungan:</label>
                        <input type="number" class="form-control" id="editUrutanKandungan" name="urutan_kandungan" required>
                    </div>

                    <input type="hidden" id="editKuizID" name="kuiz_id" value=""> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="editKandunganForm">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

$('#addKandunganModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var kuiz_id = button.data('kuiz-id');

    var modal = $(this);
    modal.find('.modal-body #kuizID').val(kuiz_id); 
});

// Handle 'addKandunganForm' submission using Fetch API
document.getElementById('addKandunganForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menambah Kandungan ini?")) {
        return; 
    }

    const formData = new FormData(this);

    fetch('add_kandunganKuiz.php', {
        method: 'POST',
        body: formData
    })
    .then(rekuizonse => rekuizonse.text())
    .then(data => {
        if (data.startsWith("Kandungan baru berjaya ditambah!")) {
            alert(data);
            setTimeout(() => {
                window.location.reload();
            }, 100); 
        } else {
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


$('#editKandunganModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var kandungan = button.data('kandungan'); // Get the kandungan data

    var modal = $(this);
    modal.find('.modal-body #editKandunganId').val(kandungan.kandungan_kuiz_id);
    modal.find('.modal-body #editDeskripsiKandungan').val(kandungan.deskripsi_kandungan);
    modal.find('.modal-body #editUrutanKandungan').val(kandungan.urutan_kandungan);
    modal.find('.modal-body #editKuizID').val(kandungan.kuiz_id);
    modal.find('.modal-body #editPautanUrl').val(kandungan.pautan_url); 

    // You might want to handle the existing file display/preview here
});


// Handle 'editKandunganForm' submission using Fetch API
document.getElementById('editKandunganForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_kandunganKuiz.php', { 
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    alert(data);

    // Refresh the page after a short delay (e.g., 1 second)
    setTimeout(() => {
        location.reload(); 
    }, 100);
  })
  .catch(error => {
    console.error('Error:', error);
   
  });
});

// Function to handle delete confirmation and AJAX request for deleting Kandungan
function confirmDeleteKandungan(kandungan_kuiz_id) {
    if (confirm("Anda yakin ingin menghapus Kandungan ini?")) {
        fetch('delete_kandunganKuiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `kandungan_kuiz_id=${kandungan_kuiz_id}`
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

