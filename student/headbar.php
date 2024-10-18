<nav class="navbar navbar-expand-md navbar-dark scratch-header">
        <a class="navbar-brand" href="homepage.php">
            <img src="../img/scratch1.png" alt="Scratch Cat Logo" height="30"> 
            Asas Pengaturcaraan 
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class=" greet navbar-text mr-3">
                Selamat Datang, Pelajar! <br>
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

   // Get the username from your backend or data source
   var username = '<?php echo $name; ?>'; // Replace with actual username

// Display the username and personalized greeting in the jumbotron
var jumbotronHeading = document.querySelector('.greet');
var currentHour = new Date().getHours();
var greeting = "";
if (currentHour < 12) {
    greeting = "Selamat Pagi,";
} else if (currentHour < 18) {
    greeting = "Selamat Petang,";
} else {
    greeting = "Selamat Malam,";
}
jumbotronHeading.textContent = `${greeting} Murid ${username}!`; 
        </script>