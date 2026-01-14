<?php
include 'includes/header.php';
include 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: network.php");
    exit;
}

$user_email = $_SESSION['username'] . "@alphaledger.com";
$naira_amount = 46400; // This is $29 converted to Naira
?>

<div class="container" style="max-width: 600px; text-align: center;">
    <div class="card" style="border: 1px solid var(--gold-primary); padding: 60px 40px;">
        <span class="status-badge" style="margin-bottom: 30px;">Direct Encryption Link</span>
        <h1 style="font-family: 'Playfair Display', serif; color: var(--white-pure); margin-bottom: 10px;">PROVISIONAL ACCESS</h1>
        <p style="color: var(--gold-primary); font-family: 'JetBrains Mono'; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 40px;">TOTAL DUE: ₦<?php echo number_format($naira_amount); ?></p>

        <form id="paymentForm">
            <button type="submit" id="pay-btn" class="btn" style="width: 100%;" onclick="payWithPaystack(event)">INITIATE SECURE TRANSFER</button>
        </form>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    function payWithPaystack(e) {
        e.preventDefault();

        // Disable button to prevent double clicking
        const btn = document.getElementById('pay-btn');
        btn.innerHTML = "ESTABLISHING CONNECTION...";
        btn.style.opacity = "0.6";
        btn.style.pointerEvents = "none";

        let handler = PaystackPop.setup({
            key: 'pk_test_077aaebbdbe114fdce6d18a2a1869d1ef4a0c74f', // Replace with your LIVE Public Key when ready
            email: '<?php echo $user_email; ?>',
            amount: <?php echo ($naira_amount * 100); ?>, // Amount in kobo (NGN 46,400.00)
            currency: 'NGN',
            callback: function(response) {
                // If payment is successful, send user to the "Unlocker" script
                window.location.href = "process_payment.php?reference=" + response.reference;
            },
            onClose: function() {
                // Re-enable button if user closes the window without paying
                btn.innerHTML = "INITIATE SECURE TRANSFER";
                btn.style.opacity = "1";
                btn.style.pointerEvents = "auto";
            }
        });
        handler.openIframe();
    }
</script>

<?php include 'includes/footer.php'; ?>