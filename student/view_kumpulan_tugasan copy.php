<?php
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

$user_id = $_SESSION['id'];
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

                    <hr class="bg-dark">
                    <div class="mt-4">
                        
    <h4>Submission</h4>

    <?php

// Retrieve the kumpulan_id associated with the current user
$sql_kumpulan = "SELECT k.kumpulan_id 
                 FROM ahli_kumpulan ak 
                 JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                 WHERE ak.pelajar_id = $user_id";
$result_kumpulan = $conn->query($sql_kumpulan);
$kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];

// Use the retrieved kumpulan_id in the subsequent SQL queries
$sql_submissions = "SELECT 
    py.penyerahan_id,
    k.nama_kumpulan, 
    py.tarikh_penyerahan, 
    py.penyerahan_path, 
    py.rubrik_id,
    r.markah, 
    CASE 
        WHEN py.penyerahan_id IS NOT NULL THEN 'Telah Hantar' 
        ELSE 'Belum Dihantar' 
    END AS status
FROM kumpulan k 
LEFT JOIN penyerahan py ON k.kumpulan_id = py.kumpulan_id AND py.tugasan_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
WHERE k.kumpulan_id = $kumpulan_id";

$result_submissions = $conn->query($sql_submissions);

$submission_status = '';
$submission_info = array();
if ($result_submissions->num_rows > 0) {
    while ($row_submission = $result_submissions->fetch_assoc()) {
        if ($row_submission['status'] == 'Telah Hantar') {
            $submission_status = 'submitted';
            $submission_info = $row_submission;
        } else {
            $submission_status = 'Belum Hantar';
        }
    }
} else {
    $submission_status = 'Belum Hantar';
}
?>

<div class="mt-3 mb-4">
    <?php if ($submission_status == 'Belum Hantar'): ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubmissionModal">Hantar Tugasan</button>
    <?php elseif ($submission_status == 'submitted'): ?>
        <?php if (!empty($submission_info['rubrik_id'])): ?>

        <?php else: ?>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editSubmissionModal" 
            data-submission-id="<?php echo $submission_info['penyerahan_id']; ?>" 
            data-file-path="<?php echo $submission_info['penyerahan_path']; ?>">Edit Submission</button>
            <button type="button" class='btn btn-danger' onclick="confirmDeleteSubmission(<?= $submission_info['penyerahan_id'] ?>)">Hapus</button>
        <?php endif; ?>
    <?php endif; ?>
</div>

<table class="table table-striped table-bordered">
<tr>
        <th>Nama Kumpulan</th>
        <td>
            <?php
            $sql_kumpulan = "SELECT k.nama_kumpulan 
                             FROM ahli_kumpulan ak 
                             JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                             WHERE ak.pelajar_id = $user_id";
            $result_kumpulan = $conn->query($sql_kumpulan);
            $kumpulan_name = $result_kumpulan->fetch_assoc()['nama_kumpulan'];
            echo $kumpulan_name;
            ?>
        </td>
    </tr>
    <tr>
        <th>Submission Status</th>
        <td>
            <?php
            if ($submission_status == 'submitted') {
                echo 'Submitted on ' . $submission_info['tarikh_penyerahan'] . '<br>';
                echo 'File: <a target="_blank" href="' . $submission_info['penyerahan_path'] . '">' . basename($submission_info['penyerahan_path']) . '</a><br>';
                if (!empty($submission_info['markah'])) {
                    echo 'Grade: ' . $submission_info['markah'] . '<br>';
                }
            } else {
                echo  $submission_status . '<br>';
            }
            ?>
        </td>
    </tr>
    <tr>
    <th>Grading status</th>
    <td>
    <?php
    $sql_kumpulan = "SELECT k.kumpulan_id 
                     FROM ahli_kumpulan ak 
                     JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                     WHERE ak.pelajar_id = $user_id";
    $result_kumpulan = $conn->query($sql_kumpulan);
    $kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];

    $sql_grading_status = "SELECT 
        CASE 
            WHEN r.markah IS NOT NULL THEN 'Telah Dinilai' 
            ELSE 'Belum Dinilai' 
        END AS status
    FROM kumpulan k 
    LEFT JOIN penyerahan py ON k.kumpulan_id = py.kumpulan_id AND py.tugasan_id = $tugasan_id
    LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
    WHERE k.kumpulan_id = $kumpulan_id";

    $result_grading_status = $conn->query($sql_grading_status);
    $row_grading_status = $result_grading_status->fetch_assoc();

    $grading_status = $row_grading_status['status'];
    echo $grading_status;
    ?>
</td>
</tr>
    <tr>
        <th>Time remaining</th>
        <td>
            <?php
            $due_date = new DateTime($row_tugasan["tarikh_due"]);
            $now = new DateTime();
            $interval = $now->diff($due_date);

            if ($interval->invert == 0) { // Due date is in the future
                echo $interval->format('%a days %h hours remaining');
            } else {
                echo "Past due";
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>Last modified</th>
        <td>-</td>
    </tr>
</table>

</div>

                </div>
            </div>

        </main>
    </div>
</div>

<div class="modal fade" id="addSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="addSubmissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubmissionModalLabel">Add Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addSubmissionForm" enctype="multipart/form-data"> 
                    <input type="hidden" name="tugasan_id" value="<?= $tugasan_id ?>">
                    <input type="file" name="file" id="submissionFile" required>
                    <button type="submit" class="btn btn-primary mt-3">Hantar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="editSubmissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubmissionModalLabel">Edit Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
  <form id="editSubmissionForm" enctype="multipart/form-data">
    <input type="hidden" id="editSubmissionId" name="submission_id">
    <input type="hidden" id="oldFilePath" name="submission_path">
    <div class="form-group">
      <label for="editSubmissionFile">File:</label>
      <input type="file" class="form-control" id="editSubmissionFile" name="file">
      <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
    </div>
  </form>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button   
 type="submit" class="btn btn-primary" form="editSubmissionForm">Save Changes</button> 
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
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable();
    });


    document.getElementById('addSubmissionForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    if (!confirm("Anda yakin ingin hantar tugasan?")) {
    return; 
  }
    const formData = new FormData(this);   


    fetch('submit_tugasan.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Handle the server response (display success/error message)
    alert(data);
    setTimeout(() => {
        location.reload(); 
    }, 100);
  })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully (e.g., display an error message to the user)
    });
});

// Handle 'Edit Submission' button click to populate the modal
$('#editSubmissionModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var submissionId = button.data('submissionId');
  var filePath = button.data('filePath');
  var oldFilePath = button.data('filePath');

  var modal = $(this);
  modal.find('.modal-body #editSubmissionId').val(submissionId);
  modal.find('.modal-body #oldFilePath').val(filePath); // Populate the hidden input
  modal.find('.modal-body #current-file').text(filePath); // Display the current file path
});

// Handle ' editSubmissionForm' submission
document.getElementById('editSubmissionForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);
  const fileInput = document.getElementById('editSubmissionFile');
  const oldFilePath = document.getElementById('oldFilePath').value;
  formData.append('oldFilePath', oldFilePath); 
  if (fileInput.files.length > 0) {
    formData.append('file', fileInput.files[0]);
  }

  fetch('edit_submission.php', { 
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
    // Handle errors gracefully
  });
});

function confirmDeleteSubmission(submission_id) {
    if (confirm("Anda yakin ingin menghapus submission ini?")) {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `submission_id=${submission_id}`
        }
        .then(response => response.text())
        .then(data => {
            alert(data); 
            location.reload(); 
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred during deletion. Please try again."); 
        });
    }
</script>

</html>