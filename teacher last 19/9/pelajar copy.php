<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

$sql = "SELECT pelajar_id, nama_pelajar, email FROM pelajar"; 
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Pelajar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

        <?php include 'sidebar.php'; ?>



            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">

<center><h1>Senarai Pelajar </h1> </center><br>

<div class="card"> 
        <div class="card-body"> 

<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Pelajar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
        if ($result->num_rows > 0) {
            $i = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $i . "</td>"; 
                echo "<td>" . $row["nama_pelajar"] . "</td>";
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='3'>Tiada Pelajar dijumpai.</td></tr>";
        }} else {
            // Handle the query error
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        ?>
    </tbody>
</table>

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
    $('#myTable').DataTable();
    });




</script>
</html>