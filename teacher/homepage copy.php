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

<div class="container-fluid p-0 d-flex"> 

    <nav id="sidebar" class="bg-light">
        <ul class="list-unstyled components">
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-home mr-2"></i>
                    Laman Utama
                </a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="#">Overview</a>
                    </li>
                    <li>
                        <a href="#">Announcements</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-book mr-2"></i>
                    Kandungan
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-tasks mr-2"></i>
                    Projek
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-check-square mr-2"></i>
                    Penyerahan
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Log Keluar
                </a>
            </li>
        </ul>
    </nav>

    <div id="content"> 
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fas fa-bars"></i>
                    <span>Toggle Sidebar</span>
                </button>
            </div>
        </nav>

        <div class="container mt-4"> 
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Selamat Datang, Cikgu!</h2>
                            <p>Berikut adalah gambaran keseluruhan kelas anda:</p>
                            <ul>
                                <li>Bilangan Pelajar: 25</li>
                                <li>Projek Aktif: 3</li>
                                <li>Penyerahan Baru: 5</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Pengumuman</h2>
                            <p>Tiada pengumuman baru.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
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
    </div>

</div> 

<footer class="footer py-3 bg-dark text-light">
    <div class="container text-center">
        <p>&copy; 2024 Asas Pengaturcaraan</p>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</body>
</html>