<?php
$host = "127.0.0.1"; 
$user = "root";
$pass = ""; // On XAMPP Linux, the default password is usually empty.
$db   = "empire_db";

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("CRITICAL_SYSTEM_FAILURE: Database connection lost. Error: " . mysqli_connect_error());
}

// Ensure the database handles special symbols and currency characters correctly
mysqli_set_charset($conn, "utf8mb4");
?>