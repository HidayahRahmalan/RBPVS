<?php
include 'connect.php';
$name = $_SESSION['name'];

// Fetch all "kuiz" from the database
$sql_kuiz = "SELECT * FROM kuiz"; 
$result_kuiz = $conn->query($sql_kuiz);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kuiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}


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
        background-color: #4C97FF; 
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
                <li class="breadcrumb-item " aria-current="page"><a href="tugasan.php">Tugasan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kuiz</li>
            </ol>
        </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='tugasan.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Kuiz</h1> 
            </div>


            <div class="row" id="kuizList">
                <?php 
                if ($result_kuiz->num_rows > 0) {
                    while($row_kuiz = $result_kuiz->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-3">';
                        echo '<div class="card h-100">';
                        echo '<div class="card-header">' . $row_kuiz['nama_kuiz'] . '</div>'; 
                        echo '<div class="card-body">';
                        echo '<p>' . $row_kuiz['deskripsi_kuiz'] . '</p>'; 
                        echo "<a href='kandungan_kuiz.php?id=" . $row_kuiz["kuiz_id"] . "' class='btn btn-info btn-sm mr-2'>Lihat</a>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-md-12">';
                    echo '<p class="text-center">Tiada kuiz  yang dapat dijumpai.</p>';
                    echo '</div>';
                }
                ?>
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