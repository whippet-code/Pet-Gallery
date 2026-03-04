<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐾 Ultimate Osborne Pet Battle — Coming Soon!</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── Holding-page extras ─────────────────────────────── */

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Floating paws */
        .paws {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .paw {
            position: absolute;
            font-size: 2rem;
            opacity: 0;
            animation: floatPaw linear infinite;
            user-select: none;
        }

        @keyframes floatPaw {
            0%   { transform: translateY(110vh) rotate(0deg);   opacity: 0; }
            10%  { opacity: 0.15; }
            90%  { opacity: 0.15; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* Hero */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 2rem;
            position: relative;
            z-index: 2;
        }

        /* "Coming Soon" badge */
        .coming-soon-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.07);
            border: 2px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 100px;
            padding: 0.5rem 1.4rem;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out both;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #43e97b;
            box-shadow: 0 0 10px #43e97b;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.4); opacity: 0.6; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Main title — reuses .title from styles.css */
        .hero .title {
            animation: fadeInUp 0.9s ease-out 0.15s both;
            margin-bottom: 0;
        }

        /* Sub-tagline */
        .tagline {
            font-size: clamp(1.1rem, 2.5vw, 1.4rem);
            font-weight: 600;
            color: rgba(255, 255, 255, 0.75);
            margin: 1.5rem 0 3rem;
            max-width: 560px;
            line-height: 1.6;
            animation: fadeInUp 0.9s ease-out 0.3s both;
        }

        .tagline strong {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Countdown */
        .countdown-wrapper {
            animation: fadeInUp 0.9s ease-out 0.45s both;
            margin-bottom: 3rem;
        }

        .countdown-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            opacity: 0.5;
            margin-bottom: 1.2rem;
        }

        .countdown {
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cd-block {
            background: rgba(255, 255, 255, 0.06);
            border: 2px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 1.2rem 1.6rem;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            transition: border-color 0.3s ease;
        }

        .cd-block:hover {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .cd-number {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #ffe66d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            min-width: 2ch;
            text-align: center;
            animation: titleGlow 3s ease-in-out infinite;
        }

        .cd-unit {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.55;
        }

        /* Teaser perks */
        .perks {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
            animation: fadeInUp 0.9s ease-out 0.6s both;
        }

        .perk {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 100px;
            padding: 0.6rem 1.3rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .perk:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* Ended state */
        .ended-msg {
            display: none;
            font-size: 1.4rem;
            font-weight: 700;
            color: #43e97b;
            padding: 1rem 2rem;
            border: 2px solid rgba(67, 233, 123, 0.4);
            border-radius: 18px;
            background: rgba(67, 233, 123, 0.07);
            animation: fadeInUp 0.5s ease-out both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .countdown { gap: 0.8rem; }
            .cd-block   { min-width: 70px; padding: 0.9rem 1rem; }
        }
    </style>
</head>
<body>
    <div class="noise-overlay"></div>

    <!-- Floating paws (injected by JS) -->
    <div class="paws" id="pawsContainer"></div>

    <main class="hero">

        <div class="coming-soon-badge">
            <span class="badge-dot"></span>
            Coming Soon
        </div>

        <h1 class="title">
            <span class="title-emoji">🐾</span>
            <span class="title-text">PET BATTLE</span>
            <span class="title-emoji">⚡</span>
        </h1>

        <p class="tagline">
            The ultimate furry face-off is almost here.<br>
            <strong>Vote for your favourite colleague's pet</strong> and help crown the
            Osborne Champion — all in the name of charity 💖
        </p>

        <div class="countdown-wrapper">
            <p class="countdown-label">Launching in</p>
            <div class="countdown" id="countdown">
                <div class="cd-block">
                    <span class="cd-number" id="cd-days">--</span>
                    <span class="cd-unit">Days</span>
                </div>
                <div class="cd-block">
                    <span class="cd-number" id="cd-hours">--</span>
                    <span class="cd-unit">Hours</span>
                </div>
                <div class="cd-block">
                    <span class="cd-number" id="cd-mins">--</span>
                    <span class="cd-unit">Mins</span>
                </div>
                <div class="cd-block">
                    <span class="cd-number" id="cd-secs">--</span>
                    <span class="cd-unit">Secs</span>
                </div>
            </div>
            <p class="ended-msg" id="endedMsg">🎉 We're live! Refresh the page to start voting!</p>
        </div>

        <div class="perks">
            <span class="perk">🐶 Dozens of contestants</span>
            <span class="perk">🗳️ Pick your top 3</span>
            <span class="perk">🏆 One champion crowned</span>
            <span class="perk">💖 For charity</span>
            <span class="perk">🎉 Chance of a 3pm finish just for voting</span>
        </div>

    </main>

    <footer class="footer">
        <p>Made with 💖 for our furry friends • Osborne Tech</p>
    </footer>

    <script>
        // ── CONFIGURE LAUNCH DATE ─────────────────────────────
        const LAUNCH_DATE = new Date('2026-03-11T08:30:00');
        // ─────────────────────────────────────────────────────

        // Countdown timer
        function updateCountdown() {
            const now  = new Date();
            const diff = LAUNCH_DATE - now;

            if (diff <= 0) {
                document.getElementById('countdown').style.display = 'none';
                document.getElementById('endedMsg').style.display  = 'block';
                return;
            }

            const days  = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins  = Math.floor((diff % (1000 * 60 * 60))      / (1000 * 60));
            const secs  = Math.floor((diff % (1000 * 60))           / 1000);

            document.getElementById('cd-days').textContent  = String(days).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-mins').textContent  = String(mins).padStart(2, '0');
            document.getElementById('cd-secs').textContent  = String(secs).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Floating paws
        const EMOJIS = ['🐾', '🐶', '🐱', '🐰', '🐹', '🐻', '🦴', '⭐', '💖', '✨'];
        const container = document.getElementById('pawsContainer');

        function spawnPaw() {
            const el = document.createElement('span');
            el.className = 'paw';
            el.textContent = EMOJIS[Math.floor(Math.random() * EMOJIS.length)];
            el.style.left     = Math.random() * 100 + 'vw';
            el.style.fontSize = (1 + Math.random() * 2) + 'rem';
            const dur = 8 + Math.random() * 10;
            el.style.animationDuration = dur + 's';
            el.style.animationDelay    = (Math.random() * dur) + 's';
            container.appendChild(el);
            setTimeout(() => el.remove(), (dur + dur) * 1000);
        }

        // Seed and spawn
        for (let i = 0; i < 14; i++) spawnPaw();
        setInterval(spawnPaw, 1200);
    </script>
</body>
</html>
