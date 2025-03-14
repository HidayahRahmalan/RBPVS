<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

$sql = "SELECT rubrik_id, nama_rubrik, deskripsi_rubrik, markah_min, markah_max from rubrik";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Rubrik</title>
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
                <li class="breadcrumb-item active" aria-current="page">Rubrik</li>
            </ol>
        </nav>

<center><h1>Rubrik </h1> </center><br>

<button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addRubrikModal">
    Tambah Rubrik
</button>

<div class="card"> 
        <div class="card-body"> 
            

<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Rubrik</th>
            <th>Aras Pencapaian</th>
            <th>Markah Minimum</th>
            <th>Markah Maksimum</th>
            <th>Tindakan</th>
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
                echo "<td>" . $row["nama_rubrik"] . "</td>";
                echo "<td>" . $row["deskripsi_rubrik"] . "</td>";
                echo "<td>" .$row["markah_min"]. "</td>";
                echo "<td>" .$row["markah_max"]. "</td>";
                echo "<td>";
                echo "<button type='button' class='btn btn-primary btn-sm mr-2 edit-rubrik-btn' data-toggle='modal' data-target='#editRubrikModal' 
                        data-rubrik-id='" . $row["rubrik_id"] . "' 
                        data-nama-rubrik='" . $row["nama_rubrik"] . "'
                        data-deskripsi-rubrik='" . $row["deskripsi_rubrik"] . "'
                        data-markah-min='" . $row["markah_min"] . "'
                        data-markah-max='" . $row["markah_max"] . "'>
                        Edit
                    </button>";
                echo "<button type='button' class='btn btn-danger btn-sm delete-rubrik-btn' data-rubrik-id='" . $row["rubrik_id"] . "'>
                        Delete
                    </button>";
                echo "</td>";
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='3'>Tiada standard kandungan dijumpai.</td></tr>";
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

    <div class="modal fade" id="addRubrikModal" tabindex="-1" role="dialog" aria-labelledby="addRubrikModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRubrikModalLabel">Rubrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRubrikForm">
                    <div class="form-group">
                        <label for="namaRubrik">Nama Rubrik:</label>
                        <input type="text" class="form-control" id="namaRubrik" name="nama_rubrik" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsiRubrik">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsiRubrik" name="deskripsi_rubrik" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="markahMin">Markah Minimum:</label>
                        <input type="number" class="form-control" id="markahMin" name="markahMin" required>
                    </div>
                    <div class="form-group">
                        <label for="markahMax">Markah Maksimum:</label>
                        <input type="number" class="form-control" id="markahMax" name="markahMax" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="addRubrikForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editRubrikModal" tabindex="-1" role="dialog" aria-labelledby="editRubrikModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRubrikModalLabel">Edit Rubrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRubrikForm">
                    <input type="hidden" id="editRubrikId" name="rubrik_id">
                    <div class="form-group">
                        <label for="editNamaRubrik">Nama Rubrik:</label>
                        <input type="text" class="form-control" id="editNamaRubrik" name="nama_rubrik" required>
                    </div>
                    <div class="form-group">
                        <label for="editDeskripsiRubrik">Deskripsi:</label>
                        <textarea class="form-control" id="editDeskripsiRubrik" name="deskripsi_rubrik" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editMarkahMin">Markah Minimum:</label>
                        <input type="number" class="form-control" id="editMarkahMin" name="markahMin" required>
                    </div>
                    <div class="form-group">
                        <label for="editMarkahMax">Markah Maksimum:</label>
                        <input type="number" class="form-control" id="editMarkahMax" name="markahMax" required>
                    </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="editRubrikForm" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
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

    $('#addRubrikForm').submit(function(event) {
    event.preventDefault(); 

    if (!confirm("Anda yakin ingin menambah Markah Rubrik ini?")) {
        return; 
    }

    const formData = new FormData(this);


    fetch('add_rubrik.php', { 
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        alert(data.message); 
        $('#addRubrikModal').modal('hide'); 
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while adding the rubric."); 
    });
});

// Handle Edit Rubrik button click and populate modal
$('.edit-rubrik-btn').click(function() {
    $('#editRubrikId').val($(this).data('rubrik-id'));
    $('#editNamaRubrik').val($(this).data('nama-rubrik'));
    $('#editDeskripsiRubrik').val($(this).data('deskripsi-rubrik'));
    $('#editMarkahMin').val($(this).data('markah-min'));
    $('#editMarkahMax').val($(this).data('markah-max'));
});

// Handle Edit Rubrik form submission
$('#editRubrikForm').submit(function(event) {

    if (!confirm("Anda yakin ingin menyimpan perubahan Markah Rubrik ini?")) {
        return; 
    }

    event.preventDefault(); 
    const formData = new FormData(this);

    fetch('edit_rubrik.php', { 
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        alert(data.message); 
        $('#editRubrikModal').modal('hide');
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terdapat masalah semasa mengedit Rubrik.");
    });
});

// Handle Delete Rubrik button click
$('.delete-rubrik-btn').click(function() {

    const rubrikId = $(this).data('rubrik-id');

    if (confirm("Adakah anda ingin menghapus rubrik ini?")) {
        fetch(`delete_rubrik.php?rubrik_id=${rubrikId}`) 
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload(); 
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while deleting the rubric."); 
            });
    }
});


</script>
</html>