<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expenio — Take Control of Your Money</title>
    <link rel="icon" type="image/png" href="{{ asset('Expenio_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,500&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        :root {
            --bg: #0c0b09;
            --surface: #141210;
            --card: #1c1a16;
            --border: rgba(255, 255, 255, .07);
            --text: #ede7d5;
            --muted: #6e6458;
            --accent: #c8a96e;
            --green: #4e8c62;
            --danger: #c05a42;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Grain texture overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 999;
            pointer-events: none;
            opacity: .028;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: .4;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .anim-fade-up {
            animation: fadeUp .7s ease forwards;
            opacity: 0;
        }

        .anim-delay-1 {
            animation-delay: .1s;
        }

        .anim-delay-2 {
            animation-delay: .22s;
        }

        .anim-delay-3 {
            animation-delay: .36s;
        }

        .anim-delay-4 {
            animation-delay: .52s;
        }

        .anim-delay-5 {
            animation-delay: .68s;
        }

        /* ── Navbar ── */
        nav#navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.1rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            background: rgba(12, 11, 9, .85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            animation: fadeIn .5s ease forwards;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: .01em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .25rem;
        }

        .nav-links a {
            padding: .45rem .85rem;
            font-size: .82rem;
            font-weight: 400;
            color: rgba(237, 231, 213, .55);
            text-decoration: none;
            border-radius: 6px;
            transition: all .15s;
        }

        .nav-links a:hover {
            color: var(--text);
            background: rgba(255, 255, 255, .06);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem 1.3rem;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            border: none;
        }

        .btn-ghost {
            background: transparent;
            color: rgba(237, 231, 213, .65);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .06);
            color: var(--text);
        }

        .btn-primary {
            background: var(--accent);
            color: #1a1510;
            font-weight: 600;
            box-shadow: 0 0 0 0 rgba(200, 169, 110, .4);
        }

        .btn-primary:hover {
            background: #d4b97a;
            box-shadow: 0 4px 20px rgba(200, 169, 110, .3);
            transform: translateY(-1px);
        }

        .btn-large {
            padding: .85rem 2rem;
            font-size: 1rem;
            border-radius: 10px;
        }

        .btn-outline-light {
            background: transparent;
            color: var(--text);
            border: 1px solid rgba(237, 231, 213, .2);
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, .06);
            border-color: rgba(237, 231, 213, .35);
        }

        /* ── Hero section ── */
        #hero {
            min-height: 100vh;
            padding: 8rem 2.5rem 5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .3rem .85rem;
            background: rgba(78, 140, 98, .12);
            border: 1px solid rgba(78, 140, 98, .25);
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #7aba90;
            margin-bottom: 1.5rem;
        }

        .hero-eyebrow .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green);
            position: relative;
        }

        .hero-eyebrow .dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: var(--green);
            animation: pulse-ring 1.5s ease-out infinite;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3rem, 5.5vw, 4.5rem);
            font-weight: 400;
            line-height: 1.08;
            color: var(--text);
            letter-spacing: -.01em;
            margin-bottom: 1.5rem;
        }

        .hero-title em {
            font-style: italic;
            background: linear-gradient(135deg, var(--accent) 0%, #e8c88a 40%, var(--accent) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .hero-sub {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.7;
            color: rgba(237, 231, 213, .55);
            max-width: 440px;
            margin-bottom: 2.5rem;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-stat-row {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 3.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border);
        }

        .hero-stat .val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
        }

        .hero-stat .lbl {
            font-size: .72rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: .25rem;
        }

        .stat-divider {
            width: 1px;
            height: 36px;
            background: var(--border);
        }

        /* ── Dashboard card mockup ── */
        .hero-visual {
            position: relative;
            animation: fadeIn .9s .3s ease forwards;
            opacity: 0;
        }

        .mockup-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .55);
            animation: float 5s ease-in-out infinite;
        }

        .mockup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .mockup-title {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted);
        }

        .mockup-badge {
            font-size: .65rem;
            padding: .2rem .55rem;
            background: rgba(78, 140, 98, .15);
            color: #7aba90;
            border-radius: 99px;
            border: 1px solid rgba(78, 140, 98, .2);
        }

        .mockup-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
            margin-bottom: .4rem;
        }

        .mockup-sub {
            font-size: .75rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .bar-list {
            display: flex;
            flex-direction: column;
            gap: .65rem;
        }

        .bar-row {
            display: flex;
            flex-direction: column;
            gap: .3rem;
        }

        .bar-meta {
            display: flex;
            justify-content: space-between;
        }

        .bar-cat {
            font-size: .75rem;
            color: rgba(237, 231, 213, .6);
        }

        .bar-val {
            font-size: .75rem;
            font-weight: 500;
            color: var(--text);
        }

        .bar-track {
            height: 5px;
            background: rgba(255, 255, 255, .06);
            border-radius: 99px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .mockup-tx {
            margin-top: 1.25rem;
        }

        .tx-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .55rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .tx-row:last-child {
            border-bottom: none;
        }

        .tx-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            flex-shrink: 0;
        }

        .tx-name {
            font-size: .8rem;
            color: rgba(237, 231, 213, .8);
            flex: 1;
        }

        .tx-date {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        .tx-amt {
            font-size: .82rem;
            font-weight: 500;
        }

        .tx-neg {
            color: #e07060;
        }

        .tx-pos {
            color: #7aba90;
        }

        /* Floating smaller card */
        .mini-card {
            position: absolute;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.2rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, .45);
        }

        .mini-card-1 {
            right: -2.5rem;
            top: 2rem;
            animation: float 4s 1s ease-in-out infinite;
            min-width: 150px;
        }

        .mini-card-2 {
            left: -2rem;
            bottom: 3rem;
            animation: float 6s .5s ease-in-out infinite;
            min-width: 165px;
        }

        .mini-label {
            font-size: .62rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted);
            margin-bottom: .4rem;
        }

        .mini-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
        }

        .mini-sub {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .2rem;
        }

        .mini-trend {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .7rem;
            margin-top: .4rem;
        }

        .trend-up {
            color: #7aba90;
        }

        .trend-dn {
            color: #e07060;
        }

        /* ── Features Section ── */
        #features {
            padding: 6rem 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-label {
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 400;
            line-height: 1.15;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .section-sub {
            font-size: .95rem;
            color: rgba(237, 231, 213, .5);
            line-height: 1.7;
            max-width: 480px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-top: 3.5rem;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.75rem;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity .3s;
        }

        .feature-card:hover {
            border-color: rgba(200, 169, 110, .2);
            transform: translateY(-3px);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.2rem;
        }

        .feature-icon.gold {
            background: rgba(200, 169, 110, .1);
            color: var(--accent);
        }

        .feature-icon.green {
            background: rgba(78, 140, 98, .1);
            color: #7aba90;
        }

        .feature-icon.danger {
            background: rgba(192, 90, 66, .1);
            color: #e08070;
        }

        .feature-icon.blue {
            background: rgba(80, 120, 200, .1);
            color: #809de0;
        }

        .feature-icon.purple {
            background: rgba(140, 90, 200, .1);
            color: #b090e0;
        }

        .feature-icon.teal {
            background: rgba(60, 160, 160, .1);
            color: #70c0c0;
        }

        .feature-title {
            font-size: .95rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: .5rem;
        }

        .feature-desc {
            font-size: .83rem;
            color: rgba(237, 231, 213, .45);
            line-height: 1.65;
        }

        /* ── CTA section ── */
        #cta {
            margin: 2rem 2.5rem 5rem;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4.5rem 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            max-width: 1150px;
            margin-left: auto;
            margin-right: auto;
        }

        #cta::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 169, 110, .07) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .cta-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 400;
            color: var(--text);
            margin-bottom: 1rem;
            line-height: 1.15;
        }

        .cta-title em {
            font-style: italic;
            color: var(--accent);
        }

        .cta-sub {
            font-size: .95rem;
            color: rgba(237, 231, 213, .45);
            margin-bottom: 2.5rem;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }

        .cta-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* ── Footer ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            color: rgba(237, 231, 213, .4);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: .78rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .15s;
        }

        .footer-links a:hover {
            color: var(--text);
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            nav#navbar {
                padding: 0.95rem 1.1rem;
            }

            .nav-links {
                display: none;
            }

            .nav-auth {
                gap: .45rem !important;
            }

            .nav-auth .btn {
                padding: .42rem .75rem !important;
                font-size: .74rem !important;
            }

            .brand-name {
                font-size: 1.15rem;
            }

            #hero {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding-top: 7rem;
            }

            .hero-visual {
                display: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            nav#navbar {
                padding: 1rem 1.25rem;
            }

            .brand-name {
                font-size: 1.05rem;
            }

            .nav-auth .btn {
                padding: .4rem .6rem !important;
                font-size: .72rem !important;
            }

            #hero {
                padding: 6.5rem 1.25rem 3rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            #features,
            #cta {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            footer {
                padding: 1.5rem 1.25rem;
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 420px) {
            .nav-auth .btn-ghost {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ -->
    <nav id="navbar">
        <a href="/" class="brand-logo">
            <div class="brand-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            <span class="brand-name">Expenio</span>
        </a>

        <div class="nav-links" style="display:flex;align-items:center;gap:.25rem;">
            <a href="#features">Features</a>
            <a href="#pricing">Pricing</a>
            <a href="#about">About</a>
        </div>

        <div class="nav-auth" style="display:flex;align-items:center;gap:.6rem;">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-ghost" style="padding:.45rem .95rem;font-size:.82rem">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost" style="padding:.45rem .95rem;font-size:.82rem">
                        Sign In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary"
                            style="padding:.45rem .95rem;font-size:.82rem">
                            Get Started
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>


    <!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
    <section>
        <div id="hero">

            {{-- Left: Copy --}}
            <div>
                <div class="hero-eyebrow anim-fade-up">
                    <span class="dot"></span>
                    Now in open beta
                </div>

                <h1 class="hero-title anim-fade-up anim-delay-1">
                    Every rupee<br>
                    <em>accounted for,</em><br>
                    always.
                </h1>

                <p class="hero-sub anim-fade-up anim-delay-2">
                    Expenio gives you a clear, real-time picture of your finances — track spending, set budgets, and
                    understand where your money actually goes.
                </p>

                <div class="hero-cta anim-fade-up anim-delay-3">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                            Start for free
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                    <a href="#features" class="btn btn-outline-light btn-large">
                        See how it works
                    </a>
                </div>

                <div class="hero-stat-row anim-fade-up anim-delay-4">
                    <div class="hero-stat">
                        <div class="val">12k+</div>
                        <div class="lbl">Active users</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="hero-stat">
                        <div class="val">₹2.4Cr</div>
                        <div class="lbl">Expenses tracked</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="hero-stat">
                        <div class="val">98%</div>
                        <div class="lbl">Satisfaction</div>
                    </div>
                </div>
            </div>

            {{-- Right: Dashboard mockup --}}
            <div class="hero-visual">
                <div style="position:relative; padding: 2rem 2.5rem;">

                    {{-- Main card --}}
                    <div class="mockup-card">
                        <div class="mockup-header">
                            <div class="mockup-title">Monthly Overview</div>
                            <div class="mockup-badge">↓ 8% vs last month</div>
                        </div>
                        <div class="mockup-amount">₹38,450</div>
                        <div class="mockup-sub">Total expenses · August 2025</div>

                        {{-- Category bars --}}
                        <div class="bar-list">
                            <div class="bar-row">
                                <div class="bar-meta">
                                    <span class="bar-cat">🍽 Food & Dining</span>
                                    <span class="bar-val">₹11,200</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width:72%;background:var(--accent)"></div>
                                </div>
                            </div>
                            <div class="bar-row">
                                <div class="bar-meta">
                                    <span class="bar-cat">🚌 Transport</span>
                                    <span class="bar-val">₹6,800</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width:44%;background:var(--green)"></div>
                                </div>
                            </div>
                            <div class="bar-row">
                                <div class="bar-meta">
                                    <span class="bar-cat">🛍 Shopping</span>
                                    <span class="bar-val">₹9,500</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width:61%;background:#c05a42"></div>
                                </div>
                            </div>
                            <div class="bar-row">
                                <div class="bar-meta">
                                    <span class="bar-cat">💊 Health</span>
                                    <span class="bar-val">₹3,200</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width:21%;background:#809de0"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Recent transactions --}}
                        <div class="mockup-tx">
                            <div class="mockup-title" style="margin-bottom:.75rem">Recent</div>
                            <div class="tx-row">
                                <div class="tx-icon" style="background:rgba(200,169,110,.1)">☕</div>
                                <div>
                                    <div class="tx-name">Blue Tokai Coffee</div>
                                    <div class="tx-date">Today, 9:42 AM</div>
                                </div>
                                <div class="tx-amt tx-neg">−₹380</div>
                            </div>
                            <div class="tx-row">
                                <div class="tx-icon" style="background:rgba(78,140,98,.1)">💰</div>
                                <div>
                                    <div class="tx-name">Salary Credit</div>
                                    <div class="tx-date">Aug 1, 10:00 AM</div>
                                </div>
                                <div class="tx-amt tx-pos">+₹75,000</div>
                            </div>
                            <div class="tx-row">
                                <div class="tx-icon" style="background:rgba(128,90,200,.1)">📱</div>
                                <div>
                                    <div class="tx-name">Netflix Subscription</div>
                                    <div class="tx-date">Aug 3, 12:00 AM</div>
                                </div>
                                <div class="tx-amt tx-neg">−₹649</div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating mini card: Savings --}}
                    <div class="mini-card mini-card-1">
                        <div class="mini-label">Saved this month</div>
                        <div class="mini-val">₹18,200</div>
                        <div class="mini-trend trend-up">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="18 15 12 9 6 15" />
                            </svg>
                            +12% vs July
                        </div>
                    </div>

                    {{-- Floating mini card: Budget --}}
                    <div class="mini-card mini-card-2">
                        <div class="mini-label">Budget remaining</div>
                        <div class="mini-val" style="color:var(--accent)">₹6,550</div>
                        <div class="mini-sub">of ₹45,000 budget</div>
                        <div
                            style="margin-top:.6rem;height:4px;background:rgba(255,255,255,.06);border-radius:99px;overflow:hidden;">
                            <div style="width:85%;height:100%;border-radius:99px;background:var(--accent)"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     FEATURES
═══════════════════════════════════════════ -->
    <section id="features">
        <div style="text-align:center; margin-bottom:1rem;">
            <div class="section-label">What you get</div>
            <h2 class="section-title" style="max-width:520px;margin:0 auto .75rem">
                Built for people who want<br><em style="font-style:italic">clarity</em>, not complexity
            </h2>
            <p class="section-sub" style="margin:0 auto">
                Every feature is designed around one goal — helping you understand and improve your financial life.
            </p>
        </div>

        <div class="features-grid">

            <div class="feature-card">
                <div class="feature-icon gold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10" />
                        <line x1="12" y1="20" x2="12" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="14" />
                    </svg>
                </div>
                <div class="feature-title">Smart Analytics</div>
                <div class="feature-desc">Visual breakdowns of your spending patterns across categories, time periods,
                    and custom filters.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    </svg>
                </div>
                <div class="feature-title">Budget Envelopes</div>
                <div class="feature-desc">Set monthly budgets per category and get notified before you overspend — not
                    after.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon danger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                        <polyline points="17 6 23 6 23 12" />
                    </svg>
                </div>
                <div class="feature-title">Income Tracking</div>
                <div class="feature-desc">Record multiple income sources and watch your net savings grow over time with
                    trend lines.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                </div>
                <div class="feature-title">Instant Search</div>
                <div class="feature-desc">Find any transaction instantly across your entire history with powerful
                    filters and tags.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon purple">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div class="feature-title">Export Reports</div>
                <div class="feature-desc">Generate monthly and yearly reports in PDF or CSV format, ready to share with
                    your accountant.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon teal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div class="feature-title">Secure & Private</div>
                <div class="feature-desc">Your financial data is encrypted at rest and in transit. We never sell or
                    share your information.</div>
            </div>

        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     CTA
═══════════════════════════════════════════ -->
    <div id="cta">
        <div class="section-label" style="margin-bottom:1rem">Get started today</div>
        <h2 class="cta-title">
            Your finances, finally<br><em>under control</em>
        </h2>
        <p class="cta-sub">
            Join thousands of people who've stopped wondering where their money went — and started deciding where it
            goes.
        </p>
        <div class="cta-btns">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                    Create free account
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-large">
                    Sign in to your account
                </a>
            @endif
        </div>
    </div>


    <!-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ -->
    <footer>
        <div class="footer-brand">Expenio &copy; {{ date('Y') }}</div>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Support</a>
            <a href="#">GitHub</a>
        </div>
    </footer>

</body>

</html>
