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

        // Fetch the SK details associated with this Tugasan
        $sk_id = $row_tugasan["sk_id"];
        $sql_sk = "SELECT * FROM standard_kandungan WHERE sk_id = $sk_id";
        $result_sk = $conn->query($sql_sk);
        $row_sk = $result_sk->fetch_assoc(); 
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='view_tugasan.php?id=<?= $sk_id ?>' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Detail Tugasan</h1> 
            </div>

            <div class="card">
                <div class="card-body">
                <p><strong>Standard Kandungan:</strong> 6.<?= $row_sk["kod_sk"] ?> <?= $row_sk["nama_sk"] ?></p>
                    <h3><?= $row_tugasan["nama_tugasan"] ?></h3><br>
                    <p><?= $row_tugasan["deskripsi_tugasan"] ?></p><br>
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
                    <p><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                    <p><strong>Tarikh Akhir:</strong> <?= $row_tugasan["tarikh_due"] ?></p>

<hr class ="bg-dark">
<h3 class="mt-4 text-center">Senarai Pelajar</h3>

<?php
// Fetch students and their submission status for this assignment
// Adjust this query to include group information if needed
$sql_pelajar_submission = "SELECT 
    p.nama_pelajar, py.penyerahan_id,
    py.tarikh_penyerahan, 
    py.penyerahan_path, py.rubrik_id,
    r.markah, 
    CASE 
        WHEN py.penyerahan_id IS NOT NULL THEN 'Telah Hantar' 
        ELSE 'Belum Dihantar' 
    END AS status
FROM pelajar p 
LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.tugasan_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id";

$result_pelajar_submission = $conn->query($sql_pelajar_submission);

if ($result_pelajar_submission->num_rows > 0): 
?>
<table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nama Pelajar</th>
            <th>Tarikh Hantar</th>
            <th>Fail</th>
            <th>Status</th>
            <th>Markah</th> 
            <th>Tindakan</th> 
        </tr>
    </thead>
    <tbody>
        <?php while ($row_pelajar_submission = $result_pelajar_submission->fetch_assoc()): ?>
            <tr>
                <td><?= $row_pelajar_submission["nama_pelajar"] ?></td>
                <td><?= $row_pelajar_submission["tarikh_penyerahan"] ?? '<center>-</center>' ?></td> 
                <td>
                    <?php if (!empty($row_pelajar_submission["penyerahan_path"])): ?>
                        <a href="<?= $row_pelajar_submission["penyerahan_path"] ?>" target="_blank">Lihat Fail</a>
                    <?php else: ?>
                        <center>-</center>
                    <?php endif; ?>
                </td>
                <td><?= $row_pelajar_submission["status"] ?></td>
                <td>
                <?php 
    // Fetch markah dari database 
    $rubrik_id = $row_pelajar_submission["rubrik_id"]; 

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT markah FROM rubrik WHERE rubrik_id = ?");
    $stmt->bind_param("i", $rubrik_id); 
    $stmt->execute();
    $result_markah = $stmt->get_result();

    if ($result_markah->num_rows > 0) {
        $row_markah = $result_markah->fetch_assoc();
        echo $row_markah["markah"] ?? '<center>-</center>'; 
    } else {
        echo '<center>-</center>'; 
    }
                    ?>
                </td>
                <td>
            <?php if ($row_pelajar_submission["status"] === 'Telah Hantar'): ?>
                <?php
                // Check if a markah has already been assigned
                $sql_check_markah = "SELECT * FROM penyerahan WHERE penyerahan_id = ? AND rubrik_id IS NOT NULL";
                $stmt = $conn->prepare($sql_check_markah);
                $stmt->bind_param("i", $row_pelajar_submission["penyerahan_id"]);
                $stmt->execute();
                $result_check_markah = $stmt->get_result();

                if ($result_check_markah->num_rows > 0) {
                    // Display "Edit Markah" button
                    ?>
<button type='button' class='btn btn-primary btn-sm' 
        data-toggle='modal' 
        data-target='#editMarkahModal'
        data-penyerahan-id="<?= $row_pelajar_submission['penyerahan_id'] ?>"
        data-nama-pelajar="<?= $row_pelajar_submission['nama_pelajar'] ?>"
        data-rubrik-id="<?= $row_pelajar_submission['rubrik_id'] ?>">
  Edit Markah
</button>
                    <?php
                } else {
                    // Display "Beri Nilai" button
                    ?>
                    <button type='button' class='btn btn-success btn-sm' 
                            data-toggle='modal' data-target='#beriNilaiModal'
                            data-penyerahan-id="<?= $row_pelajar_submission["penyerahan_id"] ?>"
                            data-nama-pelajar="<?= $row_pelajar_submission["nama_pelajar"] ?>">
                        Beri Nilai
                    </button>
                    <?php
                }
                ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endwhile; ?>
    </tbody>
                    </table>
                    <?php else: ?>
                        <p>Tiada pelajar dijumpai untuk tugasan ini.</p>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Add Rubrik modal -->
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
        <form id="nilai-form">
          <input type="hidden" id="penyerahan-id" name="penyerahan_id">
          <input type="hidden" id="nama-pelajar" name="nama_pelajar">
          <input type="hidden" id="rubrik-id" name="rubrik_id">
          <?php
// Fetch all markah from rubrik table
$sql_markah = "SELECT * FROM rubrik";
$result_markah = $conn->query($sql_markah);

$markah_details = array();
while ($row_markah = $result_markah->fetch_assoc()) {
  $markah_details[$row_markah["markah"]] = array(
    "rubrik_id" => $row_markah["rubrik_id"],
    "nama_rubrik" => $row_markah["nama_rubrik"],
    "deskripsi_rubrik" => $row_markah["deskripsi_rubrik"],
    // add other details you want to retrieve
  );
}
?>
<div class="form-group">
  <label for="nilai">Nilai:</label>
  <select id="nilai" name="nilai" class="form-control" required onchange="showRubrikDetails(this.value)">
    <?php
    foreach ($markah_details as $markah => $details) {
      echo "<option value='" . $markah . "'>" . $markah . "</option>";
    }
    ?>
  </select>
  <div id="rubrik-details">
    <p id="nama-rubrik"></p>
    <p id="deskripsi-rubrik"></p>
  </div>
</div>
        </form>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="nilai-form" class="btn btn-primary">Simpan Nilai</button>
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
        <form id="edit-markah-form">
          <!-- Ensure unique IDs for these input fields -->
          <input type="hidden" id="penyerahan-id-edit" name="penyerahan_id">
          <input type="hidden" id="nama-pelajar-edit" name="nama_pelajar">
          <input type="hidden" id="rubrik-id-edit" name="rubrik_id">
          <div class="form-group">
            <label for="nilai-edit">Nilai:</label>
            <select id="nilai-edit" name="nilai" class="form-control" required>
              <?php
              foreach ($markah_details as $markah => $details) {
                echo "<option value='" . $markah . "'>" . $markah . "</option>";
              }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="edit-markah-form" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>



<!-- Edit Markah modal -->
<div class="modal fade" id="editMarkahModal2" tabindex="-1" role="dialog" aria-labelledby="editMarkahModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMarkahModalLabel">Edit Markah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-markah-form">
          <input type="text" id="penyerahan-id-edit" name="penyerahan_id">
          <input type="text" id="rubrik-id-edit" name="rubrik_id">
          <div class="form-group">
            <label for="nilai-edit">Nilai:</label>
            <select id="nilai-edit" name="nilai" class="form-control" required>
              <?php
              foreach ($markah_details as $markah => $details) {
                echo "<option value='" . $markah . "'>" . $markah . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" form="edit-markah-form" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
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

// Handle 'Beri Nilai' button click to set penyerahan_id, nama_pelajar, and rubrik_id in the modal
$('#beriNilaiModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var penyerahan_id = button.data('penyerahan-id');
    var nama_pelajar = button.data('nama-pelajar');

    var modal = $(this);
    modal.find('.modal-body #penyerahan-id').val(penyerahan_id);
    modal.find('.modal-body #nama-pelajar').val(nama_pelajar);
    
    // Automatically select the first rubrik based on the nilai in the dropdown
    const selectedMarkah = modal.find('#nilai').val();
    const rubrikDetails = <?php echo json_encode($markah_details); ?>;
    const rubrikId = rubrikDetails[selectedMarkah].rubrik_id;
    
    modal.find('.modal-body #rubrik-id').val(rubrikId);
});

// Handle 'nilai-form' submission using Fetch API for Add Nilai
document.getElementById('nilai-form').addEventListener('submit', function(event) {
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
        if (data.startsWith("Nilai baru berjaya ditambah!")) {
            alert(data);
            setTimeout(() => location.reload(), 100);
        } else {
            alert("Error: " + data);
        }

        const beriNilaiModal = document.getElementById('beriNilaiModal');
        const modal = bootstrap.Modal.getInstance(beriNilaiModal);
        modal.hide();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


  

  var markahDetails = <?php echo json_encode($markah_details); ?>;

  function showRubrikDetails(markah) {
    var details = markahDetails[markah];
    if (details) {
        document.getElementById("nama-rubrik").innerHTML = "Nama Rubrik: " + details.nama_rubrik;
        document.getElementById("deskripsi-rubrik").innerHTML = "Deskripsi Rubrik: " + details.deskripsi_rubrik;
        document.getElementById("rubrik-id-edit").value = details.rubrik_id; // Update the rubrik_id input value
    } else {
        document.getElementById("nama-rubrik").innerHTML = "";
        document.getElementById("deskripsi-rubrik").innerHTML = "";
        document.getElementById("rubrik-id-edit").value = ""; // Clear the rubrik_id input value
    }
}

// Handle 'Edit Markah' button click to set penyerahan_id, nama_pelajar, and rubrik_id in the modal
$('#editMarkahModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var penyerahan_id = button.data('penyerahan-id');
    var nama_pelajar = button.data('nama-pelajar');
    var rubrik_id = button.data('rubrik-id'); // This should come from the database

    var modal = $(this);
    modal.find('.modal-body #penyerahan-id-edit').val(penyerahan_id);
    modal.find('.modal-body #nama-pelajar-edit').val(nama_pelajar);

    // Set the rubrik_id from the data attribute or based on the selected nilai in the dropdown
    modal.find('.modal-body #rubrik-id-edit').val(rubrik_id);
});

// Handle 'edit-markah-form' submission using Fetch API for Edit Markah
document.getElementById('edit-markah-form').addEventListener('submit', function(event) {
    event.preventDefault();

    if (!confirm("Anda yakin ingin mengedit nilai ini?")) {
        return;
    }

    // Before submitting, update the rubrik_id with the selected value from the dropdown
    const selectedMarkah = document.getElementById('nilai-edit').value;
    const rubrikDetails = <?php echo json_encode($markah_details); ?>;
    const rubrikId = rubrikDetails[selectedMarkah].rubrik_id;

    // Set the rubrik_id field in the form before submission
    document.getElementById('rubrik-id-edit').value = rubrikId;

    const formData = new FormData(this);

    fetch('edit_nilai.php', { // Make sure you have this PHP script ready
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.startsWith("Nilai berjaya dikemaskini!")) {
            alert(data);
            setTimeout(() => location.reload(), 100);
        } else {
            alert("Error: " + data);
        }

        const editMarkahModal = document.getElementById('editMarkahModal');
        const modal = bootstrap.Modal.getInstance(editMarkahModal);
        modal.hide();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


</script>

</html>

