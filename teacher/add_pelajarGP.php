<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch all groups (kumpulan)
$sql_kumpulan = "SELECT * FROM kumpulan";
$result_kumpulan = $conn->query($sql_kumpulan);

// Fetch all students (pelajar)
$sql_pelajar = "SELECT * 
FROM pelajar
WHERE pelajar_id NOT IN (SELECT pelajar_id FROM ahli_kumpulan)";
$result_pelajar = $conn->query($sql_pelajar);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kumpulan</title>
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
            <li class="breadcrumb-item" aria-current="page"><a href="kumpulan.php">Senarai Kumpulan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah/Sunting Ahli Kumpulan</li>
            </ol>
        </nav>

        <a href='kumpulan.php' class='btn btn-secondary btn-sm'>Kembali</a>
            <h1 class="text-center mb-4">Tambah/Sunting Ahli Kumpulan</h1>


            <div class="card"> 
        <div class="card-body"> 

            <form id="assignStudentsForm">
                <div class="form-group">
                    <label for="selectGroup">Pilih Kumpulan:</label>
                    <select class="form-control" id="selectGroup" name="selectGroup" required>
                        <?php
                        // Populate the dropdown with existing groups
                        $result_kumpulan->data_seek(0); // Reset the result pointer
                        while ($row_kumpulan = $result_kumpulan->fetch_assoc()) {
                            echo "<option value='" . $row_kumpulan["kumpulan_id"] . "'>" . $row_kumpulan["nama_kumpulan"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="availableStudents">Senarai Pelajar yang belum  ditugaskan ke Kumpulan:</label>
                    <select class="form-control" id="availableStudents" name="availableStudents[]" multiple size="10">
                        <?php
                        // Populate the list with all students that not assigned yet
                        while ($row_pelajar = $result_pelajar->fetch_assoc()) {
                            echo "<option value='" . $row_pelajar['pelajar_id'] . "'>" . $row_pelajar['nama_pelajar'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-success" id="assignButton">Tambah <i class="fas fa-arrow-down"></i></button>
                    <button type="button" class="btn btn-danger" id="removeButton"><i class="fas fa-arrow-up"></i> Hapus</button>
                    <button type="submit" class="btn btn-primary" id="saveAssignmentsButton">Kemaskini Ahli Kumpulan</button>
                </div>
                <div class="form-group">
                    <label for="assignedStudents">Senarai Pelajar yang berada di dalam Kumpulan:</label>
                    <select class="form-control" id="assignedStudents" name="assignedStudents[]" multiple size="10">
                    </select>
                </div>
            </form>
        </main>

                    </div>
                    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

<script>
// Update assigned students list when group is selected
$('#selectGroup').change(function() {
    var groupId = $(this).val();
    updateAssignedStudents(groupId);
    clearAssignedStudents(); // Add this line to clear the assigned students list
});

// Function to update the assigned students list based on selected group
function updateAssignedStudents(groupId) {
    jQuery.ajax({
        type: 'GET',
        url: 'get_ahli_kumpulan.php', 
        data: { kumpulan_id: groupId },
        success: function(response) {
            $('#assignedStudents').html(response); 
            // Remove assigned students from available students list
            $('#availableStudents option').each(function() {
                var studentId = $(this).val();
                if ($('#assignedStudents option[value="' + studentId + '"]').length > 0) {
                    $(this).remove();
                }
            });
        },
        error: function(error) {
            console.error('Error fetching group members:', error);
            // Handle errors gracefully
        }
    });
}

$(document).ready(function() {
    var initialGroupId = $('#selectGroup').val();
    updateAssignedStudents(initialGroupId);
});

// Function to clear the assigned students list
function clearAssignedStudents() {
    $('#assignedStudents').empty();
    $('#availableStudents option').each(function() {
        var studentId = $(this).val();
        if ($('#assignedStudents option[value="' + studentId + '"]').length > 0) {
            $(this).remove();
        }
    });
}

// Handle assign/remove button clicks
$('#assignButton').click(function() {
    $('#availableStudents option:selected').appendTo('#assignedStudents');
});

$('#removeButton').click(function() {
    $('#assignedStudents option:selected').appendTo('#availableStudents');
});

// Handle save button click
$('#assignStudentsForm').submit(function(event) {
    event.preventDefault();
    var groupId = $('#selectGroup').val();
    var assignedStudentIds = $('#assignedStudents option').map(function() { return this.value; }).get();

    jQuery.ajax({
        type: 'POST',
        url: 'update_ahli_kumpulan.php', 
        data: { 
            kumpulan_id: groupId,
            pelajar_ids: assignedStudentIds
        },
        success: function(response) {
            alert(response);
            setTimeout(() => {
        location.reload(); 
    }, 100);
        },
        error: function(error) {
            console.error('Error updating group members:', error);
            // Handle errors gracefully
        }
    });
});
</script>
</body>
</html>