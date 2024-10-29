<?php
session_start();
$name = $_SESSION['name'];
?>


<!DOCTYPE html>
<html>
<head>
    <title>Personalized Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

.card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s; /* Add hover effect */
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header {
            background-color: #f0f0f0; /* Light gray header */
            border-bottom: none;
        }

        .card-icon {
            font-size: 2rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .jumbotron {
            background-image: url('../img/scratch background.png'); /* Replace with your image path */
            background-size: cover;
            color: black; /* Text color on the jumbotron */
        }

#progressChart {
  background-color: #fff8eb; /* add a gradient effect */
  border-radius: 10px; /* add a rounded corner effect */
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
                <li class="breadcrumb-item active" aria-current="page">Laman Utama</li>
            </ol>
        </nav>

<div class="jumbotron bg-light rounded-corners text-center"> 
  <h1 class="display-4" style="font-size: 3rem;">Selamat Datang, Murid!</h1>
  <p class="lead">Platform Digital Topik 6 Reka Bentuk Pengaturcaraan Visual Scratch</p>
</div>

</main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

var username = '<?php echo $name; ?>'; // Replace with actual username

// Display the username and personalized greeting in the jumbotron
var jumbotronHeading = document.querySelector('.jumbotron h2');
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
</html>