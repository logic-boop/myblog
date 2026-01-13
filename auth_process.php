<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Check if this codename already exists in the Syndicate database
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user'");
    
    if (mysqli_num_rows($check_user) > 0) {
        // --- LOGIN LOGIC ---
        $row = mysqli_fetch_assoc($check_user);
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['status'] = $row['membership_status']; 
            
            // Redirect to Archives to show them the reports
            header("Location: archives.php");
            exit();
        } else {
            die("INVALID PASSPHRASE. <a href='network.php'>RE-AUTHENTICATE</a>");
        }
    } else {
        // --- REGISTRATION LOGIC ---
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); 
        // Every new user starts as 'free' to trigger the $29 paywall logic
        $sql = "INSERT INTO users (username, password, membership_status) VALUES ('$user', '$hashed_pass', 'free')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $user;
            $_SESSION['status'] = 'free';
            
            // Redirect with a success flag so the Archives can show a welcome message
            header("Location: archives.php?reg=success");
            exit();
        } else {
            die("SYSTEM ERROR: " . mysqli_error($conn));
        }
    }
} else {
    // If someone tries to access this file directly without posting data
    header("Location: network.php");
    exit();
}
?>