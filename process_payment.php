<?php
session_start();
include 'includes/db.php';

// If we get a reference back from Paystack, the user has paid
if (isset($_GET['reference']) && isset($_SESSION['username'])) {
    $user = $_SESSION['username'];

    // Update the database to PREMIUM
    $sql = "UPDATE users SET membership_status = 'premium' WHERE username = '$user'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'premium';
        // Send them back to the Archives to see the clear text
        header("Location: archives.php?status=success");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>