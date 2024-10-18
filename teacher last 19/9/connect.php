<?php

// Database connection details (replace with your own)
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
?>