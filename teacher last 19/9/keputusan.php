<?php
session_start();
include 'connect.php';
$name = $_SESSION['name'];

// Fetch all Tugasan for the dropdown
$sql_tugasan = "SELECT tugasan_id, nama_tugasan FROM tugasan";
$result_tugasan = $conn->query($sql_tugasan);

// Initialize an empty array to store student data
$studentData = [];
if (isset($_POST['tugasan_id'])) {
    $tugasan_id = intval($_POST['tugasan_id']);

    // Fetch individual student submissions for selected Tugasan
    $sql_individu = "SELECT p.nama_pelajar AS nama, py.penyerahan_id, py.rubrik_id, r.markah, 'individu' AS type 
    FROM pelajar p
    LEFT JOIN penyerahan py ON p.pelajar_id = py.pelajar_id
    LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
    WHERE py.tugasan_id = $tugasan_id";

    // Fetch group submissions for selected Tugasan
    $sql_group = "SELECT g.nama_kumpulan AS nama, py.penyerahan_id, py.rubrik_id, r.markah, 'kumpulan' AS type
    FROM kumpulan g
    LEFT JOIN penyerahan py ON g.kumpulan_id = py.kumpulan_id
    LEFT JOIN rubrik r ON py.rubrik_id = r.rubrik_id
    WHERE py.tugasan_id = $tugasan_id";

    // Execute the queries
    $result_individu = $conn->query($sql_individu);
    $result_group = $conn->query($sql_group);

    // Store results for individuals and groups
    $studentData['individu'] = $result_individu->fetch_all(MYSQLI_ASSOC);
    $studentData['kumpulan'] = $result_group->fetch_all(MYSQLI_ASSOC);
}
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

            <!-- Tugasan Selection Form -->
            <form method="POST" id="tugasanForm">
                <div class="form-group">
                    <label for="tugasanSelect">Pilih Tugasan:</label>
                    <select class="form-control" id="tugasanSelect" name="tugasan_id" onchange="document.getElementById('tugasanForm').submit()">
                        <option value="">-- Pilih Tugasan --</option>
                        <?php while ($row_tugasan = $result_tugasan->fetch_assoc()): ?>
                            <option value="<?= $row_tugasan['tugasan_id'] ?>" <?= isset($tugasan_id) && $tugasan_id == $row_tugasan['tugasan_id'] ? 'selected' : '' ?>>
                                <?= $row_tugasan['nama_tugasan'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>

            <!-- Display the student data only if a Tugasan is selected -->
            <?php if (isset($studentData['individu']) && isset($studentData['kumpulan'])): ?>
                <div class="mt-4">
                    <!-- Display individual submissions -->
                    <?php if (!empty($studentData['individu'])): ?>
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
                                <?php foreach ($studentData['individu'] as $row): ?>
                                    <tr>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= ($row['penyerahan_id']) ? ($row['rubrik_id'] ? 'Graded' : 'Submitted, Not Graded') : 'Not Submitted' ?></td>
                                        <td><?= ($row['markah']) ? $row['markah'] : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <!-- Display group submissions -->
                    <?php if (!empty($studentData['kumpulan'])): ?>
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
                                <?php foreach ($studentData['kumpulan'] as $row): ?>
                                    <tr>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= ($row['penyerahan_id']) ? ($row['rubrik_id'] ? 'Graded' : 'Submitted, Not Graded') : 'Not Submitted' ?></td>
                                        <td><?= ($row['markah']) ? $row['markah'] : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <!-- Export Buttons -->
                    <button id="exportExcelBtn" class="btn btn-success mt-3">Export to Excel</button>
                    <button id="exportPdfBtn" class="btn btn-danger mt-3">Export to PDF</button>

                <?php else: ?>
                    <p class="text-center mt-4">Sila pilih tugasan untuk melihat keputusannya.</p>
                <?php endif; ?>
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
        // Initialize DataTables if data exists
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
