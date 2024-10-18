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

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3"> 
        <h2>Asas Pengaturcaraan</h2>
        <a href="topik.php" class="btn btn-secondary">Kembali</a> 
    </div>

    <div class="row">
        <div class="col-md-8"> 
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div id="content-area">
                        <div class="d-flex justify-content-between align-items-center mb-3"> 
                            <h3 id="content-title1">1. Pengenalan kepada Pengaturcaraan</h3> 
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </div>

                        <p>Pengaturcaraan adalah proses memberikan arahan kepada komputer untuk melaksanakan tugas tertentu. Ia seperti menulis resipi untuk komputer! Kita akan belajar bagaimana komputer "berfikir" dan menyelesaikan masalah menggunakan kod.</p>

                        <div class="d-flex justify-content-between align-items-center mb-3"> 
                            <h3 id="content-title2">2. Pembangunan Kod Arahan</h3> 
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </div>

                        <p>Dalam bahagian ini, kita akan belajar cara menulis kod arahan mudah menggunakan bahasa pengaturcaraan visual seperti Scratch. Kita akan belajar bagaimana menggunakan blok-blok kod untuk membuat animasi, permainan, dan cerita interaktif.</p>

                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/9ZefQozR7w4?si=C2GfZk6OwTHRb3hF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3"> 
                            <h3 id="content-title3">3. Aktiviti: Cipta Cerita Interaktif</h3> 
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </div>

                        <p>Mari kita uji kemahiran pengaturcaraan anda! Cipta sebuah cerita interaktif menggunakan Scratch. Anda boleh menggunakan watak-watak, latar belakang, dan bunyi yang disediakan.</p>

                        <p><strong>Tarikh Akhir Penyerahan:</strong> 15 Oktober 2024</p> 

                        <form>
                            <div class="mb-3">
                                <label for="file_upload" class="form-label">Muat Naik Fail Projek Anda:</label>
                                <input type="file" class="form-control" id="file_upload" name="file_upload">
                            </div>
                            <button type="submit" class="btn btn-primary">Hantar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4"> 
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title">Navigasi Kandungan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#content-title1">1. Pengenalan kepada Pengaturcaraan</a>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#content-title2">2. Pembangunan Kod Arahan</a> 
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#content-title3">3. Aktiviti: Cipta Cerita Interaktif</a> 
                            <a href="#" class="btn btn-warning btn-sm">Edit</a> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>