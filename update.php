<?php
session_start();
include 'includes/db.php';

// 1. SECURITY: Ensure only the boss can save intelligence
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'James2000') {
    die("UNAUTHORIZED ACCESS DETECTED.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. DATA CAPTURE
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // 3. THE UPDATE COMMAND
    // This pushes your typing into the 'content' column for that specific report
    $sql = "UPDATE submissions SET content = '$content' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // 4. SUCCESS: Send you back to the Command Center
        header("Location: syndicate_boss_77.php?update=success");
        exit();
    } else {
        echo "DATABASE ERROR: " . mysqli_error($conn);
    }
} else {
    // If someone tries to access this file without a form, boot them
    header("Location: syndicate_boss_77.php");
    exit();
}
?>