<nav class="navbar navbar-expand-md navbar-dark scratch-header">
        <a class="navbar-brand" href="homepage.php">
            <img src="../img/scratch1.png" alt="Scratch Cat Logo" height="30"> 
            Asas Pengaturcaraan 
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text mr-3">
                Selamat Datang, Cikgu! <br>
                 </span>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0);" class="btn btn-outline-danger" onclick="confirmLogout()">
                    <i class="fas fa-sign-out-alt mr-2"></i> Log Keluar
                </a>
            </li>
        </ul>
    </nav>

    <script>
        function confirmLogout() {
  if (confirm("Anda pasti ingin keluar?")) {
    window.location.href = "logout.php"; 
  }
}
        </script>