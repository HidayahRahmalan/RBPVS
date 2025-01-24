<?php
session_start();
include 'connect.php';

// Fetch the Tugasan details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $tugasan_id = intval($_GET['id']);
    $sql_tugasan = "SELECT * FROM projek WHERE projek_id = $tugasan_id";
    $result_tugasan = $conn->query($sql_tugasan);

    if ($result_tugasan->num_rows > 0) {
        $row_tugasan = $result_tugasan->fetch_assoc();

    } else {
        echo "Tugasan tidak dijumpai.";
        exit;
    }
} else {
    echo "ID tugasan tidak disediakan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Tugasan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
    main {
        background-color: #e0f2ff; 
    }
    #myTable th {
    background-color: #4C97FF; 
    color: white;
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
                <li class="breadcrumb-item " aria-current="page"><a href="view_tugasan1.php">Tugasan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row_tugasan['nama_projek']?></li>

            </ol>
        </nav>


            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='view_tugasan1.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <button type='button' class='btn btn-success btn-sm mr-2 mb-3' data-toggle='modal' data-target='#addKandunganModal' 
                data-tugasan-id="<?php echo $row_tugasan['projek_id']; ?>">Tambah Kandungan Tugasan</button>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3><?= $row_tugasan["nama_projek"] ?></h3>
                    <hr class ="bg-dark">
                    <p><strong>Tarikh Akhir:</strong> <?= ($row_tugasan["tarikh_due"] != '0000-00-00' && $row_tugasan["tarikh_due"] != null) ? date("d F Y", strtotime($row_tugasan["tarikh_due"])) : '<center>-</center>' ?></p>
                    <hr class ="bg-dark">
                    <p><?= $row_tugasan["deskripsi_projek"] ?></p><br>

                                                   <!-- Fetch Kandungan for this tugasan -->
                                                   <?php
                                $tugasan_id = $row_tugasan["projek_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN_projek WHERE projek_id = $tugasan_id ORDER BY URUTAN_KANDUNGAN";
                                $result_kandungan = $conn->query($sql_kandungan);
                                ?>

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

                                    <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKandungan(<?php echo $row_kandungan["kandungan_projek_id"]; ?>)'>Hapus Kandungan</button>
                        </div>
                    <?php endwhile; ?>


                    <?php if (!empty($row_tugasan["lampiran_path"])): ?>
                            <?php
                            $fileExtension = pathinfo($row_tugasan["lampiran_path"], PATHINFO_EXTENSION);
                            $imageExtensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'ico', 'svg'); 
                            $documentExtensions = array('doc', 'docx', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx'); 
                            if (in_array(strtolower($fileExtension), $imageExtensions)): ?>
                                <img src="<?= $row_tugasan["lampiran_path"] ?>" alt="Lampiran" class="img-thumbnail"><br>
                            <?php elseif (in_array(strtolower($fileExtension), $documentExtensions)): ?>
                                <a href="<?= $row_tugasan["lampiran_path"] ?>" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fas fa-file-<?php echo $fileExtension ?>"></i> <?= basename($row_tugasan["lampiran_path"]) ?>
                                </a><br>
                            <?php else: ?>
                                <a href="<?= $row_tugasan["lampiran_path"] ?>" target="_blank" class="btn btn-info btn-sm"><?= basename($row_tugasan["lampiran_path"]) ?></a><br>
                            <?php endif; ?>
                        <?php endif; ?>
                    <br>
        
<hr class ="bg-dark">
<h3 class="mt-4 text-center">Senarai Murid</h3>

<?php
// Fetch students and their submission status for this assignment
// Adjust this query to include group information if needed

$rubricNames = [];
$studentCounts = [];

// Fetch all rubric names first
$sql_all_rubrics = "SELECT nama_rubrik FROM rubrik";
$result_all_rubrics = $conn->query($sql_all_rubrics);

// Fetch rubric names and initialize counts to zero
while ($row = $result_all_rubrics->fetch_assoc()) {
    $rubricNames[] = $row["nama_rubrik"];
    $studentCounts[] = 0; // Initialize with zero
}

// Now fetch counts based on submissions
$sql_rubrik_count = "
    SELECT r.nama_rubrik, COUNT(py.pelajar_id) AS total_students
    FROM rubrik r
    LEFT JOIN penyerahan py ON r.rubrik_id = py.rubrik_id
    WHERE py.projek_id = $tugasan_id
    GROUP BY r.nama_rubrik";

$result_rubrik_count = $conn->query($sql_rubrik_count);

while ($row_rubrik_count = $result_rubrik_count->fetch_assoc()) {
    $index = array_search($row_rubrik_count["nama_rubrik"], $rubricNames);
    if ($index !== false) {
        $studentCounts[$index] = $row_rubrik_count["total_students"]; // Update count for existing rubric
    }
}

$sql_submission_count = "
 SELECT 
        CASE 
            WHEN py.penyerahan_id IS NULL THEN 'Belum Hantar'
            WHEN py.penyerahan_path2 IS NOT NULL AND py.tarikh_penyerahan2 IS NOT NULL THEN 'Penyerahan 2'
            WHEN py.penyerahan_path1 IS NOT NULL AND py.tarikh_penyerahan1 IS NOT NULL THEN 'Penyerahan 1'
        END AS submission_status,
        COUNT(p.pelajar_id) AS total_students
    FROM pelajar p
    LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.projek_id = $tugasan_id
    GROUP BY submission_status";

$result_submission_count = $conn->query($sql_submission_count);

// Initialize counts for each category
$belumHantarCount = 0;
$penyerahan1Count = 0;
$penyerahan2Count = 0;

// Process the results
while ($row = $result_submission_count->fetch_assoc()) {
    switch ($row["submission_status"]) {
        case 'Belum Hantar':
            $belumHantarCount = $row["total_students"];
            break;
        case 'Penyerahan 1':
            $penyerahan1Count = $row["total_students"];
            break;

    }
}

// Prepare data for the pie chart
$submissionLabels = ['Belum Hantar', 'Penyerahan Tugasan'];
$submissionCounts = [$belumHantarCount, $penyerahan1Count, $penyerahan2Count];

$sql_pelajar_submission = "SELECT 
    p.nama_pelajar, py.penyerahan_id,
    py.tarikh_penyerahan1, py.komen, py.tarikh_penyerahan2,
    py.penyerahan_path1, py.penyerahan_path2, py.url_video, py.rubrik_id, py.markah, 
    CASE 
        WHEN py.penyerahan_id IS NOT NULL THEN 'Telah Hantar' 
        ELSE 'Belum Dihantar' 
    END AS status
FROM pelajar p 
LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.projek_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id";

$result_pelajar_submission = $conn->query($sql_pelajar_submission);

if ($result_pelajar_submission->num_rows > 0): 
?>
<table id="myTable" class="table table-striped table-bordered" style="background-color: #f0f0f0;">
    <thead>
    <tr>
        <th colspan="2"></th>
        <th colspan="3" style="background-color: purple;">Penyerahan Tugasan</th>
      <th colspan="4"></th>
    </tr>
    <tr>
        <th>No.</th>
        <th>Nama Murid</th>
        <th style="background-color: purple;">Tarikh Hantar</th>
        <th style="background-color: purple;">Komen</th>
        <th style="background-color: purple;">Fail</th>
        <th>Tugasan</th>
    </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        while ($row_pelajar_submission = $result_pelajar_submission->fetch_assoc()): 
        
            $studentNames[] = $row_pelajar_submission["nama_pelajar"];
            $grades[] = $row_pelajar_submission["markah"] ?? 0;
            
            ?>
            <tr>
                <td><?= $no ?>.</td>
                <td><?= $row_pelajar_submission["nama_pelajar"] ?></td>
                <td style="background-color: #F6CEFC;"><?= ($row_pelajar_submission["tarikh_penyerahan1"] != '0000-00-00' && $row_pelajar_submission["tarikh_penyerahan1"] != null) ? date("d F Y", strtotime($row_pelajar_submission["tarikh_penyerahan1"])) : '<center>-</center>' ?></td>
                <td style="background-color: #F6CEFC;"><?= $row_pelajar_submission["komen"] ?></td>
                <td style="background-color: #F6CEFC;">
                    <?php if (!empty($row_pelajar_submission["penyerahan_path1"])): ?>
                        <a href="<?= $row_pelajar_submission["penyerahan_path1"] ?>" target="_blank">Lihat Fail</a>
                    <?php else: ?>
                        <center>-</center>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row_pelajar_submission["status"] === 'Telah Hantar'): ?>
                        <?php if ($row_pelajar_submission["tarikh_penyerahan1"] != '0000-00-00' && $row_pelajar_submission["tarikh_penyerahan1"] != null): ?>
                            <button type='button' class='btn btn-primary btn-sm' 
                                    data-toggle='modal' data-target='#beriKomenModal'
                                    data-penyerahan-id="<?= $row_pelajar_submission["penyerahan_id"] ?>"
                                    data-nama-pelajar="<?= $row_pelajar_submission["nama_pelajar"] ?>">
                                Beri Komen
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            
        <?php 
        $no++;
        endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p>Tiada pelajar dijumpai untuk tugasan ini.</p>
<?php endif; ?>


<br>
<hr class ="bg-dark mt-4 mb-4">
            <!-- Column for Submission Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #a0c1d9;">
                        <h6 class="card-title text-center">Carta Status Penyerahan Pelajar</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="submissionChart" style="width: 100%; height: 100px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>

        </main>
    </div>
</div>


    <!-- Add Kandungan Projek modal -->
    <div class="modal fade" id="addKandunganModal" tabindex="-1" role="dialog" aria-labelledby="addKandunganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKandunganModalLabel">Tambah Kandungan Projek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
                    <input type="hidden" id="tugasanID" name="tugasan_id" value=""> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="addKandunganForm">Tambah</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Kandungan Projek modal -->
<div class="modal fade" id="editKandunganModal" tabindex="-1" role="dialog" aria-labelledby="editKandunganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKandunganModalLabel">Edit Kandungan Projek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editKandunganForm" enctype="multipart/form-data">
                    <input type="hidden" id="editKandunganId" name="kandungan_tugasan_id">
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

                    <input type="hidden" id="editTugasanID" name="tugasan_id" value=""> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="editKandunganForm">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Beri Komen modal -->
<div class="modal fade" id="beriKomenModal" tabindex="-1" role="dialog" aria-labelledby="beriKomenModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="beriKomenModalLabel">Beri Komen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="komen-form">
          <input type="hidden" id="penyerahan-id" name="penyerahan_id">
          <input type="hidden" id="nama-pelajar" name="nama_pelajar">
          <div class="form-group">
            <label for="komen">Komen:</label>
            <textarea class="form-control" id="komen" name="komen" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" form="komen-form" class="btn btn-primary">Simpan Komen</button>
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

$(document).ready(function() {
    $('#myTable').DataTable();
    });


    $('#addKandunganModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var tugasan_id = button.data('tugasan-id');

    var modal = $(this);
    modal.find('.modal-body #tugasanID').val(tugasan_id); 
});

// Handle 'addKandunganForm' submission using Fetch API
document.getElementById('addKandunganForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menambah Kandungan ini?")) {
        return; 
    }

    const formData = new FormData(this);

    fetch('add_kandunganTugasan1.php', {
        method: 'POST',
        body: formData
    })
    .then(retugasanonse => retugasanonse.text())
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
    modal.find('.modal-body #editKandunganId').val(kandungan.kandungan_projek_id);
    modal.find('.modal-body #editDeskripsiKandungan').val(kandungan.deskripsi_kandungan);
    modal.find('.modal-body #editUrutanKandungan').val(kandungan.urutan_kandungan);
    modal.find('.modal-body #editTugasanID').val(kandungan.tugasan_id);
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

  fetch('edit_kandunganTugasan1.php', { 
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
function confirmDeleteKandungan(kandungan_tugasan_id) {
    if (confirm("Anda yakin ingin menghapus Kandungan ini?")) {
        fetch('delete_kandunganTugasan1.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `kandungan_tugasan_id=${kandungan_tugasan_id}`
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

// Handle 'Beri Komen' button click to set penyerahan_id and nama_pelajar in the modal
$('#beriKomenModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var penyerahan_id = button.data('penyerahan-id');
    var nama_pelajar = button.data('nama-pelajar');

    var modal = $(this);
    modal.find('.modal-body #penyerahan-id').val(penyerahan_id);
    modal.find('.modal-body #nama-pelajar').val(nama_pelajar);
});


// Handle 'komen-form' submission using Fetch API for Add Komen
document.getElementById('komen-form').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin memberi komen ini?")) {
        return;
    }

    const formData = new FormData(this);

    fetch('add_komen1.php', { // Make sure you have this PHP script ready
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
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('rubricChart5').getContext('2d');

    // Define an array of colors for each bar
    const barColors = [
        'rgba(75, 192, 192, 0.6)',
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)', 
        'rgba(255, 206, 86, 0.6)', 
        'rgba(153, 102, 255, 0.6)', 
        'rgba(255, 159, 64, 0.6)'  
    ];

    const rubricChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($rubricNames); ?>,
            datasets: [{
                label: 'Jumlah Pelajar Berdasarkan Rubrik',
                data: <?php echo json_encode($studentCounts); ?>,
                backgroundColor: barColors,
                borderColor: 'rgba(0, 0, 0, 1)', 
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Set the step size to 1 to avoid decimals
                        stepSize: 1,
                        // Use a callback to format the tick labels as integers
                        callback: function(value) {
                            return Math.floor(value); // Ensures integer values
                        }
                    }
                }
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('submissionChart').getContext('2d');

    const submissionLabels = <?php echo json_encode($submissionLabels); ?>;
    const submissionCounts = <?php echo json_encode($submissionCounts); ?>;

    const submissionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: submissionLabels,
            datasets: [{
                label: 'Status Penyerahan Pelajar',
                data: submissionCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)', // Belum Hantar
                    'rgba(54, 162, 235, 0.6)', // Penyerahan 1
                ],
                borderColor: 'rgba(0, 0, 0, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
});
function confirmLogout() {
  if (confirm("Anda pasti ingin keluar?")) {
    window.location.href = "logout.php"; 
  }
}

</script>

</html>

