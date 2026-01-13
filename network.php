<?php include 'includes/header.php'; ?>

<div class="container" style="max-width: 450px; margin-top: 100px;">
    <div class="card" style="border: 1px solid var(--border-gold); background: rgba(17, 34, 64, 0.8);">
        <div style="text-align: center; margin-bottom: 30px;">
            <span class="status-badge">New Connection</span>
            <h2 style="color: var(--white-pure); font-family: 'Playfair Display', serif; margin-top: 10px;">SECURE REGISTRATION</h2>
            <p style="color: var(--gold-primary); font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase;">Assign your syndicate credentials</p>
        </div>

        <form id="regForm" action="auth_process.php" method="POST" onsubmit="handleReg(event)">
            <div style="margin-bottom: 25px;">
                <input type="text" name="username" placeholder="CODENAME" required
                    style="width: 100%; padding: 15px; background: rgba(0,0,0,0.3); border: none; border-bottom: 1px solid var(--border-gold); color: white; font-family: 'JetBrains Mono', monospace;">
            </div>
            <div style="margin-bottom: 35px;">
                <input type="password" name="password" placeholder="SECURE PASSPHRASE" required
                    style="width: 100%; padding: 15px; background: rgba(0,0,0,0.3); border: none; border-bottom: 1px solid var(--border-gold); color: white; font-family: 'JetBrains Mono', monospace;">
            </div>

            <button type="submit" id="submitBtn" class="btn" style="width: 100%;">ESTABLISH CONNECTION</button>
        </form>

        <div id="loadingMessage" style="display: none; text-align: center; margin-top: 20px; color: var(--gold-primary); font-size: 0.8rem; font-family: 'JetBrains Mono';">
            ENCRYPTING CREDENTIALS...
        </div>
    </div>
</div>

<script>
    function handleReg(event) {
        const form = event.target;
        const btn = document.getElementById('submitBtn');
        const loader = document.getElementById('loadingMessage');

        // 1. Change button text to show activity
        btn.style.opacity = "0.5";
        btn.innerText = "CONNECTING...";
        loader.style.display = "block";

        // 2. The Eraser Logic: 
        // We use a 150ms timeout to ensure the browser has read the input values 
        // and sent them to auth_process.php before we wipe them clean.
        setTimeout(() => {
            form.reset();
            btn.style.opacity = "1";
            btn.innerText = "ESTABLISH CONNECTION";
        }, 150);
    }
</script>

<?php include 'includes/footer.php'; ?>