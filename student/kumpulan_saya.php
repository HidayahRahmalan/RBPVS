<?php
include 'connect.php';
$name = $_SESSION['name'];
$user_id = $_SESSION['id'];


$sql_kumpulan = "SELECT k.kumpulan_id, k.nama_kumpulan
                 FROM ahli_kumpulan ak 
                 JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                 WHERE ak.pelajar_id = $user_id";
$result_kumpulan = $conn->query($sql_kumpulan);

$row_kumpulan = $result_kumpulan->fetch_assoc();
if ($row_kumpulan) { // Check if a row was returned
    $nama_kumpulan = $row_kumpulan['nama_kumpulan']; // Corrected line
    //use $row_kumpulan['nama_kumpulan'] to get the name of the group.
} else {
    // Handle the case where no group was found for the user.
    $nama_kumpulan = null; // or some default value.
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kumpulan Saya</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="css/style.css">

    <style>
main {
    background-color: #e0f2ff; /* Light blue background */
}

#myTable {
    border-collapse: collapse; 
    width: 100%;
}

#myTable th {
    background-color: #4C97FF; 
    color: white;
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
                <li class="breadcrumb-item active" aria-current="page">Kumpulan Saya</li>
            </ol>
        </nav>

        <center><h1>Kumpulan Saya </h1> </center><br>

        <center><h3>Kumpulan : <?php echo $nama_kumpulan?> </h3> </center>



<div class="card"> 
        <div class="card-body"> 

<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Murid</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $user_id = $_SESSION['id'];

        // Retrieve the kumpulan_id of the current user
        $sql_kumpulan = "SELECT k.kumpulan_id 
                         FROM ahli_kumpulan ak 
                         JOIN kumpulan k ON ak.kumpulan_id = k.kumpulan_id 
                         WHERE ak.pelajar_id = $user_id";
        $result_kumpulan = $conn->query($sql_kumpulan);

        if ($result_kumpulan->num_rows > 0) {
            $kumpulan_id = $result_kumpulan->fetch_assoc()['kumpulan_id'];

            // Retrieve all the members of the kumpulan
            $sql_members = "SELECT p.pelajar_id, p.nama_pelajar 
                           FROM pelajar p 
                           JOIN ahli_kumpulan ak ON p.pelajar_id = ak.pelajar_id 
                           WHERE ak.kumpulan_id = $kumpulan_id";
            $result_members = $conn->query($sql_members);

            if ($result_members) {
                if ($result_members->num_rows > 0) {
                    $i = 1;
                    while($row_members = $result_members->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row_members["nama_pelajar"] . "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='2'>Tiada Pelajar dijumpai.</td></tr>";
                }
            } else {
                // Handle the query error
                echo "Error: " . $sql_members . "<br>" . $conn->error;
            }
        } else {
            echo "<tr><td colspan='2'>Anda tidak mempunyai kumpulan.</td></tr>";
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

</script>
</html>