<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch all SKs along with the count of their associated Tugasan
$sql = "SELECT sk.*, COUNT(t.tugasan_id) AS total_tugasan
        FROM standard_kandungan sk
        LEFT JOIN tugasan t ON sk.sk_id = t.sk_id
        GROUP BY sk.sk_id
        ORDER BY sk.urutan_sk"; 

$result = $conn->query($sql);
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

                <h1 class="text-center mb-4">Tugasan</h1> <div class="row">


                    <div class="col-md-12">
                        <div class="card shadow"> 
                            <div class="card-header ">
                                <h5 class="card-title">SENARAI TUGASAN</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush" id="skNavList">
                                <a href="kuiz.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>Kuiz</div>
                                    <span class="badge badge-primary badge-pill">10 Tugasan</span>
                                    </a>
                                    <a href="view_tugasan.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>projek</div>
                                    <span class="badge badge-primary badge-pill">10 Tugasan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> 




                    <div class="col-md-12">
                        <div class="card shadow"> 
                            <div class="card-header">
                                <h5 class="card-title">Standard Kandungan</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush" id="skNavList">
                                    <?php if ($result->num_rows > 0) : ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <a href="view_tugasan.php?id=<?= $row["sk_id"] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1"><?= $row["nama_sk"] ?></h6>
                                                    <small class="text-muted">Kod: 6.<?= $row["kod_sk"] ?></small>
                                                </div>
                                                <span class="badge badge-primary badge-pill"><?= $row["total_tugasan"] ?> Tugasan</span>
                                            </a>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <p class="text-center">Tiada standard kandungan dijumpai.</p>
                                    <?php endif; ?>
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