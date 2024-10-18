<?php
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

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="tugasan.php">Tugasan</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="view_tugasan.php">Projek</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row_tugasan['nama_tugasan']?></li>

            </ol>
        </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='view_tugasan.php?id=<?= $sk_id ?>' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 

            </div>

            <div class="card">
                <div class="card-body">
                <h3><?= $row_tugasan["nama_tugasan"] ?></h3>
                <hr class ="bg-dark">
                <p><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                    <p><strong>Tarikh Akhir:</strong> <?= ($row_tugasan["tarikh_due"] != '0000-00-00' && $row_tugasan["tarikh_due"] != null) ? date("d F Y", strtotime($row_tugasan["tarikh_due"])) : '<center>-</center>' ?></p>
                    <hr class ="bg-dark">
                    <p><?= $row_tugasan["deskripsi_tugasan"] ?></p>


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
                    <hr class="bg-dark">
                    <div class="mt-4">
                        
    <h4><center>PENYERAHAN</center></h4>
    <hr class="bg-dark">

    <?php
// Retrieve submissions for the current user and tugasan
$sql_submissions = "SELECT 
    py.penyerahan_id,
    p.nama_pelajar, 
    py.tarikh_penyerahan1, 
    py.penyerahan_path1, 
    py.rubrik_id,
    r.nama_rubrik, 
    CASE 
        WHEN py.penyerahan_id IS NOT NULL THEN 'Telah Hantar' 
        ELSE 'Belum Dihantar' 
    END AS status
FROM pelajar p 
LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.tugasan_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
WHERE p.pelajar_id = '".$_SESSION['id']."'";

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
            data-file-path="<?php echo $submission_info['penyerahan_path']; ?>">Perbaiki Tugasan</button>
            <button type="button" class='btn btn-danger' onclick="confirmDeleteSubmission(<?= $submission_info['penyerahan_id'] ?>)">Hapus</button>
        <?php endif; ?>
    <?php endif; ?>
</div>

<table class="table table-striped table-bordered">
    <tr>
        <th>Status Penyerahan</th>
        <td>
            <?php
            if ($submission_status == 'submitted') {
                echo 'Telah Submit pada : ' . date("d F Y", strtotime($submission_info['tarikh_penyerahan'])) . '<br>';
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
    <th>Status Penilaian</th>
    <td>
        <?php
        $sql_grading_status = "SELECT 
            CASE 
                WHEN r.nama_rubrik IS NOT NULL THEN 'Telah Dinilai' 
                ELSE 'Belum Dinilai' 
            END AS status
        FROM pelajar p 
        LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id AND py.tugasan_id = $tugasan_id
        LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
        WHERE p.pelajar_id = '".$_SESSION['id']."'";

        $result_grading_status = $conn->query($sql_grading_status);
        $row_grading_status = $result_grading_status->fetch_assoc();

        $grading_status = $row_grading_status['status'];
        echo $grading_status;
        ?>
    </td>
</tr>
    <tr>
        <th>Masa yang tinggal<br> untuk Penyerahan</th>
        <td>
        <?php
            $due_date = new DateTime($row_tugasan["tarikh_due"]);
            $now = new DateTime();
            $interval = $now->diff($due_date);

            if ($interval->invert == 0) { // Due date is in the future
                echo $interval->format('%a hari %h jam lagi');
            } else {
                // Calculate the number of days that have passed
                $days_passed = abs($interval->days);

                // Display the message with the number of days passed
                echo "<span class='badge bg-danger badge-pill text-white ' > Lewat selama " . $days_passed . " hari</span>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>Tarikh Tugasan <br>Diperbaharui</th>
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

// Handle 'editSubmissionForm' submission
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
        // User confirmed, proceed with deletion

        fetch('delete_submission.php', { 
            method: 'POST', 
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `submission_id=${submission_id}`
        })
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
}
</script>

</html>