<?php
include 'connect.php';
$name = $_SESSION['name'];

$sql = "SELECT sk_id, nama_sk, kod_sk, urutan_sk FROM standard_kandungan"; 
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

.card {
    border: none; /* Remove default border */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    border-radius: 10px; /* Rounded corners */
    transition: transform 0.2s; /* Add a hover effect */
}

.card:hover {
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.card-header {
    background-color: #4C97FF; /* Scratch-like bright blue */
    color: white;
    border-radius: 10px 10px 0 0; /* Rounded top corners */
}

.card-title {
    font-size: 1.5rem; /* Increase title size */
    font-weight: bold;
}

.card-text {
    font-size: 1.1rem; /* Slightly larger text */
}

.btn-info {
    background-color: #FFAB19; /* Scratch-like orange */
    border-color: #FFAB19;
    color: white;
}

.btn-info:hover {
    background-color: #e69515; /* Slightly darker orange on hover */
    border-color: #d38b12;
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
                <li class="breadcrumb-item active" aria-current="page">Kandungan Modul</li>
            </ol>
        </nav>

<center><h1>Kandungan Modul</h1> </center><br>



        <?php
if ($result) {
    if ($result->num_rows > 0) {
        // Use Bootstrap's grid system to arrange cards in rows and columns
        echo '<div class="row">'; 
        while($row = $result->fetch_assoc()) {
?>
            <div class="col-md-4 mb-3"> 
                <div class="card h-100"> <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $row["nama_sk"] ?></h5>
                        <p class="card-text">Kod: 6.<?= $row["kod_sk"] ?></p>
                        <a href='standard_pembelajaran.php?id=<?= $row["sk_id"] ?>' class='btn btn-info btn-sm mt-auto'>Lihat</a> 
                    </div>
                </div>
            </div>
<?php
        }
        echo '</div>'; // Close the row
    } else {
        echo "<p>Tiada standard kandungan dijumpai.</p>";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>


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
    $('#myTable').DataTable();
    });
</script>
</html>