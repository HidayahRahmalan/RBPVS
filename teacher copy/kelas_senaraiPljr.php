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
        <a href="kelas.php" class="btn btn-secondary">Kembali</a> 
    </div>
    <h2>Pelajar dalam Kelas: 4 Bestari</h2> 

    <div class="mb-3 text-end">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Tambah Pelajar</button>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
            <th>No.</th>
                <th>Nama Pelajar</th>
                <th>Kad Pengenalan Pelajar</th>
                <th>Alamat</th>
                <th>Tindakan</th> 
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>1</td>
                <td>Ahmad Ali</td>
                <td>030411012345</td>
                <td>No. 23, Jalan Bunga Raya
                Taman Melati
                75200 Melaka
                Melaka
                Malaysia</td>
                <td>
                    <a href="keputusan_markah_pelajar.php?pelajar_id=1" class="btn btn-primary btn-sm me-2">Lihat Keputusan</a>
                    <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editStudentModal1">Edit</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal1">Tukar KataLaluan</button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal1">Padam</button>
                </td>
            </tr>
            <tr>
            <td>2</td>
                <td>Siti Nurhaliza</td>
                <td>030411010328</td>
                <td>No. 15-1, Jalan Anggerik 3/2
                Taman Anggerik
                43300 Seri Kembangan
                Selangor
                Malaysia</td>
                <td>
                    <a href="keputusan_markah_pelajar.php?pelajar_id=2" class="btn btn-primary btn-sm me-2">Lihat Keputusan</a>
                    <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editStudentModal2">Edit</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal1">Tukar KataLaluan</button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal2">Padam</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Tambah Pelajar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="mb-3">
                            <label for="new_nama_pelajar" class="form-label">Nama Pelajar</label>
                            <input type="text" class="form-control" id="new_nama_pelajar" name="new_nama_pelajar" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_id_pelajar" class="form-label">Kad Pengenalan</label>
                            <input type="text" class="form-control" id="new_id_pelajar" name="new_id_pelajar" required>
                        </div>
                        <label for="kata_laluan" class="form-label">Kata Laluan</label>
                            <input type="text" class="form-control" id="kata_laluan" name="kata_laluan" value="Student@123" readonly>
                            <small class="form-text text-muted">Kata laluan default: Student@123</small>
                        <div class="mb-3">
                            <label for="new_email" class="form-label">Alamat</label>
                            <textarea rows="4" cols="50" name="comments"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="addStudentForm">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStudentModal1" tabindex="-1" aria-labelledby="editStudentModal1Label" aria-hidden="true">
        </div>

    <div class="modal fade" id="editStudentModal2" tabindex="-1" aria-labelledby="editStudentModal2Label" aria-hidden="true">
        </div>

    <div class="modal fade" id="deleteStudentModal1" tabindex="-1" aria-labelledby="deleteStudentModal1Label" aria-hidden="true">
        </div>

    <div class="modal fade" id="deleteStudentModal2" tabindex="-1" aria-labelledby="deleteStudentModal2Label" aria-hidden="true">
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>