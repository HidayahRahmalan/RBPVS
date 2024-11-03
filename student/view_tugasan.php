<?php
include 'connect.php';
$name = $_SESSION['name'];


        // Fetch all Tugasan related to this SK
        $sql_tugasan = "SELECT * FROM tugasan ORDER BY tarikh_due DESC"; 
        $result_tugasan = $conn->query($sql_tugasan);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modul</title>
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
        background-color: #28a745; 
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
                <li class="breadcrumb-item active" aria-current="page">Projek</li>
            </ol>
        </nav>

        
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='tugasan.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Projek</h1> 
            </div>

            <div class="row" id="tugasanList"> 
                <?php if ($result_tugasan->num_rows > 0): ?>
                    <?php while ($row_tugasan = $result_tugasan->fetch_assoc()): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                <h5 class="card-title"><strong><?= $row_tugasan["nama_tugasan"] ?></strong></h5>
                                <hr class ="bg-dark">
                                    <p class="card-text"><?= $row_tugasan["deskripsi_tugasan"] ?></p>
                                    <p class="card-text"><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                                    <p class="card-text"><strong>Tarikh Akhir:</strong> <?= date("d F Y", strtotime($row_tugasan["tarikh_due"])) ?></p>
                                    <?php 

                                            $tugasan_id = $row_tugasan["tugasan_id"];
                                            $student_id = $_SESSION['id'];

                                            $sql_kumpulan = "SELECT k.kumpulan_id 
                                                        FROM ahli_kumpulan ak 
                                                        JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                                                        WHERE ak.pelajar_id = $student_id";
                                        $result_kumpulan = $conn->query($sql_kumpulan);

                                        if ($result_kumpulan->num_rows > 0) {
                                            $kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];
                                        } else {
                                            $kumpulan_id = null;
                                        }

                                        $sql_submission = "SELECT p.*, r.nama_rubrik FROM penyerahan p 
                                                            LEFT JOIN rubrik r ON p.rubrik_id = r.rubrik_id 
                                                            WHERE p.tugasan_id = $tugasan_id AND (p.pelajar_id = $student_id";
                                            if ($kumpulan_id != null) {
                                                $sql_submission .= " OR p.kumpulan_id = $kumpulan_id";
                                            }
                                            $sql_submission .= ")";
                                            $result_submission = $conn->query($sql_submission);

                                            if ($result_submission->num_rows > 0) {
                                            $submission_row = $result_submission->fetch_assoc();
                                            if (!is_null($submission_row["penyerahan_path1"])) {
                                            echo "<p class='card-text'><strong>Status:</strong> Telah Hantar</p>";
                                            } else {
                                            echo "<p class='card-text'><strong>Status:</strong> Belum Hantar</p>";
                                            }
                                            if (!is_null($submission_row["rubrik_id"])) {
                                            echo "<p class='card-text'><strong>Gred:</strong> " . $submission_row["nama_rubrik"] . "</p>";
                                            echo "<button class='btn btn-success btn-sm' onclick=\"window.open('certificate.php?tugasan_id=" . $tugasan_id . "', '_blank');\">Cetak Sijil</button>";
                                            }
                                            } else {
                                            echo "<p class='card-text'><strong>Status:</strong> Belum Hantar</p>";
                                            }
                                    ?>

                                    <div class="mt-3"> 
                                    <input type="hidden" class="jenisTugasan" value="<?= $row_tugasan["jenis_tugasan"] ?>">
                                    <input type="hidden" class="tugasanId" value="<?= $row_tugasan["tugasan_id"] ?>">
                                  <button id="viewTugasanDetail" class="btn btn-info btn-sm mr-2">Lihat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12"> 
                        <center><p>Tiada tugasan dijumpai.</p></center>
                    </div>
                <?php endif; ?>
            </div> 

        </main>
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
</script>
</html>

