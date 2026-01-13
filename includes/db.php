<?php
$host = "127.0.0.1"; // The address we fixed in config.inc.php
$user = "root";
$pass = "";
$db   = "empire_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>