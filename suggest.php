<?php

// Turn on error reporting so we can see what's wrong if it fails again

ini_set('display_errors', 1);

error_reporting(E_ALL);



// 1. Connect to the vault

$conn = mysqli_connect("127.0.0.1", "root", "", "empire_db");



if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());
}



// 2. Capture and Clean the data

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $topic = mysqli_real_escape_string($conn, $_POST['topic']);

    $reason = mysqli_real_escape_string($conn, $_POST['reason']);



    // 3. Send to Database

    // We explicitly tell the database to leave 'content' empty for now

    $sql = "INSERT INTO submissions (topic, reason, content) VALUES ('$topic', '$reason', '')";



    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('INTELLIGENCE LOGGED: The Syndicate is processing.'); window.location.href='index.php';</script>";
    } else {

        echo "Database Error: " . mysqli_error($conn);
    }
} else {

    header("Location: index.php");
}
