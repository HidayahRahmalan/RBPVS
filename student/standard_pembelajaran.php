<?php
include 'connect.php';
$name = $_SESSION['name'];

if(isset($_GET['id'])) {
    $sk_id = $_GET['id'];
    $sql = "SELECT * FROM standard_kandungan WHERE sk_id = $sk_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sql_sp = "SELECT * FROM standard_pembelajaran WHERE sk_id = $sk_id ORDER BY URUTAN_SP"; 
        $result_sp = $conn->query($sql_sp);
    } else {
        echo "Standard kandungan tidak dijumpai.";
        exit; 
    }
} else {
    echo "ID standard kandungan tidak disediakan.";
    exit; 
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Standard Pembelajaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.11/pdfobject.min.js"></script>
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

<!-- Container for the page content -->
<div class="container-fluid">
    <div class="row">
       
        <?php include 'sidebar.php'; ?>



        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="modul.php">Kandungan Modul</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo '6.' . $row['kod_sk'] . ' ' . $row['nama_sk']; ?></li>
            </ol>
        </nav>

            <!-- Header section -->

            <div class="d-flex justify-content-between align-items-center mb-3">
            <a href='modul.php' class='btn btn-secondary btn-sm'>Kembali</a>
    <div> </div> <h1 class="text-center mx-auto"><?php echo '6.' . $row['kod_sk'] . ' ' . $row['nama_sk']; ?></h1> 

</div>
        

            <!-- Content section -->
            <div class="row">

            <div class="col-md-9">

                    <!-- Content area -->
                    <div id="content-area">
                        <?php if ($result_sp->num_rows > 0) : ?>
                            <?php $result_sp->data_seek(0); ?>
                            <?php while ($row_sp = $result_sp->fetch_assoc()) : ?>
                                <!-- Fetch Kandungan for this SP -->
                                <?php
                                $sp_id = $row_sp["sp_id"];
                                $sql_kandungan = "SELECT * FROM KANDUNGAN WHERE SP_ID = $sp_id ORDER BY URUTAN_KANDUNGAN";
                                $result_kandungan = $conn->query($sql_kandungan);
                                ?>
                                <div class="content-section" id="content-title<?= $row_sp["sp_id"] ?>" style="display: none;">

                                <div class="d-flex justify-content-between align-items-center mb-3"> 
                                    <h2><?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . " " . $row_sp["nama_sp"] ?></h2>
                                </div>

                                    <p><?= $row_sp['deskripsi_sp'] ?></p>

                                    <?php if ($result_kandungan->num_rows > 0) : ?>
                                        <div class="card">
    <div class="card-body ">
        <?php while ($row_kandungan = $result_kandungan->fetch_assoc()) : ?>
            <h4 class="mb-3"><?= $row_kandungan["nama_kandungan"] ?></h4>
            <p class="mb-4"><?= $row_kandungan["deskripsi_kandungan"] ?></p>
            <?php
            $path = $row_kandungan["kandungan_path"];
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!empty($path)) : ?>
                <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                    <img src="<?= $path ?>" width="100%" height="500px" class="mb-4">
                <?php elseif ($extension == 'docx') : ?>

                <?php else : ?>
                    <iframe src="<?= $path ?>" width="100%" height="500px" class="mb-4"></iframe>
                <?php endif; ?>
            <?php endif; ?>
        
        <?php endwhile; ?>
    </div>
</div>
                                        <?php else : ?>
                                            <p>Tiada kandungan dijumpai untuk SP ini.</p>
                                        <?php endif; ?>
                                                                        </div>
                                                                    <?php endwhile; ?>
                                                                <?php else : ?>
                                                                    <p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                <!-- right column for navigation -->                
                            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Standard Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="spNavList">
                            <?php $result_sp->data_seek(0); ?> 
                            <?php if ($result_sp->num_rows > 0) : ?>
                                <?php while ($row_sp = $result_sp->fetch_assoc()) : ?>
                                    <li class="list-group-item">
                                        <a href="#" data-sp-id="<?= $row_sp["sp_id"] ?>">
                                            <?= "6." . $row['kod_sk'] . "." . $row_sp["urutan_sp"] . "  " . $row_sp["nama_sp"] ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <p>Tiada standard pembelajaran dijumpai untuk SK ini.</p>
                            <?php endif; ?>
                        </ul>
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

$(document).ready(function() {
    // Initially show only the first content section
    $('.content-section').first().show();

    // Attach click handler to navigation links
    $('#spNavList a[data-sp-id]').click(function(e) {
        e.preventDefault();
        var spId = $(this).data('sp-id');
        showSpecificContent('content-title' + spId);
    });

    function showAllContent() {
        $('.content-section').show();
    }

    function showSpecificContent(contentId) {
        $('.content-section').hide();
        $('#' + contentId).show();
    }
});

</script>


</html>