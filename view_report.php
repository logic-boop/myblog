<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

// 1. Secure the ID from the URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. FRESH STATUS CHECK (Critical for the Profit Logic)
// This checks the database directly instead of just trusting the session
if (isset($_SESSION['username'])) {
    $u_name = $_SESSION['username'];
    $u_check = mysqli_query($conn, "SELECT membership_status FROM users WHERE username = '$u_name'");
    $u_data = mysqli_fetch_assoc($u_check);
    $current_status = $u_data['membership_status'];
} else {
    $current_status = 'free';
}

$result = mysqli_query($conn, "SELECT * FROM submissions WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<div class='container' style='text-align: center; margin-top: 100px;'>
            <h2 style='color: var(--white-pure);'>Intelligence Not Found</h2>
            <a href='index.php' class='btn' style='display:inline-block; margin-top:20px;'>Return to Terminal</a>
          </div>";
    include 'includes/footer.php';
    exit;
}

$content = $row['content'];
$is_declassified = !empty($content);
?>

<div id="progress-container" style="position: fixed; top: 0; left: 0; width: 100%; height: 3px; background: rgba(255,255,255,0.05); z-index: 9999;">
    <div id="progress-bar" style="height: 100%; width: 0%; background: var(--gold-primary); box-shadow: 0 0 10px var(--gold-glow);"></div>
</div>

<div class="report-container" style="animation: fadeInUp 1s ease-out; max-width: 900px; margin: 0 auto; padding: 120px 20px;">

    <div style="text-align: center; margin-bottom: 60px;">
        <span class="status-badge" style="margin-bottom: 20px; display: inline-block;">
            <?php echo ($current_status == 'premium') ? "ACCESS GRANTED" : "ENCRYPTED LOG"; ?>
        </span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3.5rem; color: var(--white-pure); line-height: 1.1; margin-bottom: 20px;">
            <?php echo htmlspecialchars($row['topic']); ?>
        </h1>
        <div style="display: flex; justify-content: center; gap: 30px; font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 2px;">
            <span>Ref: LOG-ALPHA-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></span>
            <span>Verified: <?php echo date("d M Y"); ?></span>
        </div>
    </div>

    <div class="card" style="background: transparent; border: none; border-left: 2px solid var(--gold-primary); padding: 0 0 0 40px; margin-bottom: 80px;">
        <h3 style="color: var(--gold-primary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 20px;">I. Objective</h3>
        <p style="color: var(--white-dim); font-size: 1.2rem; font-style: italic; line-height: 1.6;">
            "<?php echo htmlspecialchars($row['reason']); ?>"
        </p>
    </div>

    <div class="card" style="border-top: 5px solid var(--gold-primary); position: relative; overflow: hidden; padding: 60px; background: rgba(17, 34, 64, 0.4);">
        <h3 style="color: var(--gold-primary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 40px;">II. Verified Analysis</h3>

        <div class="intel-body">
            <?php if ($current_status == 'premium'): ?>
                <div style="color: var(--white-pure); line-height: 2; font-size: 1.1rem; white-space: pre-wrap;">
                    <?php echo htmlspecialchars($content); ?>
                </div>
            <?php else: ?>
                <div style="position: relative; min-height: 400px;">

                    <div style="filter: blur(12px); opacity: 0.2; user-select: none; pointer-events: none; line-height: 2;">
                        <p>High-level intelligence gathering suggests a major shift in capital allocation within this sector. Our scrapers identified specific nodes showing anomalous behavior. By analyzing the cryptographic signatures of the recent transactions, we can conclude that a massive liquidity event is scheduled for the next 48 hours. The primary actors involved have direct ties to global offshore accounts and decentralized liquidity pools that remain undetected by standard regulatory frameworks...</p>
                        <p>Furthermore, the decentralized nature of these assets makes them immune to traditional market circuit breakers. The potential for a 10x return exists for those who can execute entry strategies before the public declassification. Detailed wallet addresses, specific entry timeframes, and exit protocols for this specific asset class are listed below in the restricted section of this report...</p>
                        <p>Analysis of the order books across multiple top-tier exchanges shows a significant accumulation pattern that hasn't been seen since the 2021 bull run. We have verified the whale movement through on-chain analysis and confirmed the destination wallets belong to known institutional early-adopters...</p>
                    </div>

                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; max-width: 500px; text-align: center; padding: 60px 40px; border: 1px solid var(--gold-primary); background: rgba(10, 25, 47, 0.98); z-index: 100; box-shadow: 0 20px 80px rgba(0,0,0,0.8);">
                        <h2 style="color: var(--gold-primary); font-family: 'Playfair Display', serif; margin-bottom: 15px; letter-spacing: 2px;">RESTRICTED ACCESS</h2>
                        <p style="color: var(--white-dim); font-size: 0.9rem; margin-bottom: 35px; line-height: 1.6;">
                            Log #<?php echo $id; ?> contains actionable intelligence and market entry signals reserved for Premium Members.
                        </p>
                        <a href="payment_gateway.php" class="btn" style="display: inline-block; padding: 18px 40px; text-decoration: none; font-weight: bold; background: var(--gold-primary); color: #0a192f;">
                            UNLOCK FULL REPORT ($29.00)
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid rgba(197, 160, 89, 0.2); display: flex; justify-content: space-between; align-items: center;">
            <button onclick="window.print()" class="btn" style="width: auto; padding: 12px 25px; font-size: 0.7rem; background: transparent; border: 1px solid var(--gold-primary); color: var(--gold-primary);">EXPORT PDF</button>
            <a href="archives.php" style="color: var(--white-dim); text-decoration: none; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px;">← Return to Archives</a>
        </div>
    </div>
</div>

<script>
    // READING PROGRESS SCRIPT
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById("progress-bar").style.width = scrolled + "%";
    };
</script>

<?php include 'includes/footer.php'; ?>