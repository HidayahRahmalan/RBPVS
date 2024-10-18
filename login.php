<?php
session_start();
ob_start(); // Keep the output buffer started

include 'connect.php';

// Get data from the AJAX request
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Attempt login against 'cikgu' table first
    $stmt = $conn->prepare("SELECT cikgu_id, kata_laluan, nama_cikgu FROM cikgu WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['kata_laluan'];

        if ($password === $stored_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $row['cikgu_id'];
            $_SESSION['role'] = 'cikgu';
            $_SESSION['name'] = $row['nama_cikgu'];
            ob_end_clean(); 
            echo "success_cikgu";
        } else {
            ob_end_clean(); 
            echo "error_password";
        }
    } else {
        error_log("User not found in 'cikgu' table. Trying 'pelajar' table.");
        // If not found in 'cikgu', try 'pelajar' table
        $stmt = $conn->prepare("SELECT pelajar_id, kata_laluan, nama_pelajar FROM pelajar WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['kata_laluan'];

            if ($password === $stored_password) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['pelajar_id'];
                $_SESSION['role'] = 'pelajar';
                $_SESSION['name'] = $row['nama_pelajar'];
                ob_end_clean(); 
                echo "success_pelajar";
            } else {
                ob_end_clean(); 
                echo "error_password";
            }
        } else {
            error_log("User not found in either table.");
            ob_end_clean(); 
            echo "error_user";
        }
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    ob_end_clean(); 
    echo "error_unknown";
} finally {
    $stmt->close();
    $conn->close();
}
?>