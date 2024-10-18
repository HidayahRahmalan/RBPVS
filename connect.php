<?php
session_start(); // Start the session

// Database connection details (replace with your own)
$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "e-learn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  

}
?>