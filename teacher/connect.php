<?php

$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "e-learn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (!isset($_SESSION['name'])) {
    // Redirect to the login page if not logged in
    header('Location: ../index.html');
    exit;
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  
}

// Query to check the user's role or affiliation with the cikgu table
$cikgu_query = "SELECT nama_cikgu FROM cikgu WHERE nama_cikgu = '".$_SESSION['name']."'";
$cikgu_result = $conn->query($cikgu_query);

// Check if the user is not cikgu
if ($cikgu_result->num_rows == 0) {
    // Redirect to index back
    header('Location: ../index.html');
    exit;
}

// Rest of your code here...

?>