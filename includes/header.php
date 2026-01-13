<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALPHA LEDGER | Elite Intelligence</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-deep: #0a192f;
            --navy-card: #112240;
            --gold-primary: #b08d4dff;
            --gold-glow: #e4b55d;
            --white-pure: #ffffff;
            --white-dim: #ccd6f6;
            --border-gold: rgba(197, 160, 89, 0.2);
            --accent-wine: #ff4d4d;
            /* Red for the Exit button */
        }

        /* PREMIUM SHIMMER ANIMATION */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--navy-deep);
            color: var(--white-dim);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ELITE NAVIGATION */
        nav {
            height: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 8%;
            border-bottom: 1px solid var(--border-gold);
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(15px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            letter-spacing: 2px;
            color: var(--white-pure);
            text-decoration: none;
            text-transform: uppercase;
        }

        .logo span {
            color: var(--gold-primary);
            text-shadow: 0 0 10px rgba(197, 160, 89, 0.3);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 40px;
        }

        .nav-links a {
            color: var(--white-pure);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.4s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gold-primary);
            transition: 0.4s;
        }

        .nav-links a:hover {
            color: var(--gold-primary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* HAMBURGER (MOBILE ONLY) */
        .menu-toggle {
            display: none;
            cursor: pointer;
            flex-direction: column;
            gap: 6px;
            z-index: 1100;
        }

        .menu-toggle span {
            width: 28px;
            height: 1px;
            background: var(--gold-primary);
            transition: 0.4s;
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: flex;
            }

            .nav-links {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: var(--navy-deep);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: 0.5s cubic-bezier(0.77, 0, 0.175, 1);
            }

            .nav-links.active {
                opacity: 1;
                visibility: visible;
            }

            .nav-links a {
                font-size: 1.8rem;
                font-family: 'Playfair Display', serif;
            }
        }

        .open .line1 {
            transform: translateY(7px) rotate(45deg);
        }

        .open .line2 {
            opacity: 0;
        }

        .open .line3 {
            transform: translateY(-7px) rotate(-45deg);
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 20px;
            animation: fadeInUp 1s ease-out forwards;
        }

        .card {
            background: var(--navy-card);
            border: 1px solid var(--border-gold);
            padding: 50px;
            border-radius: 4px;
            margin-bottom: 40px;
            transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-glow);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .btn {
            background: linear-gradient(90deg, var(--gold-primary), #f3d498, var(--gold-primary));
            background-size: 200% 100%;
            color: var(--navy-deep);
            border: none;
            padding: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 4px;
            cursor: pointer;
            transition: 0.5s;
            animation: shimmer 3s infinite linear;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            letter-spacing: 6px;
            filter: brightness(1.1);
            box-shadow: 0 0 25px rgba(197, 160, 89, 0.4);
        }

        input,
        textarea {
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border-gold);
            color: var(--white-pure);
            padding: 15px 0;
            width: 100%;
            margin-bottom: 30px;
            font-size: 1.1rem;
            outline: none;
            transition: 0.4s;
        }

        input:focus {
            border-bottom: 1px solid var(--gold-glow);
        }

        .status-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            color: var(--gold-glow);
            text-transform: uppercase;
            letter-spacing: 3px;
            border: 1px solid var(--gold-primary);
            padding: 5px 15px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php" class="logo">Alpha<span>Ledger</span></a>
        <div class="menu-toggle" id="mobile-menu">
            <span class="line1"></span>
            <span class="line2"></span>
            <span class="line3"></span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Terminal</a></li>
            <li><a href="archives.php">Archives</a></li>

            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="#" style="color: var(--gold-glow); font-weight: bold;">ID: <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                <li><a href="logout.php" style="color: var(--accent-wine);">Exit</a></li>
            <?php else: ?>
                <li><a href="network.php">Network</a></li>
            <?php endif; ?>

            <li><a href="syndicate_boss_77.php">Access</a></li>
        </ul>
    </nav>

    <div class="container">

        <script>
            const menu = document.querySelector('#mobile-menu');
            const navLinks = document.querySelector('.nav-links');
            menu.addEventListener('click', () => {
                menu.classList.toggle('open');
                navLinks.classList.toggle('active');
            });
        </script>