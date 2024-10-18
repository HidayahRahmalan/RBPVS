<?php
session_start();
include 'connect.php';

// Fetch the Tugasan details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $tugasan_id = intval($_GET['id']);
    $sql_tugasan = "SELECT * FROM tugasan WHERE tugasan_id = $tugasan_id";
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
                <li class="breadcrumb-item " aria-current="page"><a href="view_tugasan.php">Projek</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row_tugasan['nama_tugasan']?></li>

            </ol>
        </nav>
        
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='view_tugasan.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <button type='button' class='btn btn-success btn-sm mr-2 mb-3' data-toggle='modal' data-target='#addKandunganModal' 
                data-tugasan-id="<?php echo $row_tugasan['tugasan_id']; ?>">Tambah Kandungan Projek</button>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3><?= $row_tugasan["nama_tugasan"] ?></h3>
                    <hr class ="bg-dark">
                    <p><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                    <p><strong>Tarikh Akhir:</strong> <?= ($row_tugasan["tarikh_due"] != '0000-00-00' && $row_tugasan["tarikh_due"] != null) ? date("d F Y", strtotime($row_tugasan["tarikh_due"])) : '<center>-</center>' ?></p>
                    <hr class ="bg-dark">
                    <p><?= $row_tugasan["deskripsi_tugasan"] ?></p><br>

                                                                       <!-- Fetch Kandungan for this tugasan -->
                                                                       <?php
                                $tugasan_id = $row_tugasan["tugasan_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN_TUGASAN WHERE tugasan_id = $tugasan_id ORDER BY URUTAN_KANDUNGAN";
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

                                    <button type='button' class='btn btn-danger btn-sm' onclick='confirmDeleteKandungan(<?php echo $row_kandungan["kandungan_tugasan_id"]; ?>)'>Hapus Kandungan</button>
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
<h3 class="mt-4 text-center">Senarai Kumpulan</h3>

<?php
// Fetch kumpulan and their submission status for this assignment
// Adjust this query to include group information if needed
$sql_kumpulan_submission = "SELECT 
    k.nama_kumpulan, py.penyerahan_id,
    py.tarikh_penyerahan1, py.komen, py.tarikh_penyerahan2,
    py.penyerahan_path1, py.penyerahan_path2, py.url_video, py.rubrik_id, py.markah, 
    CASE 
        WHEN py.penyerahan_id IS NOT NULL THEN 'Telah Hantar' 
        ELSE 'Belum Dihantar' 
    END AS status
FROM kumpulan k 
LEFT JOIN penyerahan py ON k.kumpulan_id = py.kumpulan_id AND py.tugasan_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id";

$result_kumpulan_submission = $conn->query($sql_kumpulan_submission);

if ($result_kumpulan_submission->num_rows > 0): 
?>
<table id="myTable" class="table table-striped table-bordered" style="background-color: #f0f0f0;">
    <thead>
    <tr>
        <th colspan="2"></th>
        <th colspan="3">Penyerahan 1 </th>
        <th colspan="2">Penyerahan 2 </th>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th>No.</th>
        <th>Nama Kumpulan</th>
        <th>Tarikh Hantar</th>
        <th>Komen</th>
        <th>Fail</th>
        <th>Tarikh Hantar</th>
        <th>Fail</th>
        <th>Link Pautan Pembentangan</th>
        <th>Status</th>
        <th>Gred</th>
        <th>Tugasan</th>
    </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        while ($row_kumpulan_submission = $result_kumpulan_submission->fetch_assoc()): ?>
            <tr>
                <td><?= $no ?>.</td>
                <td><?= $row_kumpulan_submission["nama_kumpulan"] ?></td>
                <td><?= ($row_kumpulan_submission["tarikh_penyerahan1"] != '0000-00-00' && $row_kumpulan_submission["tarikh_penyerahan1"] != null) ? date("d F Y", strtotime($row_kumpulan_submission["tarikh_penyerahan1"])) : '<center>-</center>' ?></td>
                <td><?= $row_kumpulan_submission["komen"] ?></td>
                <td>
                    <?php if (!empty($row_kumpulan_submission["penyerahan_path1"])): ?>
                        <a href="<?= $row_kumpulan_submission["penyerahan_path1"] ?>" target="_blank">Lihat Fail</a>
                    <?php else: ?>
                        <center>-</center>
                    <?php endif; ?>
                </td>
                <td><?= ($row_kumpulan_submission["tarikh_penyerahan2"] != '0000-00-00' && $row_kumpulan_submission["tarikh_penyerahan2"] != null) ? date("d F Y", strtotime($row_kumpulan_submission["tarikh_penyerahan2"])) : '<center>-</center>' ?></td>
                <td>
                    <?php if (!empty($row_kumpulan_submission["penyerahan_path2"])): ?>
                        <a href="<?= $row_kumpulan_submission["penyerahan_path2"] ?>" target="_blank">Lihat Fail</a>
                    <?php else: ?>
                        <center>-</center>
                    <?php endif; ?>
                </td>
                <td><a target="_blank" href="<?= $row_kumpulan_submission['url_video'] ?>"><?= $row_kumpulan_submission['url_video'] ?></a></td>
                <td><?= $row_kumpulan_submission["status"] ?></td>
                <td>
                    <?php 
                    // Fetch markah dari database 
                    $rubrik_id = $row_kumpulan_submission["rubrik_id"]; 
        
                    // Use a prepared statement to prevent SQL injection
                    $stmt = $conn->prepare("SELECT nama_rubrik FROM rubrik WHERE rubrik_id = ?");
                    $stmt->bind_param("i", $rubrik_id); 
                    $stmt->execute();
                    $result_markah = $stmt->get_result();
        
                    if ($result_markah->num_rows > 0) {
                        $row_markah = $result_markah->fetch_assoc();
                        echo $row_markah["nama_rubrik"] ?? '<center>-</center>'; 
                    } else {
                        echo '<center>-</center>'; 
                    }
                    ?>
                </td>
                <td>
                    <?php if ($row_kumpulan_submission["status"] === 'Telah Hantar'): ?>
                        <?php if ($row_kumpulan_submission["tarikh_penyerahan1"] != '0000-00-00' && $row_kumpulan_submission["tarikh_penyerahan1"] != null && 
                                  ($row_kumpulan_submission["tarikh_penyerahan2"] == '0000-00-00' || $row_kumpulan_submission["tarikh_penyerahan2"] == null)): ?>
                            <button type='button' class='btn btn-primary btn-sm' 
                                    data-toggle='modal' data-target='#beriKomenModal'
                                    data-penyerahan-id="<?= $row_kumpulan_submission["penyerahan_id"] ?>"
                                    data-nama-kumpulan="<?= $row_kumpulan_submission["nama_kumpulan"] ?>">
                                Beri Komen
                            </button>
                        <?php endif; ?>
                        <?php if ($row_kumpulan_submission["tarikh_penyerahan2"] != '0000-00-00' && $row_kumpulan_submission["tarikh_penyerahan2"] != null): ?>
                            <?php
                            // Check if a markah has already been assigned
                            $sql_check_markah = "SELECT * FROM penyerahan WHERE penyerahan_id = ? AND rubrik_id IS NOT NULL";
                            $stmt = $conn->prepare($sql_check_markah);
                            $stmt->bind_param("i", $row_kumpulan_submission["penyerahan_id"]);
                            $stmt->execute();
                            $result_check_markah = $stmt->get_result();
        
                            if ($result_check_markah->num_rows > 0) {
                                // Display "Edit Markah" button
                                ?>
                            <button type='button' class='btn btn-primary btn-sm' 
                                    data-toggle='modal' 
                                    data-target='#editMarkahModal'
                                    data-penyerahan-id="<?= $row_kumpulan_submission['penyerahan_id'] ?>"
                                    data-markah="<?= $row_kumpulan_submission['markah'] ?>">
                            Edit Markah
                            </button>
                            <?php
                            } else {
                                // Display "Beri Nilai" button
                                ?>
                            <button type='button' class='btn btn-success btn-sm' 
                                    data-toggle='modal' data-target='#beriNilaiModal'
                                    data-penyerahan-id="<?= $row_kumpulan_submission["penyerahan_id"] ?>"
                                    data-nama-kumpulan="<?= $row_kumpulan_submission["nama_kumpulan"] ?>">
                                Beri Nilai
                            </button>
                            <?php
                            }
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>

<?php endwhile; ?>
    </tbody>
                    </table>
                    <?php else: ?>
                        <p>Tiada kumpulan dijumpai untuk tugasan ini.</p>
                    <?php endif; ?>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="komen-form" class="btn btn-primary">Simpan Komen</button>
      </div>
    </div>
  </div>
</div>


<!-- Beri Nilai modal -->
<div class="modal fade" id="beriNilaiModal" tabindex="-1" role="dialog" aria-labelledby="beriNilaiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="beriNilaiModalLabel">Beri Nilai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="beriNilaiForm">
          <input type="hidden" id="penyerahan-id" name="penyerahan_id">
          <input type="hidden" id="nama-pelajar" name="nama_pelajar">
          <input type="hidden" id="rubrik-id" name="rubrik_id">
          <div class="form-group">
            <label for="markah">Markah:</label>
            <input type="number" class="form-control" id="markah" name="markah" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="beriNilaiForm" class="btn btn-primary">Simpan Nilai</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Markah modal -->
<div class="modal fade" id="editMarkahModal" tabindex="-1" role="dialog" aria-labelledby="editMarkahModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMarkahModalLabel">Edit Markah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editMarkahForm">
          <input type="hidden" id="editPenyerahanId" name="penyerahan_id">
          <div class="form-group">
            <label for="editMarkah">Markah:</label>
            <input type="number" class="form-control" id="editMarkah" name="markah" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="editMarkahForm" class="btn btn-primary">Simpan Perubahan</button>
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

    fetch('add_kandunganTugasan.php', {
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
    modal.find('.modal-body #editKandunganId').val(kandungan.kandungan_tugasan_id);
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

  fetch('edit_kandunganTugasan.php', { 
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
        fetch('delete_kandunganTugasan.php', {
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

// Get all elements with class 'jenisTugasan' and 'tugasanId'
var jenisTugasans = document.querySelectorAll('.jenisTugasan');
var tugasanIds = document.querySelectorAll('.tugasanId');

// Add event listener to each 'viewTugasanDetail' button
document.querySelectorAll('#viewTugasanDetail').forEach(function(button, index) {
  button.addEventListener('click', function(event) {
    event.preventDefault();

    // Get the corresponding jenisTugasan and tugasanId values
    var jenisTugasan = jenisTugasans[index].value;
    var tugasanId = tugasanIds[index].value;

    if (jenisTugasan === 'individu') {
      window.location.href = 'view_individu_tugasan.php?id=' + tugasanId;
    } else if (jenisTugasan === 'kumpulan') {
      window.location.href = 'view_kumpulan_tugasan.php?id=' + tugasanId;
    }
  });
});

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

    fetch('add_komen.php', { // Make sure you have this PHP script ready
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


// Handle 'Beri Nilai' button click to set penyerahan_id, nama_pelajar, and rubrik_id in the modal
$('#beriNilaiModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var penyerahan_id = button.data('penyerahan-id');
    var nama_pelajar = button.data('nama-pelajar');
    var rubrik_id = button.data('rubrik-id');

    var modal = $(this);
    modal.find('.modal-body #penyerahan-id').val(penyerahan_id);
    modal.find('.modal-body #nama-pelajar').val(nama_pelajar);
    modal.find('.modal-body #rubrik-id').val(rubrik_id);
});

// Handle 'beriNilaiForm' submission using Fetch API for Add Markah
document.getElementById('beriNilaiForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin memberi nilai ini?")) {
        return;
    }

    const formData = new FormData(this);

    fetch('add_nilai.php', { // Make sure you have this PHP script ready
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


// Handle 'Edit Markah' button click to set penyerahan_id in the modal
$('#editMarkahModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var penyerahan_id = button.data('penyerahan-id');
    var markah = button.data('markah');

    var modal = $(this);
    modal.find('.modal-body #editPenyerahanId').val(penyerahan_id);
    modal.find('.modal-body #editMarkah').val(markah);
});

// Handle 'editMarkahForm' submission using Fetch API for Edit Markah
document.getElementById('editMarkahForm').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin menyimpan perubahan markah ini?")) {
        return;
    }

    const formData = new FormData(this);

    fetch('edit_nilai.php', { // Make sure you have this PHP script ready
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


</script>

</html>