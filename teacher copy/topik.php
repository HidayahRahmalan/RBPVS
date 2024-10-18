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
            <a href="#" class="nav-link text-white">
                <i class="fas fa-bullhorn me-2"></i> Topik
            </a>
        </li>
        <li class="nav-item">
            <a href="penilaian.php" class="nav-link text-white">
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
                            <a class="nav-link active text-white" aria-current="page" href="#">Laman Utama</a>
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

        <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Topik</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTopicModal">Tambah Topik Baru</button>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 rounded"> 
                
                <div class="card-body">
                    <h4 class="card-title">Asas Pengaturcaraan</h4>
                    <p class="card-text">Memperkenalkan pelajar kepada dunia pengaturcaraan dan logik komputer.</p>
                   
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="kandungan.php" class="btn btn-primary">Lihat Kandungan</a> 
                        <a href="#" class="btn btn-outline-warning">Edit</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>