<?php
session_start();
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

<center><h1>Kandungan Modul </h1> </center><br>

<button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addSKModal">Tambah SK</button>
<div class="card"> 
        <div class="card-body"> 

<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Nama Standard Kandungan</th>
            <th>Kod Standard Kandungan</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nama_sk"] . "</td>";
                echo "<td>" . $row["kod_sk"] . "</td>";
                echo "<td>";
                echo "<a href='standard_pembelajaran.php?id=" . $row["sk_id"] . "' class='btn btn-info btn-sm mr-2'>Lihat</a>";
                echo "<button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editSKModal'
      data-sk-id='" . $row["sk_id"] . "' 
      data-nama-sk='" . $row["nama_sk"] . "'
      data-urutan-sk='" . $row["urutan_sk"] . "'>Edit</button>"; 
      echo "<button class='btn btn-danger btn-sm' onclick='confirmDeleteSK(" . $row["sk_id"] . ")'>Hapus SK</button>"; 
                echo "</td>";
                echo "</tr>";
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

    <div class="modal fade" id="addSKModal" tabindex="-1" role="dialog" aria-labelledby="addSKModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSKModalLabel">Tambah Standard Kandungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addSKForm">
          <div class="form-group">
            <label for="namaSK">Nama SK:</label>
            <input type="text" class="form-control" id="namaSK" name="namaSK" required>
          </div>
          <div class="form-group">
            <label for="urutanSK">Urutan SK:</label>
            <input type="number" class="form-control" id="urutanSK" name="urutanSK" required>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="addSKForm">Tambah</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editSKModal" tabindex="-1" role="dialog" aria-labelledby="editSKModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSKModalLabel">Edit Standard Kandungan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 

      </div>
      <div class="modal-body">
        <form id="editSKForm">
          <div class="form-group">
            <label for="editNamaSK">Nama SK:</label>
            <input type="text" class="form-control" id="editNamaSK" name="editNamaSK" required>
          </div>
          <div class="form-group">
            <label for="editUrutanSK">Urutan SK:</label>
            <input type="number" class="form-control" id="editUrutanSK" name="editUrutanSK" required>
          </div>
          <input type="hidden" id="editSkID" name="editSkID"> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="editSKForm">Simpan Perubahan</button>
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

    document.getElementById('addSKForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('add_sk.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); 
    // Refresh the page after a short delay (e.g., 1 second)
    setTimeout(() => {
        location.reload(); 
    }, 100);
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors gracefully (e.g., display an error message to the user)
    });
});

// Handle 'Edit SK' button click to populate the modal
$('#editSKModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var sk_id = button.data('sk-id');
  var nama_sk = button.data('nama-sk');
  var urutan_sk = button.data('urutan-sk');

  var modal = $(this);
  modal.find('.modal-body #editSkID').val(sk_id);
  modal.find('.modal-body #editNamaSK').val(nama_sk);
  modal.find('.modal-body #editUrutanSK').val(urutan_sk);
});

// Handle 'editSKForm' submission using Fetch API
document.getElementById('editSKForm').addEventListener('submit', function(event) {
  event.preventDefault();

  if (!confirm("Anda yakin ingin menyimpan perubahan?")) {
    return; 
  }

  const formData = new FormData(this);

  fetch('edit_sk.php', { 
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    // Refresh the page after a short delay (e.g., 1 second)
    setTimeout(() => {
        location.reload(); 
    }, 100);
  })
  .catch(error => {
    console.error('Error:', error);
    // Handle errors gracefully
  });
});


const deleteButtons = document.querySelectorAll('.btn-danger[data-sk-id]'); 

function confirmDeleteSK(sk_id) {
    if (confirm("Anda yakin ingin menghapus Standard Kandungan ini?")) {
        fetch('delete_sk.php', { // Adjust the URL to your delete_sk.php script
            method: 'POST', // You might need to change this to 'DELETE' if your server setup requires it
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `sk_id=${sk_id}` 
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Reload the page after deletion
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors gracefully (e.g., display an error message to the user)
        });
    }
}
</script>
</html>