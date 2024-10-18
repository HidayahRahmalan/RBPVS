<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css"> 
    </head>
<body>

<div class="container-fluid vh-100 d-flex flex-column"> 
    <div class="row flex-nowrap">
    <nav id="sidebar" class="col-md-2 d-flex flex-column flex-shrink-0 p-3" style="height: 100vh; background-color: #1A237E;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fas fa-chalkboard-teacher fa-md me-2"></i> <span class="fs-4">Halaman Guru </span>
    </a>
    
    <hr> 
    <ul class="nav nav-pills flex-column mb-auto">
    <div class="text-center text-white mb-3"> <small>Daftar masuk sebagai: <u>Haziq</u></small> 
    </div>
        <li class="nav-item">
            <a href="ProfilSaya.php" class="nav-link text-white" aria-current="page"> 

                <i class="fas fa-book me-2"></i> Profil Saya
            </a>
        </li>
        <li class="nav-item">
            <a href="pendaftaranPljr.php" class="nav-link text-white">
                <i class="fas fa-calendar-alt me-2"></i> Pendaftaran Pelajar
            </a>
        </li>
        <li class="nav-item">
            <a href="topik.php" class="nav-link text-white">
                <i class="fas fa-bullhorn me-2"></i> Topik
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-white">
                <i class="fas fa-calendar-alt me-2"></i> Penilaian
            </a>
        </li>
        <li class="nav-item">
            <a href="keputusanPljr.php" class="nav-link text-white">
                <i class="fas fa-calendar-alt me-2"></i>Keputusan Pelajar
            </a>
        </li>
    </ul>


    <div class="mt-3 text-center text-white">
        <small>&copy; 2024 e-RBT</small>
    </div>
</nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-0 flex-grow-1"> 
        <header class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A237E;"> 
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"> 
                        <li class="nav-item">
                            <a class="nav-link active text-white" aria-current="page" href="homepage.php">Laman Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="kelas.php">Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="pelajar.php">Pelajar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Log Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container-fluid mt-4"> 
        <div class="container mt-4">
    <h2>Penilaian</h2>

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="pilih_aktiviti" class="form-label">Pilih Aktiviti:</label>
            <select class="form-select" id="pilih_aktiviti" name="pilih_aktiviti">
                <option value="">Pilih Aktiviti</option>
                <option value="1">Buat Permainan Mudah</option> 
            </select>
        </div>

        <div class="col-md-12"> 
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title">Senarai Penyerahan Aktiviti</h5>
                </div>
                <div class="card-body">
                    <div id="submission-table">
                        <table class="table table-striped"> 
                            <thead>
                                <tr>
                                    <th>Nama Pelajar</th>
                                    <th>Aktiviti</th>
                                    <th>Tarikh Penyerahan</th>
                                    <th>Fail</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Ali</td>
                                    <td>Buat Permainan Mudah</td>
                                    <td>25 September 2024</td>
                                    <td><a href="download-submission.php?submission_id=1">game.sb3</a></td>
                                    <td>Belum Dinilai</td>
                                    <td>
                                        <a href="nilai-submission.php?submission_id=1" class="btn btn-primary btn-sm">Nilai</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siti Nurhaliza</td>
                                    <td>Buat Permainan Mudah</td>
                                    <td>28 September 2024</td>
                                    <td><a href="download-submission.php?submission_id=2">my_game.sb3</a></td>
                                    <td>Telah Dinilai</td>
                                    <td>
                                        <a href="nilai-submission.php?submission_id=2" class="btn btn-secondary btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="js/script.js"></script>

<script>
// JavaScript to handle activity selection and table population (placeholder for now)
document.getElementById('pilih_aktiviti').addEventListener('change', function() {
    const selectedActivityId = this.value;
    // Fetch submissions for the selected activity using AJAX or similar
    // Update the 'submission-table' div with the fetched data
});
</script>
</body>
</html>