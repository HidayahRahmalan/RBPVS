<?php
session_start();
include 'connect.php';
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
  <h1 class="display-4" style="font-size: 3rem;">Selamat Datang, Cikgu!</h1>
  <p class="lead">Let's inspire young minds through the magic of coding!</p>
</div>

<div class="row mb-3">
        <div class="col-md-6 offset-md-3">
            <div class="card bg-warning text-dark rounded-corners h-100 shadow">
                <div class="card-body d-flex flex-column align-items-center"> 
                    <i class="fas fa-chart-line mb-3 card-icon" style="font-size: 2.5rem;"></i>
                    <h5 class="card-title text-center">Lihat Kemajuan Pelajar</h5>
                    <p class="card-text text-center flex-grow-1">Pantau kemajuan dan pencapaian pelajar anda.</p>
                    <a href="#" class="btn btn-dark mt-auto">Lihat</a> 
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white rounded-corners h-100 shadow"> 
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="card-title">Jumlah Pelajar</h5>
                    <p class="card-text display-4 text-center">30</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-3">
            <div class="card rounded-corners h-100 shadow"> 
                <div class="card-body">
                    <h5 class="card-title">Progress Overview</h5>
                    <canvas id="progressChart"></canvas> 
                    <div class="mt-3 text-center"> 
                        <small class="text-muted">Data terakhir dikemas kini pada: 15 September 2023</small> 
                    </div>
                </div>
            </div>
        </div>
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
    var ctx = document.getElementById('progressChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Completed Projects', 'Average Score', 'Active Students'],
            datasets: [{
                label: 'Class Progress',
                data: [15, 85, 25], // Sample data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

   // Get the username from your backend or data source
var username = '<?php echo $name; ?>'; // Replace with actual username

// Display the username and personalized greeting in the jumbotron
var jumbotronHeading = document.querySelector('.jumbotron h1');
var currentHour = new Date().getHours();
var greeting = "";
if (currentHour < 12) {
    greeting = "Selamat Pagi,";
} else if (currentHour < 18) {
    greeting = "Selamat Petang,";
} else {
    greeting = "Selamat Malam,";
}
jumbotronHeading.textContent = `${greeting} Cikgu ${username}!`; 
</script>
</html>