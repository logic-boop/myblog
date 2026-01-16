<?php
session_start();
include 'includes/db.php';

// 1. SECURITY: Ensure only James2000 can save intelligence
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'James2000') {
    die("UNAUTHORIZED ACCESS DETECTED.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Set charset for currency symbols like ₦
    mysqli_set_charset($conn, "utf8mb4");

    // 2. DATA CAPTURE
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    
    // Check if this is a Fresh Broadcast (id will be 0)
    if ($id == 0) {
        // 3a. INSERT NEW BROADCAST
        // Capture the topic specifically for new posts
        $topic = mysqli_real_escape_string($conn, $_POST['topic']);
        
        // We insert into your 'new' table for the public/elite archives
        $sql = "INSERT INTO new (title, content, classification, image_url) 
                VALUES ('$topic', '$content', '$category', '$image_url')";
        
        $redirect_msg = "broadcast=live";
    } else {
        // 3b. UPDATE EXISTING SUBMISSION
        // This updates the 'submissions' table based on the ID
        $sql = "UPDATE submissions SET 
                content = '$content', 
                category = '$category', 
                image_url = '$image_url' 
                WHERE id = '$id'";
        
        $redirect_msg = "update=success";
    }

    // 4. EXECUTION
    if (mysqli_query($conn, $sql)) {
        header("Location: syndicate_boss_77.php?$redirect_msg");
        exit();
    } else {
        echo "DATABASE ERROR: " . mysqli_error($conn);
    }
} else {
    header("Location: syndicate_boss_77.php");
    exit();
}
?>