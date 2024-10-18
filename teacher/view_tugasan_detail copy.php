<?php
session_start();
include 'connect.php';

// Fetch the Tugasan details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $tugasan_id = intval($_GET['id']);
    $sql_tugasan = "SELECT * FROM tugasan WHERE tugasan_id = $tugasan_id";
    $result_tugasan = $conn->query($sql_tugasan);

    if ($result_tugasan->num_rows > 0) {
        $row_tugasan = $result_tugasan->fetch_assoc();

        // Fetch the SK details associated with this Tugasan
        $sk_id = $row_tugasan["sk_id"];
        $sql_sk = "SELECT * FROM standard_kandungan WHERE sk_id = $sk_id";
        $result_sk = $conn->query($sql_sk);
        $row_sk = $result_sk->fetch_assoc(); 
    } else {
        echo "Tugasan tidak dijumpai.";
        exit;
    }
} else {
    echo "ID tugasan tidak disediakan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Tugasan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href='view_tugasan.php?id=<?= $sk_id ?>' class='btn btn-secondary btn-sm'>Kembali</a>
                <div></div> 
                <h1 class="text-center mx-auto">Detail Tugasan</h1> 
            </div>

            <div class="card">
                <div class="card-body">
                <p><strong>Standard Kandungan:</strong> 6.<?= $row_sk["kod_sk"] ?> <?= $row_sk["nama_sk"] ?></p>
                    <h2><?= $row_tugasan["nama_tugasan"] ?></h2>
                    <p><?= $row_tugasan["deskripsi_tugasan"] ?></p>
                    <?php if (!empty($row_tugasan["lampiran_path"])): ?>
                        <a href="<?= $row_tugasan["lampiran_path"] ?>" target="_blank" class="btn btn-info btn-sm">Lihat Lampiran</a>
                    <?php endif; ?>
                    <p><strong>Jenis Tugasan:</strong> <?= $row_tugasan["jenis_tugasan"] ?></p>
                    <p><strong>Tarikh Akhir:</strong> <?= $row_tugasan["tarikh_due"] ?></p>


                    <h3 class="mt-4">Senarai Pelajar</h3>

                    <?php
                    // Fetch students who have submitted or are expected to submit this assignment
                    // You'll need to adjust this query based on your database schema and how you track submissions
                    $sql_pelajar = "SELECT p.* 
                                    FROM pelajar p "; // Assuming you're filtering by grade level for now
                    $result_pelajar = $conn->query($sql_pelajar);

                    if ($result_pelajar->num_rows > 0): 
                    ?>
                        <ul>
                            <?php while ($row_pelajar = $result_pelajar->fetch_assoc()): ?>
                                <li><?= $row_pelajar["nama_pelajar"] ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>Tiada pelajar dijumpai untuk tugasan ini.</p>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>