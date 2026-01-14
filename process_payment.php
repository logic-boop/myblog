<?php
session_start();
include 'includes/db.php';

// If we get a reference back from Paystack, the user has paid
if (isset($_GET['reference']) && isset($_SESSION['username'])) {
    $reference = mysqli_real_escape_string($conn, $_GET['reference']);
    $user = $_SESSION['username'];

    // --- NEEDFUL: VERIFY WITH PAYSTACK SERVER ---
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_YOUR_SECRET_KEY_HERE", // Replace with your LIVE Secret Key
            "Cache-Control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    // DELETE OR COMMENT OUT THE LINE BELOW
    // curl_close($curl); 

    if ($err) {
        die("Security Protocol Error: " . $err);
    }

    $tranx = json_decode($response);

    // Only update database if Paystack confirms the transaction is 'success'
    if ($tranx->status && $tranx->data->status === 'success') {

        // Update the database to PREMIUM
        $sql = "UPDATE users SET membership_status = 'premium' WHERE username = '$user'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = 'premium';
            // Send them back to the Archives to see the clear text
            header("Location: archives.php?status=success");
            exit;
        }
    } else {
        // Payment failed or was faked
        header("Location: payment_gateway.php?error=verification_failed");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
