<?php
// 1. SECURITY: Only the owner (James2000) can access this page
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'James2000') {
    header("Location: network.php");
    exit;
}

include 'includes/header.php';
include 'includes/db.php';

// 2. DATA ENGINE: Pulling real numbers for the dashboard
// Count Premium Users
$premium_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE membership_status = 'premium'");
$premium_data = mysqli_fetch_assoc($premium_q);
$total_premium = $premium_data['total'];

// Calculate Revenue (Price: $29.00 / ₦46,400)
$naira_total = $total_premium * 46400;
$usd_total = $total_premium * 29;

// Count Total Intelligence Submissions
$intel_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM submissions");
$intel_data = mysqli_fetch_assoc($intel_q);
$total_intel = $intel_data['total'];
?>

<div class="container" style="padding-top: 50px; padding-bottom: 100px;">

    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; animation: fadeInUp 0.8s ease-out;">
        <div>
            <span class="status-badge" style="background: rgba(197, 160, 89, 0.1); border-color: var(--gold-primary);">Auth Level: Administrator</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--white-pure); margin-top: 10px;">COMMAND <span style="color: var(--gold-primary); font-style: italic;">CENTER</span></h1>
        </div>
        <div style="text-align: right;">
            <div style="font-family: 'JetBrains Mono', monospace; color: var(--gold-primary); font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 5px;">ESTIMATED ASSET VALUE</div>
            <div style="font-size: 2rem; color: var(--white-pure); font-weight: 600;">₦<?php echo number_format($naira_total); ?> <span style="font-size: 0.8rem; color: #4e5d78;">NGN</span></div>
            <div style="font-size: 0.9rem; color: var(--white-dim); opacity: 0.6;">$<?php echo number_format($usd_total, 2); ?> USD</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px;">
        <div class="card" style="padding: 25px; margin-bottom: 0; border-top: 2px solid var(--gold-primary);">
            <div style="font-size: 0.6rem; color: var(--gold-primary); letter-spacing: 2px; text-transform: uppercase;">Premium Nodes</div>
            <div style="font-size: 2.5rem; color: var(--white-pure); font-family: 'Playfair Display', serif;"><?php echo $total_premium; ?></div>
        </div>
        <div class="card" style="padding: 25px; margin-bottom: 0; border-top: 2px solid var(--white-pure);">
            <div style="font-size: 0.6rem; color: var(--white-dim); letter-spacing: 2px; text-transform: uppercase;">Active Intel</div>
            <div style="font-size: 2.5rem; color: var(--white-pure); font-family: 'Playfair Display', serif;"><?php echo str_pad($total_intel, 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div class="card" style="padding: 25px; margin-bottom: 0; border-top: 2px solid var(--accent-wine);">
            <div style="font-size: 0.6rem; color: var(--accent-wine); letter-spacing: 2px; text-transform: uppercase;">System Health</div>
            <div style="font-size: 2.5rem; color: var(--white-pure); font-family: 'Playfair Display', serif;">99%</div>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: 1px solid var(--border-gold);">
        <div style="padding: 25px; background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border-gold); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--gold-primary); letter-spacing: 2px;">INTELLIGENCE QUEUE</h3>
            <span style="font-size: 0.6rem; color: var(--white-dim); font-family: 'JetBrains Mono';">UPDATE FREQUENCY: REAL-TIME</span>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-gold); background: rgba(0,0,0,0.2);">
                    <th style="padding: 20px; font-size: 0.7rem; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 2px;">Target</th>
                    <th style="padding: 20px; font-size: 0.7rem; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 2px;">Status</th>
                    <th style="padding: 20px; font-size: 0.7rem; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 2px; text-align: right;">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM submissions ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($result)) {
                    $is_ready = !empty($row['content']);
                    $status_txt = $is_ready ? "VERIFIED" : "PENDING";
                    $status_color = $is_ready ? "var(--gold-primary)" : "#4e5d78";

                    echo "<tr class='admin-row' style='border-bottom: 1px solid rgba(255,255,255,0.02); transition: 0.3s;'>";
                    echo "<td style='padding: 25px;'>";
                    echo "<div style='color: #fff; font-weight: 600; font-size: 1rem;'>" . htmlspecialchars($row['topic']) . "</div>";
                    echo "<div style='color: var(--white-dim); font-size: 0.75rem; margin-top: 5px; font-weight: 300;'>LOG ID: #" . str_pad($row['id'], 4, '0', STR_PAD_LEFT) . "</div>";
                    echo "</td>";
                    echo "<td style='padding: 25px;'>";
                    echo "<span style='font-size: 0.6rem; color: $status_color; font-weight: bold; border: 1px solid $status_color; padding: 3px 8px; border-radius: 2px; letter-spacing: 1px;'>$status_txt</span>";
                    echo "</td>";
                    echo "<td style='padding: 25px; text-align: right;'>";
                    echo "<a href='write_intel_99.php?id=" . $row['id'] . "' class='admin-btn' style='background: var(--gold-primary); color: #0a192f;'>[WRITE]</a>";
                    echo "<a href='delete.php?id=" . $row['id'] . "' class='admin-btn' style='background: transparent; color: #ff4d4d; border: 1px solid #ff4d4d; margin-left: 10px;'>[PURGE]</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .admin-row:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .admin-btn {
        text-decoration: none;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.65rem;
        padding: 8px 15px;
        font-weight: bold;
        transition: 0.3s;
        display: inline-block;
    }

    .admin-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        filter: brightness(1.2);
    }
</style>

<?php include 'includes/footer.php'; ?>