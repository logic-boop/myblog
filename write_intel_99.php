<?php
// 1. SECURITY LOCK: Only James2000 can draft intelligence
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'James2000') {
    header("Location: network.php");
    exit;
}

include 'includes/header.php';
include 'includes/db.php';

// 2. DATA ACQUISITION
if (!isset($_GET['id'])) {
    header("Location: syndicate_boss_77.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM submissions WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<div class='container' style='margin-top: 100px; text-align: center;'>
            <h2 style='color: var(--white-pure);'>Target Not Found</h2>
            <a href='syndicate_boss_77.php' class='btn' style='display:inline-block; margin-top:20px;'>Return to Command</a>
          </div>";
    include 'includes/footer.php';
    exit;
}

$has_content = !empty($row['content']);
?>

<main>
    <div class="container" style="max-width: 1000px; padding-top: 50px; padding-bottom: 100px;">

        <div style="margin-bottom: 50px; animation: fadeInUp 0.8s ease-out;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span class="status-badge" style="background: rgba(197, 160, 89, 0.1); border-color: var(--gold-primary);">
                    MODE: <?php echo $has_content ? "EDITING ARCHIVE" : "INITIAL DECLASSIFICATION"; ?>
                </span>
                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; color: var(--gold-primary); letter-spacing: 2px;">
                    REF_ID: #<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>
                </span>
            </div>

            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.8rem; color: var(--white-pure); margin-top: 20px; line-height: 1.2;">
                DECONSTRUCTING: <span style="color: var(--gold-primary); font-style: italic;"><?php echo htmlspecialchars($row['topic']); ?></span>
            </h1>

            <div style="margin-top: 25px; padding: 20px; background: rgba(255,255,255,0.02); border-left: 3px solid var(--gold-primary);">
                <p style="color: var(--gold-primary); font-family: 'JetBrains Mono'; font-size: 0.6rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Primary Objective:</p>
                <p style="color: var(--white-dim); font-size: 1rem; font-weight: 300; line-height: 1.5;">
                    "<?php echo htmlspecialchars($row['reason']); ?>"
                </p>
            </div>
        </div>

        <div class="card" style="padding: 0; background: rgba(10, 25, 47, 0.8); border: 1px solid var(--border-gold); overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
            <div style="background: rgba(255,255,255,0.03); padding: 15px 30px; border-bottom: 1px solid var(--border-gold); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 8px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #ff5f56;"></div>
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #ffbd2e;"></div>
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #27c93f;"></div>
                </div>
                <span style="font-size: 0.65rem; color: var(--gold-primary); font-family: 'JetBrains Mono'; font-weight: bold; letter-spacing: 2px;">SECURE_INTEL_STREAM.TXT</span>
            </div>

            <form action="update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <textarea name="content" rows="20"
                    placeholder="PROMPT: Summarize the market shift... provide actionable data nodes... outline the profit pathway."
                    style="width: 100%; background: transparent; color: var(--white-pure); border: none; padding: 40px; font-family: 'Inter', sans-serif; font-size: 1.1rem; line-height: 1.9; outline: none; resize: vertical; display: block;"
                    required><?php echo htmlspecialchars($row['content']); ?></textarea>

                <div style="padding: 30px; background: rgba(0,0,0,0.3); border-top: 1px solid var(--border-gold); display: flex; justify-content: space-between; align-items: center;">
                    <a href="syndicate_boss_77.php" style="color: var(--white-dim); text-decoration: none; font-size: 0.75rem; font-family: 'JetBrains Mono'; letter-spacing: 1px; text-transform: uppercase;">
                        [ ABORT DRAFT ]
                    </a>

                    <button type="submit" class="btn" style="width: auto; padding: 15px 45px; font-size: 0.8rem; letter-spacing: 2px; box-shadow: 0 0 30px rgba(197, 160, 89, 0.1);">
                        PUBLISH TO LEDGER
                    </button>
                </div>

                <!-- This allows you to choose if a report is a free briefing or paid alpha: -->
                <div style="margin-bottom: 25px;">
                    <label style="color: var(--gold-primary); font-family: 'JetBrains Mono'; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px;">Intelligence Classification</label>
                    <select name="category" style="width: 100%; background: rgba(255,255,255,0.05); color: white; border: 1px solid var(--border-gold); padding: 12px; margin-top: 10px; font-family: 'JetBrains Mono'; outline: none;">
                        <option value="premium">ELITE ALPHA (Paid - ₦46,400)</option>
                        <option value="free">PUBLIC BRIEFING (Free News Feed)</option>
                    </select>
                </div>
            </form>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 0.6rem; color: #4e5d78; letter-spacing: 2px; text-transform: uppercase;">
                PROTOCOL WARNING: Deployment will instantly trigger $29.00 paywall for free-tier nodes.
            </p>
        </div>

    </div>
</main>

<style>
    textarea:focus {
        background: rgba(255, 255, 255, 0.02) !important;
        transition: 0.5s;
    }

    ::placeholder {
        color: #4e5d78;
        opacity: 0.5;
        font-family: 'JetBrains Mono', monospace;
    }
</style>

<?php include 'includes/footer.php'; ?>