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
            <a href="profilSaya.php" class="nav-link text-white" aria-current="page"> 

                <i class="fas fa-book me-2"></i> Profil Saya
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active text-white">
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
            <a href="#" class="nav-link text-white">
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
                            <a class="nav-link text-white" href="#">Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Pelajar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container-fluid mt-4"> 
        <div class="card shadow mb-4">
  <div class="card-header">
    <h5 class="card-title">Pendaftaran Pelajar Baru</h5>
  </div>
  <div class="card-body">
    <form>
      <div class="mb-3">
        <label for="nama_pelajar" class="form-label">Nama Pelajar</label>
        <input type="text" class="form-control" id="nama_pelajar" name="nama_pelajar" required>
      </div>

      <div class="mb-3">
        <label for="kad_pengenalan"   
 class="form-label">Kad Pengenalan</label>
        <input type="text" class="form-control" id="kad_pengenalan" name="kad_pengenalan" required>
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" required>
      </div>
      <div class="mb-3">
        <label   
 for="kata_laluan" class="form-label">Kata Laluan</label>
        <input type="text" class="form-control" id="kata_laluan" name="kata_laluan" value="Student@123" readonly>
        <small class="form-text text-muted">Kata laluan default: Student@123</small>
      </div>
      <div class="mb-3">
        <label for="kelas_id" class="form-label">Kelas</label>
        <select class="form-select" id="kelas_id" name="kelas_id" required>
          <option value="">Pilih   
 Kelas</option>
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
  </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>