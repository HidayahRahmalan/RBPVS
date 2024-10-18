<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch individual student submissions
$sql_individu = "SELECT p.nama_pelajar AS nama, py.penyerahan_id, py.rubrik_id, r.markah, 'individu' AS type 
FROM pelajar p
LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
WHERE py.tugasan_id = 1"; // Adjust for your `tugasan_id`

// Fetch group submissions
$sql_group = "SELECT g.nama_kumpulan AS nama, py.penyerahan_id, py.rubrik_id, r.markah, 'kumpulan' AS type
FROM kumpulan g
LEFT JOIN penyerahan py ON g.kumpulan_id = py.kumpulan_id
LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
WHERE py.tugasan_id = 1"; // Adjust for your `tugasan_id`

$result_individu = $conn->query($sql_individu);
$result_group = $conn->query($sql_group);
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
    </style>
</head>
<body>

<?php include 'headbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-4">
            <h1 class="text-center">Keputusan Tugasan</h1>

            <!-- Display both individual and group tables here -->
            <div class="mt-4">
                <h3>Senarai Individu</h3>
                <table id="individuTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pelajar</th>
                            <th>Status</th>
                            <th>Markah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_individu->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td><?= ($row['penyerahan_id']) ? ($row['rubrik_id'] ? 'Graded' : 'Submitted, Not Graded') : 'Not Submitted' ?></td>
                                <td><?= ($row['markah']) ? $row['markah'] : '-' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h3>Senarai Kumpulan</h3>
                <table id="kumpulanTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Kumpulan</th>
                            <th>Status</th>
                            <th>Markah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_group->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td><?= ($row['penyerahan_id']) ? ($row['rubrik_id'] ? 'Graded' : 'Submitted, Not Graded') : 'Not Submitted' ?></td>
                                <td><?= ($row['markah']) ? $row['markah'] : '-' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Export Buttons -->
            <button id="exportExcelBtn" class="btn btn-success mt-3">Export to Excel</button>
            <button id="exportPdfBtn" class="btn btn-danger mt-3">Export to PDF</button>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Include jsPDF and AutoTable for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<!-- Include SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTables
    $('#individuTable').DataTable();
    $('#kumpulanTable').DataTable();
  });

  // Export tables to Excel
  $('#exportExcelBtn').click(function() {
    let wb = XLSX.utils.book_new();
    
    // Export Individual Table
    let individuData = XLSX.utils.table_to_sheet(document.getElementById('individuTable'));
    XLSX.utils.book_append_sheet(wb, individuData, "Individu");

    // Export Group Table
    let groupData = XLSX.utils.table_to_sheet(document.getElementById('kumpulanTable'));
    XLSX.utils.book_append_sheet(wb, groupData, "Kumpulan");

    XLSX.writeFile(wb, 'Keputusan_Tugasan.xlsx');
  });

  // Export tables to PDF
  $('#exportPdfBtn').click(function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(14);
    doc.text('Senarai Individu', 15, 10);
    doc.autoTable({ html: '#individuTable', startY: 20 });

    doc.addPage();
    doc.setFontSize(14);
    doc.text('Senarai Kumpulan', 15, 10);
    doc.autoTable({ html: '#kumpulanTable', startY: 20 });

    doc.save('Keputusan_Tugasan.pdf');
  });
</script>

</body>
</html>
