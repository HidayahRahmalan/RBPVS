<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch all "kuiz" from the database
$sql_kuiz = "SELECT * FROM kuiz"; 
$result_kuiz = $conn->query($sql_kuiz);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kuiz</title>
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

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="tugasan.php">Tugasan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kuiz</li>
            </ol>
        </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='tugasan.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Kuiz</h1> 
            </div>

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addKuizModal">Tambah Kuiz</button>

            <div class="row" id="kuizList">
                <?php 
                if ($result_kuiz->num_rows > 0) {
                    while($row_kuiz = $result_kuiz->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-3">';
                        echo '<div class="card h-100">';
                        echo '<div class="card-header">' . $row_kuiz['nama_kuiz'] . '</div>'; 
                        echo '<div class="card-body">';
                        echo '<p>' . $row_kuiz['deskripsi_kuiz'] . '</p>'; 
                        echo "<a href='kandungan_kuiz.php?id=" . $row_kuiz["kuiz_id"] . "' class='btn btn-info btn-sm mr-2'>Lihat</a>";
                        echo "<button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editKuizModal'
                        data-kuiz='". json_encode($row_kuiz)."'>Edit</button>";
                        echo "<button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKuiz(".$row_kuiz["kuiz_id"].")'>Hapus Kuiz</button>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-md-12">';
                    echo '<p class="text-center">Tiada kuiz  yang dapat dijumpai.</p>';
                    echo '</div>';
                }
                ?>
            </div>

        </main>
        </div>
    </div>


        <!-- Add Kuiz modal -->
        <div class="modal fade" id="addKuizModal" tabindex="-1" role="dialog" aria-labelledby="addKuizModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKuizModalLabel">Tambah kuiz Kuiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <kuizan aria-hidden="true">&times;</kuizan>
                </button>
            </div>
            <div class="modal-body">
                <form id="addKuizForm">
                <div class="form-group">
            <label for="nama_kuiz">Nama Kuiz:</label>
            <input type="text" class="form-control" id="nama_kuiz" name="nama_kuiz" required >
                </div>
                    <div class="form-group">
                        <label for="deskripsi_kuiz">Deskripsi kuiz:</label>
                        <textarea class="form-control" id="deskripsi_kuiz" name="deskripsi_kuiz" rows="3" ></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="addKuizForm">Tambah</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit  Kuiz modal -->
<div class="modal fade" id="editKuizModal" tabindex="-1" role="dialog" aria-labelledby="editKuizModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKuizModalLabel">Edit kuiz Kuiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editKuizForm" enctype="multipart/form-data">
                    <input type="hidden" id="editKuizId" name="kuiz_id">
                    <div class="form-group">
            <label for="editNamaKuiz">Nama Kuiz:</label>
            <input type="text" class="form-control" id="editNamaKuiz" name="nama_kuiz" required >
                </div>
                    <div class="form-group">
                        <label for="editDeskripsiKuiz">Deskripsi kuiz:</label>
                        <textarea class="form-control" id="editDeskripsiKuiz" name="deskripsi_kuiz" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="editKuizForm">Simpan Perubahan</button>
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


// Handle 'addKuizForm' submission using Fetch API
document.getElementById('addKuizForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menambah Kuiz ini?")) {
        return; 
    }

    const formData = new FormData(this);

    fetch('add_Kuiz.php', {
        method: 'POST',
        body: formData
    })
    .then(rekuizonse => rekuizonse.text())
    .then(data => {
            alert(data);
            setTimeout(() => {
                window.location.reload();
            }, 100); 
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully
    });
});    


$('#editKuizModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var kuiz = button.data('kuiz'); // Get the kuiz data

    var modal = $(this);
    modal.find('.modal-body #editKuizId').val(kuiz.kuiz_id);
    modal.find('.modal-body #editNamaKuiz').val(kuiz.nama_kuiz);
    modal.find('.modal-body #editDeskripsiKuiz').val(kuiz.deskripsi_kuiz);

    // You might want to handle the existing file display/preview here
});


// Handle 'editKandunganForm' submission using Fetch API
document.getElementById('editKuizForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_kuiz.php', { 
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


// Function to handle delete confirmation and AJAX request for deleting Kuiz
function confirmDeleteKuiz(kuiz_id) {
    if (confirm("Anda yakin ingin menghapus Kuiz ini?")) {
        fetch('delete_kuiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `kuiz_id=${kuiz_id}`
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