<?php
include 'connect.php'; // Include your database connection

// Fetch the user's ID from the session
$student_id = $_SESSION['id'];

// Get the tugasan_id from the query parameter
$tugasan_id = isset($_GET['tugasan_id']) ? intval($_GET['tugasan_id']) : 0;

if ($tugasan_id <= 0) {
  header("Location: view_tugasan.php");
  exit();
}

// Fetch the relevant Tugasan data based on the tugasan_id
$sql_tugasan = "SELECT t.nama_tugasan, t.jenis_tugasan, p.tarikh_penyerahan2 
                FROM tugasan t 
                JOIN penyerahan p ON t.tugasan_id = p.tugasan_id 
                WHERE p.pelajar_id = ? AND t.tugasan_id = ?";
$stmt = $conn->prepare($sql_tugasan);
$stmt->bind_param("ii", $student_id, $tugasan_id);
$stmt->execute();
$result_tugasan = $stmt->get_result();

if ($result_tugasan->num_rows > 0) {
    $task = $result_tugasan->fetch_assoc();
    $userName = $_SESSION['name']; // Get the user's name from the session
    $taskName = $task['nama_tugasan'];
    $taskType = $task['jenis_tugasan'];
    $date = date("d F Y", strtotime($task['tarikh_penyerahan2']));
} else {
    // Handle case where there are no tasks found
    $userName = "User "; // Default value
    $taskName = "N/A";
    $taskType = "N/A";
    $date = date("d F Y");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sijil Penyertaan</title>
  <link rel="stylesheet" href="styleCert.css">
</head>
<body onload="printCertificate()"> <!-- Automatically print on load -->
  <div id="certificate">
    <div id="header"> 
      <img src="../img/scratch1.png" alt="Logo Scratch" id="logo"> 
      <img src="../img/scratch.png" alt="Scratch Cat" id="scratch-cat">
      <img src="../img/sun1.png" alt="Sun" id="sun">
      <h1>SIJIL PENYERTAAN</h1>
    </div>

    <div id="content">
      <img src="../img/cloud.jpg" alt="cloud1" id="cloud1">
      <p>SIJIL INI DIANUGERAHKAN KEPADA</p>
      <h2 id="user-name"><?= htmlspecialchars($userName) ?></h2>
      <img src="../img/cloud.jpg" alt="cloud" id="cloud">
      <p>KERANA TELAH MENYELESAIKAN PROJEK</p>
      <h3 id="task-name"><?= htmlspecialchars($taskName) ?></h3>
      <img src="../img/cloud.jpg" alt="cloud1" id="cloud1">
      <p>JENIS PROJEK</p>
      <h3 id="task-type"><?= htmlspecialchars($taskType) ?></h3>
      <img src="../img/cloud.jpg" alt="cloud" id="cloud">
      <p>PADA <span id="date"><?= htmlspecialchars($date) ?></span></p> 
    </div>

    <div id="footer">
      <img src="../img/goodjob.png" alt="Tandatangan" id="signature">
    </div>
  </div>
  <script>
    function printCertificate() {
      window.print();
    }
  </script>
</body>
</html>