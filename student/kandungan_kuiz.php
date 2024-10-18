<?php
include 'connect.php';
$name = $_SESSION['name'];

// Fetch the Kuiz details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $kuiz_id = intval($_GET['id']);
    $sql_kuiz = "SELECT * FROM kuiz WHERE kuiz_id = $kuiz_id";
    $result_kuiz = $conn->query($sql_kuiz);

    if ($result_kuiz->num_rows > 0) {
        $row_kuiz = $result_kuiz->fetch_assoc();


    } else {
        echo "Kuiz tidak dijumpai.";
        exit;
    }
} else {
    echo "ID kuiz tidak disediakan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail kuiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
    main {
        background-color: #e0f2ff; 
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
                <li class="breadcrumb-item " aria-current="page"><a href="kuiz.php">Kuiz</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row_kuiz["nama_kuiz"] ?></li>
            </ol>
        </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='kuiz.php' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto"><?= $row_kuiz["nama_kuiz"] ?></h1> 
            </div>


            <div class="card">
                <div class="card-body">

                <h3><strong><?= $row_kuiz["nama_kuiz"] ?></strong></h3><br>

                <p><?= $row_kuiz["deskripsi_kuiz"] ?></p>

<hr class ="bg-dark">

                                <!-- Fetch Kandungan for this kuiz -->
                                <?php
                                $kuiz_id = $row_kuiz["kuiz_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN_KUIZ WHERE kuiz_id = $kuiz_id ORDER BY URUTAN_KANDUNGAN";
                                $result_kandungan = $conn->query($sql_kandungan);
                                ?>

                                    <?php if ($result_kandungan->num_rows > 0) : ?>

        <?php while ($row_kandungan = $result_kandungan->fetch_assoc()) : ?>
            <p class="mb-4"><?= $row_kandungan["deskripsi_kandungan"] ?></p>

            <a href="<?= $row_kandungan["pautan_url"]?>"><?= $row_kandungan["pautan_url"]?></a>

            <!-- If using button for the url -->
 <!--             if (!empty($row_kandungan["pautan_url"])): ?> 
    <div class="mt-3">
        <a href=" $row_kandungan["pautan_url"]" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-link"></i> Pautan URL
        </a>
    </div>
 endif; -->

            <?php
            $path = $row_kandungan["kandungan_path"];
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!empty($path)) : ?>
                <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                    <img src="<?= $path ?>" width="100%" height="500px" class="mb-4">
                <?php elseif ($extension == 'docx') : ?>
                    <!-- You can add code to handle docx files here -->
                <?php elseif ($extension == 'mp4') : ?>
                    <video width="100%" height="500px" controls>
                        <source src="<?= $path ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else : ?>
                    <iframe src="<?= $path ?>" width="100%" height="500px" class="mb-4"></iframe>
                <?php endif; ?>
            <?php endif; ?>
                    <?php endwhile; ?>
            <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

</script>

</html>

