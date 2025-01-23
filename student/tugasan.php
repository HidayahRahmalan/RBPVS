<?php
include 'connect.php';
$name = $_SESSION['name'];

// Count of each Kuiz
$sqlKuiz = "SELECT  COUNT(kuiz_id) AS total_kuiz
        FROM kuiz"; 

$result_kuiz = $conn->query($sqlKuiz);

$row_kuiz = $result_kuiz->fetch_assoc();

// Count of each Projek
$sqlTugasan = "SELECT  COUNT(tugasan_id) AS total_tugasan
        FROM tugasan"; 

$result_tugasan = $conn->query($sqlTugasan);

$row_tugasan = $result_tugasan->fetch_assoc();

// Count of each Tugasan
$sqlProjek = "SELECT  COUNT(projek_id) AS total_projek
        FROM projek"; 

$result_projek = $conn->query($sqlProjek);

$row_projek = $result_projek->fetch_assoc();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Modul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

    /* Scratch-inspired card styling */
    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.01);
    }

    .card-header {
        background-color: #4C97FF; /* Scratch blue */
        color: white;
        border-radius: 10px 10px 0 0;
    }

    /* List group styling */
    #skNavList .list-group-item {
        border-radius: 0.25rem;
        transition: background-color 0.2s;
    }

    #skNavList .list-group-item:hover {
        background-color: #f0f0f0; 
    }

    #skNavList .badge {
        background-color: #28a745; /* Green badge */
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
                <li class="breadcrumb-item active" aria-current="page">Tugasan</li>
            </ol>
        </nav>

    <h1 class="text-center mb-4">Tugasan</h1>
    <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                        <h3>Kuiz</h3>
                            
                        </div>
                        <div class="card-body">
                       
                            <p>Jumlah Kuiz : <?= $row_kuiz["total_kuiz"] ?></p>
                            <a href="kuiz.php" class="btn btn-primary">Lihat Kuiz</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                        <h3>Tugasan</h3>
                            
                        </div>
                        <div class="card-body">
                       
                            <p>Jumlah Tugasan : <?= $row_projek["total_projek"] ?> </p>
                            <a href="view_tugasan1.php" class="btn btn-primary">Lihat Tugasan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                        <h3>Projek</h3>
                            
                        </div>
                        <div class="card-body">
                       
                            <p>Jumlah Projek : <?= $row_tugasan["total_tugasan"] ?> </p>
                            <a href="view_tugasan.php" class="btn btn-primary">Lihat Projek</a>
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 
</script>
</html>