<?php
include 'connect.php';
$name = $_SESSION['name'];

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


$sql_kumpulan = "SELECT k.kumpulan_id 
                 FROM ahli_kumpulan ak 
                 JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                 WHERE ak.pelajar_id = $user_id";
$result_kumpulan = $conn->query($sql_kumpulan);

if ($result_kumpulan->num_rows == 0) {
    // User does not have a group, display an error message
    echo "<script>alert('Anda tidak mempunyai kumpulan. Sila hubungi admin untuk mendapatkan kumpulan.'); window.location.href='view_tugasan.php';</script>";
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
    .table tr {
    height: 50px; /* Adjust the height as needed */
}
.table th {
    width: 200px; /* Adjust the width as needed */
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
        py.tarikh_penyerahan1, 
        py.penyerahan_path1, 
        py.komen,
        py.tarikh_penyerahan2, 
        py.penyerahan_path2, 
        py.url_video,
        r.nama_rubrik
FROM kumpulan k 
LEFT JOIN penyerahan py ON k.kumpulan_id = py.kumpulan_id AND py.tugasan_id = $tugasan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
WHERE k.kumpulan_id = $kumpulan_id";

$result_submissions = $conn->query($sql_submissions);

$submission_status = '';
$submission_info = array();
if ($result_submissions->num_rows > 0) {
    $submission_info = $result_submissions->fetch_assoc();
}
?>

<h4><center>PENYERAHAN</center></h4>
<h3><center>Kumpulan : <?= $submission_info['nama_kumpulan']?></center></h3>
<hr class="bg-dark">

<div class="mt-3 mb-4">
    <?php if (empty($submission_info['penyerahan_path1'])): ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubmissionModal1">Hantar Tugasan 1</button>
    <?php else: ?>
        <table class="table table-striped table-bordered table-sm">
        <tr>
                <th colspan ="2" class="text-center text-light" style="background-color: purple;">Status Penyerahan 1</th>
            </tr>
            <tr>
                <th style="background-color: #F6CEFC;">Telah hantar pada:</th>
                <td style="background-color: #F6CEFC;">
                     <?= date("d F Y", strtotime($submission_info['tarikh_penyerahan1'])) ?><br>
                </td>
            </tr>
            <tr>
                <th style="background-color: #F6CEFC;">Fail:</th>
                <td style="background-color: #F6CEFC;">
                   <a target="_blank" href="<?= $submission_info['penyerahan_path1'] ?>"><?= basename($submission_info['penyerahan_path1']) ?></a><br>
                </td>
            </tr>
            <tr>
                <th style="background-color: #F6CEFC;">Komen:</th>
                <td style="background-color: #F6CEFC;">
                     <?= !empty($submission_info['komen']) ? $submission_info['komen'] : 'Belum ada komen'; ?>
                </td>
            </tr>
        </table>

        <?php if (empty($submission_info['komen'])): // If no comment from teacher ?>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editSubmissionModal" 
            data-submission-id="<?= $submission_info['penyerahan_id'] ?>" 
            data-file-path="<?= $submission_info['penyerahan_path1'] ?>">Perbaiki Tugasan</button>
            <button type="button" class='btn btn-danger' onclick="confirmDeleteSubmission(<?= $submission_info['penyerahan_id'] ?>)">Hapus</button>
        <?php else: // If there is a comment from the teacher ?>
            <?php if (empty($submission_info['penyerahan_path2'])): ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubmissionModal2">Hantar Tugasan 2</button>
<?php else: ?>
<table class="table table-striped table-bordered table-sm">
<tr>
<th colspan ="2" class="text-center text-light" style="background-color: orange;">Status Penyerahan 2</th>
</tr>
<tr>
    <th style="background-color: #FFDBBB;">Telah hantar pada:</th>
    <td style="background-color: #FFDBBB;">
         <?= date("d F Y", strtotime($submission_info['tarikh_penyerahan2'])) ?>
    </td>
</tr>
<tr>
    <th style="background-color: #FFDBBB;">Fail:</th>
    <td style="background-color: #FFDBBB;">
       <a target="_blank" href="<?= $submission_info['penyerahan_path2'] ?>"><?= basename($submission_info['penyerahan_path2']) ?></a><br>
    </td>
</tr>
<tr>
    <th style="background-color: #FFDBBB;">Gred:</th>
    <td style="background-color: #FFDBBB;">
        <?= !empty($submission_info['nama_rubrik']) ? $submission_info['nama_rubrik'] : 'Belum dinilai'; ?>
    </td>
</tr>
</table>

<?php if (!empty($submission_info['penyerahan_path2']) && empty($submission_info['nama_rubrik'])): ?>
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editSubmissionModal2" 
    data-submission-id="<?= $submission_info['penyerahan_id'] ?>" 
    data-file-path="<?= $submission_info['penyerahan_path2'] ?>">Perbaiki Tugasan</button>
    <button type="button" class='btn btn-danger' onclick="confirmDeleteSubmission2(<?= $submission_info['penyerahan_id'] ?>)">Hapus</button>
<?php endif; ?>

<?php if (empty($submission_info['url_video'])): ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubmission3Modal">Hantar Video Permbentangan (Pilihan)</button>
<?php else: ?>
    <table class="table table-striped table-bordered mt-4">
        <tr>
            <th style="background-color: #e0f2ff;">Video Pembentangan</th>
            <td style="background-color: #e0f2ff;">
                URL: <a target="_blank" href="<?= $submission_info['url_video'] ?>"><?= $submission_info['url_video'] ?></a><br>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editSubmissionModal3" 
        data-submission-id="<?= $submission_info['penyerahan_id'] ?>" 
        data-url="<?= $submission_info['url_video'] ?>">Perbaiki Video pembentangan</button>
        <button type="button" class='btn btn-danger' onclick="confirmDeleteSubmission3(<?= $submission_info['penyerahan_id'] ?>)">Hapus</button>
            </td>
        </tr>
    </table>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

</div>

            </div>
        </div>

    </main>
</div>
</div>

<div class="modal fade" id="addSubmissionModal1" tabindex="-1" role="dialog" aria-labelledby="addSubmissionModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubmissionModalLabel1">Add Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubmissionForm1" enctype="multipart/form-data"> 
                    <input type="hidden" name="tugasan_id" value="<?= $tugasan_id ?>">
                    <input type="file" name="file" id="submissionFile" required>
                    <button type="submit" class="btn btn-primary mt-3">Hantar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSubmissionModal2" tabindex="-1" role="dialog" aria-labelledby="addSubmissionModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubmissionModalLabel2">Add Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubmissionForm2" enctype="multipart/form-data"> 
                    <input type="hidden" name="tugasan_id" value="<?= $tugasan_id ?>">
                    <input type="file" name="file" id="submissionFile" required>
                    <button type="submit" class="btn btn-primary mt-3">Hantar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSubmission3Modal" tabindex="-1" role="dialog" aria-labelledby="addSubmission3ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubmission3ModalLabel">Hantar Video Pembentangan (Pilihan)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubmission3Form" method="post">
                <input type="hidden" name="tugasan_id" value="<?= $tugasan_id ?>">
                    <div class="form-group">
                        <label for="url">Pautan URL Video Persembahan:</label>
                        <input type="text" class="form-control" id="url" name="url" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Hantar</button>
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
                <button type="submit" class="btn btn-primary" form="editSubmissionForm">Save Changes</button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editSubmissionModal2" tabindex="-1" role="dialog" aria-labelledby="editSubmissionModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubmissionModalLabel2">Edit Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
  <form id="editSubmissionForm2" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-primary" form="editSubmissionForm2">Save Changes</button> 
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editSubmissionModal3" tabindex="-1" role="dialog" aria-labelledby="editSubmissionModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubmissionModalLabel3">Edit Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="editSubmissionForm3" enctype="multipart/form-data">
                    <input type="hidden" id="editSubmissionId" name="submission_id">
                    <div class="form-group">
                        <label for="editUrl">Pautan URL Video Persembahan:</label>
                        <input type="text" class="form-control" id="editUrl" name="editUrl" required>
                    </div>
                </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="editSubmissionForm3">Simpan Perubahan</button> 
            </div>
        </div>
    </div>
</div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables .bootstrap4.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable();
    });

    document.getElementById('addSubmissionForm1').addEventListener('submit', function(event) {
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


document.getElementById('addSubmissionForm2').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    if (!confirm("Anda yakin ingin hantar tugasan?")) {
    return; 
  }
    const formData = new FormData(this); 


    fetch('submit_tugasan2.php', {
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


document.getElementById('addSubmission3Form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    if (!confirm("Anda yakin ingin hantar pautan URL?")) {
    return; 
  }
    const formData = new FormData(this); 


    fetch('submit_tugasan3.php', {
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


// Handle 'Edit Submission2' button click to populate the modal
$('#editSubmissionModal2').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var submissionId = button.data('submissionId');
  var filePath = button.data('filePath');
  var oldFilePath = button.data('filePath');

  var modal = $(this);
  modal.find('.modal-body #editSubmissionId').val(submissionId);
  modal.find('.modal-body #oldFilePath').val(filePath); // Populate the hidden input
  modal.find('.modal-body #current-file').text(filePath); // Display the current file path
});

// Handle 'editSubmissionForm2' submission
document.getElementById('editSubmissionForm2').addEventListener('submit', function(event) {
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

  fetch('edit_submission2.php', { 
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


// Handle 'Edit Submission3' button click to populate the modal
$('#editSubmissionModal3').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var submissionId = button.data('submissionId');
  var url = button.data('url');

  var modal = $(this);
  modal.find('.modal-body #editSubmissionId').val(submissionId);
  modal.find('.modal-body #editUrl').val(url); // Display the current file path
});

// Handle 'editSubmissionForm3' submission
document.getElementById('editSubmissionForm3').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_submission3.php', { 
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
    if (confirm("Anda yakin ingin menghapus penyerahan ini?")) {
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

function confirmDeleteSubmission2(submission_id) {
    if (confirm("Anda yakin ingin menghapus penyerahan ini?")) {
        // User confirmed, proceed with deletion

        fetch('delete_submission2.php', { 
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

function confirmDeleteSubmission3(submission_id) {
    if (confirm("Anda yakin ingin menghapus pautan URL ini?")) {
        // User confirmed, proceed with deletion

        fetch('delete_submission3.php', { 
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