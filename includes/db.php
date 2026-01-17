<?php
// THE NEEDFUL: We check if we are on Vercel. If so, use cloud variables. 
// If we are on your computer, it uses your local XAMPP settings.

$host = getenv('DB_HOST') ?: "127.0.0.1"; 
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: ""; 
$db   = getenv('DB_NAME') ?: "empire_db";

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    // Keeping your exact error message
    die("CRITICAL_SYSTEM_FAILURE: Database connection lost. Error: " . mysqli_connect_error());
}

// Ensure the database handles special symbols and currency characters correctly
mysqli_set_charset($conn, "utf8mb4");
?>