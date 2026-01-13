<?php include 'includes/header.php'; ?>

<section class="terminal-entry">
    <div class="card" style="border-top: 1px solid var(--gold-primary);">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <span class="status-badge" style="margin-bottom: 0;">Encryption: Active</span>
            <span style="height: 8px; width: 8px; background: var(--gold-glow); border-radius: 50%; box-shadow: 0 0 10px var(--gold-glow); animation: pulse 2s infinite;"></span>
        </div>

        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.8rem; color: var(--white-pure); margin-bottom: 10px; line-height: 1.2;">
            INTELLIGENCE <br><span style="color: var(--gold-primary); font-style: italic;">TERMINAL</span>
        </h2>
        <p style="color: var(--white-dim); font-size: 1.05rem; line-height: 1.8; max-width: 600px; margin-bottom: 40px; font-weight: 300;">
            Input high-value market sectors or emerging geopolitical shifts. Our analysts deconstruct the data to provide the Alpha your network requires.
        </p>

        <form action="suggest.php" method="POST" style="position: relative;">
            <div style="margin-bottom: 40px;">
                <label style="color: var(--gold-primary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 3px; font-weight: 700; display: block; margin-bottom: 5px;">Sector Identification</label>
                <input type="text" name="topic" placeholder="e.g. Lithium Mining, Sovereign AI, Digital Minimalism..." required>
            </div>

            <div style="margin-bottom: 40px;">
                <label style="color: var(--gold-primary); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 3px; font-weight: 700; display: block; margin-bottom: 5px;">Strategic Justification</label>
                <textarea name="reason" rows="3" placeholder="Why must the Syndicate prioritize this investigation?" required></textarea>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Initiate Deployment</button>
        </form>
    </div>
</section>

<section style="margin-top: 100px; padding-bottom: 100px;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 60px;">
        <div style="height: 1px; background: var(--border-gold); flex: 1;"></div>
        <h3 style="font-family: 'Playfair Display', serif; color: var(--gold-primary); letter-spacing: 5px; text-transform: uppercase; font-size: 0.8rem; white-space: nowrap;">
            Verified Intelligence Feed
        </h3>
        <div style="height: 1px; background: var(--border-gold); flex: 1;"></div>
    </div>

    <?php
    include 'includes/db.php';
    $result = mysqli_query($conn, "SELECT * FROM submissions ORDER BY id DESC LIMIT 10");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $is_ready = !empty($row['content']);
            $status = $is_ready ? "DECLASSIFIED" : "UNDER INVESTIGATION";
            $status_color = $is_ready ? "var(--gold-glow)" : "rgba(255,255,255,0.2)";

            echo "<div class='card feed-card' style='padding: 40px; border-left: 2px solid $status_color; transition: 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);'>";
            echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;'>";
            echo "<span style='font-family: \"JetBrains Mono\", monospace; font-size: 0.65rem; color: #4e5d78; letter-spacing: 1px;'>LOG ID: #" . str_pad($row['id'], 4, '0', STR_PAD_LEFT) . "</span>";
            echo "<div style='display: flex; align-items: center; gap: 8px;'>";
            echo "<span style='height: 6px; width: 6px; background: $status_color; border-radius: 50%;'></span>";
            echo "<span style='font-size: 0.65rem; color: $status_color; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;'>$status</span>";
            echo "</div>";
            echo "</div>";

            echo "<h4 style='font-family: \"Playfair Display\", serif; font-size: 1.8rem; margin-bottom: 15px;'>";
            echo "<a href='view_report.php?id=" . $row['id'] . "' class='feed-link'>";
            echo htmlspecialchars($row['topic']) . "</a></h4>";

            echo "<p style='color: var(--white-dim); font-size: 0.95rem; font-weight: 300; line-height: 1.6; max-width: 750px;'>" . htmlspecialchars($row['reason']) . "</p>";

            if ($is_ready) {
                echo "<div style='margin-top: 25px;'>";
                echo "<a href='view_report.php?id=" . $row['id'] . "' style='color: var(--gold-primary); font-size: 0.7rem; text-decoration: none; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;'>Access Report →</a>";
                echo "</div>";
            }
            echo "</div>";
        }
    } else {
        echo "<div class='card' style='text-align: center; color: var(--white-dim); padding: 60px;'>The Ledger is currently awaiting input data.</div>";
    }
    ?>
</section>

<style>
    /* CSS ENHANCEMENTS */
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.5);
            opacity: 0.5;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .feed-link {
        color: var(--white-pure);
        text-decoration: none;
        transition: 0.4s;
        background: linear-gradient(to right, var(--gold-primary), var(--gold-primary)) no-repeat;
        background-size: 0% 1px;
        background-position: left bottom;
    }

    .feed-link:hover {
        color: var(--gold-primary);
        background-size: 100% 1px;
    }

    .feed-card:hover {
        background: rgba(17, 34, 64, 0.8);
        padding-left: 50px;
        /* Moves the content slightly when hovering */
    }
</style>

<?php echo "</div></body></html>"; ?>