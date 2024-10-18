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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.11/pdfobject.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

<!-- Container for the page content -->
<div class="container-fluid">
    <div class="row">
       
        <?php include 'sidebar.php'; ?>



        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">
            
        <a href='modul.php' class='btn btn-secondary btn-sm mb-2'>Kembali</a> 

        <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item " aria-current="page">Standard Kandungan</li>
        <li class="breadcrumb-item " aria-current="page"><?php echo '6.' . $row['kod_sk'] . ' ' . $row['nama_sk']; ?></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $current_sp_name; ?></li>
    </ol>
</nav>

            <!-- Header section -->

            <div class="d-flex justify-content-between align-items-center mb-3">
            <a href='modul.php' class='btn btn-secondary btn-sm'>Kembali</a>
    <div> </div> <h1 class="text-center mx-auto"><?php echo '6.' . $row['kod_sk'] . ' ' . $row['nama_sk']; ?></h1> 

</div>
        

            <!-- Content section -->
            <div class="row">

            <div class="col-md-9">

                    <!-- Content area -->
                    <div id="content-area">
                        <?php 
                        $current_sp_name = '';
                        if ($result_sp->num_rows > 0) : ?>
                            <?php $result_sp->data_seek(0); ?>
                            <?php while ($row_sp = $result_sp->fetch_assoc()) : ?>
                                <!-- Fetch Kandungan for this SP -->
                                <?php
                                $current_sp_name = $row_sp['nama_sp'];
                                $sp_id = $row_sp["sp_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN WHERE SP_ID = $sp_id ORDER BY URUTAN_KANDUNGAN";
                                $result_kandungan = $conn->query($sql_kandungan);
                                ?>
                                <div class="content-section" id="content-title<?= $row_sp["sp_id"] ?>" style="display: none;">
                                <div class="d-flex justify-content-start mb-3"> 
                                    <div>
                                        <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#addKandunganModal' 
                                        data-sp-id="<?php echo $row_sp["sp_id"]; ?>">Tambah Kandungan</button>
                                        <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editSPModal' 
                                            data-sp-id="<?= $row_sp["sp_id"] ?>" 
                                            data-nama-sp="<?= $row_sp["nama_sp"] ?>"
                                            data-deskripsi-sp="<?= $row_sp["deskripsi_sp"] ?>"
                                            data-urutan-sp="<?= $row_sp["urutan_sp"] ?>">Edit</button>
                                            <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteSP(<?= $row_sp["sp_id"] ?>)'>Hapus SP</button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3"> 
                                    <h2><?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . " " . $row_sp["nama_sp"] ?></h2>
                                </div>

                                    <p><?= $row_sp['deskripsi_sp'] ?></p>

                                    <?php if ($result_kandungan->num_rows > 0) : ?>
                                        <div class="card">
    <div class="card-body ">
        <?php while ($row_kandungan = $result_kandungan->fetch_assoc()) : ?>
            <h4 class="mb-3"><?= $row_kandungan["nama_kandungan"] ?></h4>
            <p class="mb-4"><?= $row_kandungan["deskripsi_kandungan"] ?></p>
            <?php
            $path = $row_kandungan["kandungan_path"];
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!empty($path)) : ?>
                <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                    <img src="<?= $path ?>" width="100%" height="500px" class="mb-4">
                <?php elseif ($extension == 'docx') : ?>
                    <!-- You can add code to handle docx files here -->
                <?php else : ?>
                    <iframe src="<?= $path ?>" width="100%" height="500px" class="mb-4"></iframe>
                <?php endif; ?>
            <?php endif; ?>
            <div class="d-flex justify-content-center">
            <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editKandunganModal'
            data-kandungan='<?= json_encode($row_kandungan) ?>'>Edit</button>

                        <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKandungan(<?php echo $row_kandungan["kandungan_id"]; ?>)'>Hapus Kandungan</button>
            </div>
        <?php endwhile; ?>
    </div>
</div>
                                        <?php else : ?>
                                            <p>Tiada kandungan dijumpai untuk SP ini.</p>
                                        <?php endif; ?>
                                                                        </div>
                                                                    <?php endwhile; ?>
                                                                <?php else : ?>
                                                                    <p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                <!-- right column for navigation -->                
                            <div class="col-md-3">
                            <div class="text-center"> <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSPModal">Tambah SP</button></div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Standard Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="spNavList">
                            <?php $result_sp->data_seek(0); ?> <!-- Move this line here -->
                            <?php if ($result_sp->num_rows > 0) : ?>
                                <?php while ($row_sp = $result_sp->fetch_assoc()) : ?>
                                    <li class="list-group-item">
                                        <a href="#" data-sp-id="<?= $row_sp["sp_id"] ?>">
                                            <?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . "  " . $row_sp["nama_sp"] ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            </div>
        </main>
    </div>
</div>

<?php include 'modals.php'; ?>


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

editSPForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Confirmation dialog
    if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
        return; // Stop submission if the user cancels
    }

    const formData = new FormData(this);

    fetch('edit_sp.php', { 
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("berjaya dikemaskini")) { 
            alert(data);

            // Reload the page after a 1-second delay
            setTimeout(() => {
                location.reload(); 
            }, 100); 
        } else {
            // Handle error case (display an error alert)
            alert("Error: " + data); 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully
    });
});

$('#addKandunganModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var sp_id = button.data('sp-id');

    var modal = $(this);
    modal.find('.modal-body #spIDForKandungan').val(sp_id); 

    // ... rest of your JavaScript code
});
// Handle 'Tambah Kandungan' button click to set sp_id in the modal
// Handle 'addKandunganForm' submission using Fetch API
document.getElementById('addKandunganForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menambah Kandungan ini?")) {
        return; 
    }

    const formData = new FormData(this);

    fetch('add_kandungan.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.startsWith("Kandungan baru berjaya ditambah!")) {
            // Display the success message in a basic alert
            alert(data);

            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 100); // 100 milliseconds delay

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

// Function to handle delete confirmation and AJAX request for deleting Kandungan
function confirmDeleteKandungan(kandungan_id) {
    if (confirm("Anda yakin ingin menghapus Kandungan ini?")) {
        fetch('delete_kandungan.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `kandungan_id=${kandungan_id}`
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

// Handle 'Edit Kandungan' button click to populate the modal
$('#editKandunganModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var kandunganData = button.data('kandungan');

  var modal = $(this);
  modal.find('.modal-body #kandungan_id').val(kandunganData.kandungan_id);
  modal.find('.modal-body #nama_kandungan').val(kandunganData.nama_kandungan);
  modal.find('.modal-body #deskripsi_kandungan').val(kandunganData.deskripsi_kandungan);
  modal.find('.modal-body #urutan_kandungan').val(kandunganData.urutan_kandungan);
});

// Handle 'editKandunganForm' submission using Fetch API
document.getElementById('editKandunganForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_kandungan.php', { 
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

    $(document).ready(function() {
        var current_sp_name = '<?php echo $current_sp_name; ?>';
        $('.breadcrumb-item.active').text(current_sp_name);
    });

</script>


</html>