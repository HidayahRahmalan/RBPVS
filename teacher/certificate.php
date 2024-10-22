<!DOCTYPE html>
<html>
<head>
  <title>Sijil Penyertaan</title>
  <link rel="stylesheet" href="styleCert.css">
</head>
<body>
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
      <h2 id="user-name"></h2>
      <img src="../img/cloud.jpg" alt="cloud" id="cloud">
      <p>KERANA TELAH MENYELESAIKAN PROJEK</p>
      <h3 id="task-name"></h3>
      <img src="../img/cloud.jpg" alt="cloud1" id="cloud1">
      <p>JENIS PROJEK </p>
      <h3 id="task-type"></h3>
      <img src="../img/cloud.jpg" alt="cloud" id="cloud">
      <p>PADA <span id="date"></span></p> 
    </div>

    <div id="footer">
      <img src="../img/goodjob.png" alt="Tandatangan" id="signature">
    </div>
  </div>
  <button id="print-button" onclick="printCertificate()">Cetak Sijil</button>
  <script>
    // script.js
    const userName = "John Doe"; // Replace with actual user name
    const taskName = "Asas Pembangunan Web";
    const taskType = "Individu"; // Replace with actual task name
    const date = new Date().toLocaleDateString();

    document.getElementById("user-name").textContent = userName;
    document.getElementById("task-name").textContent = taskName;
    document.getElementById("task-type").textContent = taskType;
    document.getElementById("date").textContent = date;

    function printCertificate() {
      window.print();
    }
  </script>
</body>
</html>