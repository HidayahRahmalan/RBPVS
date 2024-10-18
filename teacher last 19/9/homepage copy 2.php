<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Asas Pengaturcaraan</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="scratch-cat-logo.png" alt="Scratch Cat Logo" height="30"> 
            Asas Pengaturcaraan 
        </a>
        <div class="ml-auto"> 
            <span class="navbar-text mr-3">
                Selamat Datang, Cikgu!
            </span>
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Log Keluar
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4"> 
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100 bg-white shadow-sm"> 
                <div class="card-body d-flex flex-column align-items-center"> 
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Bilangan Pelajar</h5>
                    <p class="card-text display-4">25</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 bg-white shadow-sm">
                <div class="card-body d-flex flex-column align-items-center">
                    <i class="fas fa-tasks fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Projek Aktif</h5>
                    <p class="card-text display-4">3</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 bg-white shadow-sm">
                <div class="card-body d-flex flex-column align-items-center">
                    <i class="fas fa-check-square fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Penyerahan Baru</h5>
                    <p class="card-text display-4">5</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Pengumuman</h2>
                    <p>Tiada pengumuman baru.</p> 
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Projek Akan Datang</h2>
                    <ul>
                        <li>Projek 1: Animasi Haiwan Kesayangan (Tarikh Akhir: 20 Oktober 2024)</li>
                        <li>Projek 2: Permainan Matematik Interaktif (Tarikh Akhir: 15 November 2024)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> 

<footer class="footer py-3 bg-dark text-light mt-auto"> 
    <div class="container text-center">
        <p>&copy; 2024 Asas Pengaturcaraan</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>