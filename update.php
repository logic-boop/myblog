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
    
    // NEEDFUL: Capture the category choice (Free vs Premium) from write_intel_99.php
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Ensure special characters like ₦ or "..." save correctly
    mysqli_set_charset($conn, "utf8mb4");

    // 3. THE UPDATE COMMAND
    // This now saves both the text CONTENT and the CATEGORY classification
    $sql = "UPDATE submissions SET content = '$content', category = '$category' WHERE id = '$id'";

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