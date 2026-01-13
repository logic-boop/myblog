<?php
session_start();
include 'includes/header.php';
?>

<div class="container"> <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div id="successBox" style="background: rgba(197,160,89,0.1); border: 1px solid var(--gold-primary); padding: 25px; text-align: center; margin-bottom: 40px; border-left: 5px solid var(--gold-primary); animation: fadeInDown 0.5s ease;">
            <p style="color: var(--gold-primary); font-family: 'JetBrains Mono', monospace; font-weight: bold; letter-spacing: 2px;">[ TRANSACTION VERIFIED ]</p>
            <p style="color: white; font-size: 0.9rem; margin-top: 5px;">Syndicate clearance granted. All intelligence logs are now declassified.</p>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('successBox').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('successBox').style.display = 'none';
                }, 500);
            }, 6000);
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['reg']) && $_GET['reg'] == 'success'): ?>
        <div id="regBox" style="background: rgba(255,255,255,0.05); border: 1px solid var(--white-dim); padding: 20px; text-align: center; margin-bottom: 40px;">
            <p style="color: var(--white-pure); font-size: 0.8rem; letter-spacing: 1px;">CONNECTION ESTABLISHED: Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('regBox').style.display = 'none';
            }, 4000);
        </script>
    <?php endif; ?>

    <div style="text-align: center; margin-bottom: 60px; animation: fadeInUp 0.8s ease-out;">
        <span class="status-badge" style="letter-spacing: 5px;">Historical Data Bank</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--white-pure); margin-top: 15px;">
            THE <span style="color: var(--gold-primary); font-style: italic;">ARCHIVES</span>
        </h1>
        <p style="color: var(--white-dim); font-size: 0.9rem; max-width: 600px; margin: 20px auto; line-height: 1.6;">
            Review past intelligence logs and declassified strategic analysis. All entries are cryptographically secured.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; padding-bottom: 80px;">
        <?php
        include 'includes/db.php';
        $result = mysqli_query($conn, "SELECT * FROM submissions WHERE content IS NOT NULL AND content != '' ORDER BY id DESC");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card archive-card' style='padding: 40px; border-bottom: 2px solid var(--border-gold); transition: 0.4s;'>";
                echo "<div style='display: flex; justify-content: space-between; margin-bottom: 20px;'>";
                echo "<span style='font-family: \"JetBrains Mono\", monospace; font-size: 0.6rem; color: var(--gold-primary);'>LOG_REF: #" . str_pad($row['id'], 4, '0', STR_PAD_LEFT) . "</span>";
                echo "<span style='font-size: 0.6rem; color: var(--white-dim); opacity: 0.5;'>CLASS: TOP_SECRET</span>";
                echo "</div>";

                echo "<h3 style='font-family: \"Playfair Display\", serif; font-size: 1.5rem; margin-bottom: 15px;'>";
                echo "<a href='view_report.php?id=" . $row['id'] . "' style='color: var(--white-pure); text-decoration: none;'>";
                echo htmlspecialchars($row['topic']) . "</a>";
                echo "</h3>";

                echo "<p style='color: var(--white-dim); font-size: 0.85rem; line-height: 1.6; font-weight: 300; margin-bottom: 25px;'>";
                echo substr(htmlspecialchars($row['reason']), 0, 100) . "...";
                echo "</p>";

                echo "<a href='view_report.php?id=" . $row['id'] . "' class='archive-link'>ACCESS FILE →</a>";
                echo "</div>";
            }
        } else {
            echo "<div class='card' style='grid-column: 1 / -1; text-align: center; padding: 60px;'>";
            echo "<p style='color: var(--white-dim); font-style: italic;'>No intelligence has been declassified for the archives yet.</p>";
            echo "<a href='index.php' class='btn' style='margin-top: 20px; display: inline-block;'>Deploy New Search</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<style>
    .archive-card:hover {
        border-bottom-color: var(--gold-glow);
        background: rgba(17, 34, 64, 0.6);
        transform: scale(1.02);
    }

    .archive-link {
        color: var(--gold-primary);
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .archive-link:hover {
        color: var(--white-pure);
        letter-spacing: 3px;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php include 'includes/footer.php'; ?>