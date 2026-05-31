<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expenio - Expense Tracker & Budget Management App</title>
    <meta name="description"
        content="Expenio is a smart expense tracker and budget management app to track daily expenses, monitor income, and manage personal finances easily.">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ url('/') }}">
    <meta name="keywords"
        content="expense tracker, budget management app, money manager, personal finance tracker, daily expense tracker, income and expense tracker, monthly budget planner, finance app India">
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Expenio - Smart Expense Tracker & Budget Manager">
    <meta property="og:description"
        content="Track daily expenses, manage budgets, and control your finances with Expenio. Simple and powerful expense tracker app.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('Expenio_logo.png') }}">
    <meta property="og:site_name" content="Expenio">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Expenio - Expense Tracker App">
    <meta name="twitter:description"
        content="Manage your money, track expenses, and plan your budget easily with Expenio.">
    <meta name="twitter:image" content="{{ asset('Expenio_logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('Expenio_logo.png') }}">

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "SoftwareApplication",
            "name": "Expenio",
            "applicationCategory": "FinanceApplication",
            "operatingSystem": "Web",
            "url": "{{ url('/') }}",
            "image": "{{ asset('Expenio_logo.png') }}",
            "description": "Expenio is a web-based expense tracker and budget manager that helps users track spending, monitor income, and plan monthly budgets.",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "INR"
            },
            "featureList": [
                "Track daily expenses and income",
                "Set category-wise monthly budgets",
                "Analyze spending trends and reports",
                "Export financial summaries"
            ]
        }
    </script>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [{
                    "@type": "Question",
                    "name": "What is Expenio?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Expenio is a smart expense tracker and budget management app that helps you organize daily spending, monitor income, and improve personal finance decisions."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How can I track my expenses?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can add transactions, assign categories, and review real-time dashboards to track expenses and understand where your money goes."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is Expenio free?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, Expenio offers a free plan to start tracking expenses and managing budgets right away."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I create monthly category budgets?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, you can set monthly category budgets and compare actual spending against each limit."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I export expense reports?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes, Expenio supports report exports so you can share summaries with your accountant or team."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is my financial data secure?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Expenio protects your financial data using encryption in transit and at rest."
                    }
                }
            ]
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,500&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">

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

        .nav-auth {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .mobile-menu-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text);
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .mobile-menu-btn:hover {
            border-color: rgba(255, 255, 255, .2);
            background: rgba(255, 255, 255, .04);
        }

        .mobile-menu-btn .icon-close {
            display: none;
        }

        .mobile-menu-btn[aria-expanded="true"] .icon-menu {
            display: none;
        }

        .mobile-menu-btn[aria-expanded="true"] .icon-close {
            display: inline;
        }

        .mobile-nav {
            display: none;
            position: fixed;
            top: 72px;
            left: 1rem;
            right: 1rem;
            z-index: 99;
            background: rgba(20, 18, 16, .97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
            padding: .85rem;
            flex-direction: column;
            gap: .75rem;
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
            transition: opacity .2s ease, transform .2s ease;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .mobile-nav-links a {
            display: block;
            text-decoration: none;
            color: rgba(237, 231, 213, .82);
            font-size: .9rem;
            padding: .7rem .75rem;
            border: 1px solid transparent;
            border-radius: 9px;
            transition: background .15s, border-color .15s, color .15s;
        }

        .mobile-nav-links a:hover {
            background: rgba(255, 255, 255, .04);
            border-color: rgba(255, 255, 255, .08);
            color: var(--text);
        }

        .mobile-nav-auth {
            display: grid;
            gap: .55rem;
            padding-top: .7rem;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .mobile-nav-auth .btn {
            width: 100%;
            justify-content: center;
            padding: .68rem .95rem;
            font-size: .84rem;
        }

        .mobile-nav.is-open {
            display: flex;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
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

        .seo-section {
            padding: 0 2.5rem 5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .seo-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, .95fr);
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .seo-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.6rem;
        }

        .seo-card-highlight {
            background: radial-gradient(circle at top right, rgba(200, 169, 110, .1), transparent 46%), var(--card);
        }

        .seo-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 500;
            line-height: 1.2;
            color: var(--text);
            margin-bottom: .7rem;
        }

        .seo-copy {
            font-size: .9rem;
            color: rgba(237, 231, 213, .58);
            line-height: 1.75;
        }

        .seo-copy+.seo-copy {
            margin-top: .8rem;
        }

        .seo-points {
            margin-top: 1rem;
            padding-left: 1rem;
            display: grid;
            gap: .4rem;
        }

        .seo-points li {
            font-size: .83rem;
            color: rgba(237, 231, 213, .58);
            line-height: 1.5;
        }

        .seo-points li::marker {
            color: var(--accent);
        }

        .seo-metrics {
            margin-top: 1rem;
            display: grid;
            gap: .7rem;
        }

        .metric-chip {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .7rem .8rem;
            background: rgba(255, 255, 255, .015);
        }

        .metric-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
        }

        .metric-label {
            font-size: .72rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: .3rem;
        }

        #pricing {
            padding: 0 2.5rem 5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .pricing-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.6rem;
            display: flex;
            flex-direction: column;
            gap: .85rem;
        }

        .pricing-card.featured {
            border-color: rgba(200, 169, 110, .35);
            background: radial-gradient(circle at top right, rgba(200, 169, 110, .16), transparent 52%), var(--card);
        }

        .pricing-tag {
            width: fit-content;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 99px;
            padding: .22rem .7rem;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: rgba(237, 231, 213, .72);
        }

        .price-row {
            display: flex;
            align-items: flex-end;
            gap: .3rem;
        }

        .price-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.3rem;
            color: var(--text);
            line-height: 1;
        }

        .price-period {
            font-size: .82rem;
            color: var(--muted);
            margin-bottom: .3rem;
        }

        .pricing-desc {
            font-size: .86rem;
            color: rgba(237, 231, 213, .55);
            line-height: 1.65;
        }

        .pricing-list {
            margin-top: .2rem;
            padding-left: 1rem;
            display: grid;
            gap: .4rem;
            flex: 1;
        }

        .pricing-list li {
            font-size: .83rem;
            color: rgba(237, 231, 213, .62);
            line-height: 1.5;
        }

        .pricing-list li::marker {
            color: var(--green);
        }

        .pricing-card .btn {
            margin-top: .35rem;
            width: fit-content;
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

        .faq-section {
            padding: 0 2.5rem 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .faq-grid {
            margin-top: 0;
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

        /* ── Page loader ── */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 1200;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 18% 20%, rgba(200, 169, 110, .23), transparent 44%),
                radial-gradient(circle at 85% 80%, rgba(78, 140, 98, .2), transparent 41%),
                linear-gradient(155deg, rgba(21, 19, 16, .95), rgba(9, 8, 6, .97));
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: opacity .45s ease, visibility .45s ease;
        }

        #page-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-wrap {
            display: grid;
            place-items: center;
            gap: .95rem;
        }

        .loader-logo-shell {
            position: relative;
            width: 128px;
            height: 128px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .14);
        }

        .loader-ring-a {
            inset: 0;
            border-top-color: var(--accent);
            border-right-color: rgba(200, 169, 110, .55);
            animation: loaderSpin 1.75s linear infinite;
        }

        .loader-ring-b {
            inset: 12px;
            border-left-color: var(--green);
            border-bottom-color: rgba(78, 140, 98, .6);
            animation: loaderSpinReverse 1.25s linear infinite;
        }

        .loader-logo-box {
            position: relative;
            z-index: 2;
            width: 66px;
            height: 66px;
            border-radius: 16px;
            background: linear-gradient(145deg, #5f9f74, var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 35px rgba(0, 0, 0, .38), inset 0 1px 0 rgba(255, 255, 255, .2);
            animation: logoBreath 1.55s ease-in-out infinite;
        }

        .loader-logo-svg {
            width: 32px;
            height: 32px;
            fill: none;
            stroke: #fff;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 86;
            stroke-dashoffset: 86;
            animation: logoDraw 1.15s ease-in-out infinite alternate;
        }

        .loader-caption {
            font-size: .74rem;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(237, 231, 213, .62);
            text-align: center;
        }

        @keyframes loaderSpin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes loaderSpinReverse {
            to {
                transform: rotate(-360deg);
            }
        }

        @keyframes logoBreath {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-4px) scale(1.05);
            }
        }

        @keyframes logoDraw {
            from {
                stroke-dashoffset: 86;
                opacity: .74;
            }

            to {
                stroke-dashoffset: 0;
                opacity: 1;
            }
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
                display: none;
            }

            .mobile-menu-btn {
                display: inline-flex;
            }

            .mobile-nav {
                display: flex;
            }

            .brand-name {
                font-size: 1.15rem;
            }

            #hero {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding-top: 7rem;
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .hero-visual {
                display: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .seo-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            nav#navbar {
                padding: 1rem 1.25rem;
                gap: .65rem;
            }

            .mobile-nav {
                top: 68px;
                left: .75rem;
                right: .75rem;
            }

            .brand-name {
                font-size: 1.05rem;
            }

            .brand-icon {
                width: 30px;
                height: 30px;
            }

            .loader-logo-shell {
                width: 104px;
                height: 104px;
            }

            .loader-ring-b {
                inset: 10px;
            }

            .loader-logo-box {
                width: 56px;
                height: 56px;
                border-radius: 14px;
            }

            .loader-logo-svg {
                width: 27px;
                height: 27px;
            }

            #hero {
                padding: 6.5rem 1.25rem 3rem;
            }

            .hero-sub {
                max-width: 100%;
                margin-bottom: 2rem;
            }

            .hero-cta {
                gap: .75rem;
            }

            .hero-cta .btn,
            .cta-btns .btn {
                width: 100%;
                justify-content: center;
            }

            .hero-stat-row {
                margin-top: 2rem;
                padding-top: 1.5rem;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .hero-stat {
                min-width: calc(50% - .5rem);
            }

            .stat-divider {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            #features,
            #cta,
            .faq-section,
            .seo-section,
            #pricing {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .pricing-card .btn {
                width: 100%;
                justify-content: center;
            }

            #cta {
                margin: 2rem 1.25rem 3rem;
                padding-top: 3rem;
                padding-bottom: 3rem;
            }

            .cta-sub {
                margin-bottom: 1.75rem;
            }

            .footer-links {
                gap: 1rem;
                flex-wrap: wrap;
            }

            footer {
                padding: 1.5rem 1.25rem;
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 420px) {
            nav#navbar {
                padding: .9rem .9rem;
            }

            .mobile-nav {
                top: 64px;
                left: .55rem;
                right: .55rem;
            }

            .brand-name {
                font-size: .98rem;
            }

            .hero-stat {
                min-width: 100%;
            }

            .hero-title {
                font-size: clamp(2.2rem, 11vw, 2.8rem);
            }
        }
    </style>
    <noscript>
        <style>
            #page-loader {
                display: none;
            }
        </style>
    </noscript>
</head>

<body>

    <div id="page-loader" role="status" aria-live="polite" aria-label="Loading Expenio">
        <div class="loader-wrap">
            <div class="loader-logo-shell" aria-hidden="true">
                <span class="loader-ring loader-ring-a"></span>
                <span class="loader-ring loader-ring-b"></span>
                <div class="loader-logo-box">
                    <svg class="loader-logo-svg" viewBox="0 0 24 24">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
            </div>
            <div class="loader-caption">Preparing your dashboard</div>
        </div>
    </div>

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

        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#pricing">Pricing</a>
            <a href="#about">About</a>
        </div>

        <div class="nav-auth">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-ghost"
                        style="padding:.45rem .95rem;font-size:.82rem">
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

        <button id="mobile-menu-btn" class="mobile-menu-btn" type="button" aria-label="Toggle navigation"
            aria-controls="mobile-nav" aria-expanded="false">
            <svg class="icon-menu" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <svg class="icon-close" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </nav>

    <div id="mobile-nav" class="mobile-nav" aria-hidden="true">
        <div class="mobile-nav-links">
            <a href="#features">Features</a>
            <a href="#pricing">Pricing</a>
            <a href="#about">About</a>
        </div>
        @if (Route::has('login'))
            <div class="mobile-nav-auth">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-ghost">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>


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
                    Expenio – Smart Expense Tracker & Budget Manager
                </h1>

                <p class="hero-sub anim-fade-up anim-delay-2">
                    Expenio is your all-in-one expense tracker for budget management and personal finance, helping you
                    track daily expenses, monitor spending habits, and stay in control of your money.
                </p>

                <div class="hero-cta anim-fade-up anim-delay-3">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                            Start for free
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
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

    <section id="about" style="padding: 1rem 2.5rem 0; max-width: 1200px; margin: 0 auto;">
        <div style="text-align:center; margin-bottom:1rem;">
            <div class="section-label">Expense tracker guide</div>
            <h2 class="section-title" style="max-width:620px;margin:0 auto .75rem">
                Track Your Daily Expenses Easily
            </h2>
            <p class="section-sub" style="margin:0 auto;max-width:640px;">
                Expenio helps you record every transaction in seconds, organize spending by category, and manage your
                budget with clear insights so you can improve cash flow, reduce unnecessary costs, and build better
                personal finance habits every day.
            </p>
        </div>
    </section>

    <section class="seo-section">
        <div style="text-align:center; margin-bottom:1rem;">
            <div class="section-label">Money management made practical</div>
            <h2 class="section-title" style="max-width:760px;margin:0 auto .75rem;">
                A complete expense tracker for daily spending, monthly budgeting, and long-term financial planning
            </h2>
            <p class="section-sub" style="margin:0 auto;max-width:760px;">
                Expenio combines expense tracking, income monitoring, and budget planning in one clean dashboard so
                you can make smarter money decisions without spreadsheets or manual bookkeeping.
            </p>
        </div>

        <div class="seo-grid">
            <article class="seo-card">
                <h3 class="seo-title">Designed for real life money goals</h3>
                <p class="seo-copy">
                    Whether you are a student managing pocket money, a freelancer tracking variable income, or a family
                    planning monthly expenses, Expenio gives you a fast way to record every transaction and understand
                    spending patterns.
                </p>
                <p class="seo-copy">
                    Instead of guessing where money goes, you get category-level visibility, budget alerts, and clear
                    summaries that help you reduce waste and improve savings month after month.
                </p>
                <ul class="seo-points">
                    <li>Track daily expenses with categories like food, transport, bills, shopping, and health.</li>
                    <li>Compare your planned budget with actual spending in real time.</li>
                    <li>Monitor income and expenses together to understand your cash flow.</li>
                    <li>Review monthly reports to improve budgeting and build better financial habits.</li>
                </ul>
            </article>

            <article class="seo-card seo-card-highlight">
                <h3 class="seo-title">Why users keep coming back</h3>
                <p class="seo-copy">
                    Expenio is focused on speed, clarity, and consistency. The interface stays simple, while analytics
                    remain detailed enough for serious personal finance tracking.
                </p>

                <div class="seo-metrics">
                    <div class="metric-chip">
                        <div class="metric-value">3 min</div>
                        <div class="metric-label">Average setup time</div>
                    </div>
                    <div class="metric-chip">
                        <div class="metric-value">30+ days</div>
                        <div class="metric-label">Trend visibility window</div>
                    </div>
                    <div class="metric-chip">
                        <div class="metric-value">100%</div>
                        <div class="metric-label">User-controlled categories</div>
                    </div>
                </div>
            </article>
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
                <div class="feature-title">Smart Expense Analytics</div>
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
                <div class="feature-title">Budget Planning System</div>
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
                <div class="feature-title">Income & Expense Tracking</div>
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
                <div class="feature-title">Financial Reports</div>
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

    <section id="pricing">
        <div style="text-align:center; margin-bottom:1rem;">
            <div class="section-label">Simple pricing</div>
            <h2 class="section-title" style="max-width:620px;margin:0 auto .75rem;">
                Start free today and scale your budget workflow as you grow
            </h2>
            <p class="section-sub" style="margin:0 auto;max-width:700px;">
                Expenio is built to be accessible for everyone. Begin with the free expense tracker, then move to
                advanced workflows when you need deeper automation and reporting.
            </p>
        </div>

        <div class="pricing-grid">
            <article class="pricing-card">
                <div class="pricing-tag">Starter</div>
                <div class="price-row">
                    <div class="price-amount">INR 0</div>
                    <div class="price-period">per month</div>
                </div>
                <p class="pricing-desc">
                    Perfect for individuals who want a reliable daily expense tracker and budget manager without any
                    upfront cost.
                </p>
                <ul class="pricing-list">
                    <li>Unlimited income and expense entries</li>
                    <li>Custom categories and monthly budgets</li>
                    <li>Dashboard insights and trend snapshots</li>
                    <li>Basic report exports</li>
                </ul>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-ghost">Create free account</a>
                @endif
            </article>

            <article class="pricing-card featured">
                <div class="pricing-tag">Growth (Coming soon)</div>
                <div class="price-row">
                    <div class="price-amount">Early access</div>
                </div>
                <p class="pricing-desc">
                    For users who want deeper analytics, richer reports, and smarter planning features for long-term
                    financial control.
                </p>
                <ul class="pricing-list">
                    <li>Advanced monthly and yearly financial reports</li>
                    <li>Automated budget alerts and anomaly detection</li>
                    <li>Category performance insights and benchmarks</li>
                    <li>Priority support and roadmap previews</li>
                </ul>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Join early access</a>
                @endif
            </article>
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

    <section class="faq-section">
        <div style="text-align:center; margin-bottom:1.75rem;">
            <div class="section-label">FAQ</div>
            <h2 class="section-title" style="margin:0 auto .75rem;max-width:560px;">
                Frequently Asked Questions
            </h2>
            <p class="section-sub" style="margin:0 auto;max-width:720px;">
                Answers to common questions about using Expenio as your daily expense tracker, monthly budget planner,
                and personal finance dashboard.
            </p>
        </div>

        <div class="features-grid faq-grid">
            <div class="feature-card">
                <div class="feature-title">What is Expenio?</div>
                <div class="feature-desc">Expenio is a smart expense tracker and budget management app that helps you
                    organize daily spending, monitor income, and improve your personal finance decisions.</div>
            </div>

            <div class="feature-card">
                <div class="feature-title">How can I track my expenses?</div>
                <div class="feature-desc">You can quickly add transactions, assign categories, and review real-time
                    dashboards to track expenses, compare budgets, and understand where your money goes.</div>
            </div>

            <div class="feature-card">
                <div class="feature-title">Is Expenio free?</div>
                <div class="feature-desc">Yes, Expenio offers a free plan so you can start tracking expenses and
                    managing
                    budgets right away, with options to upgrade as your needs grow.</div>
            </div>

            <div class="feature-card">
                <div class="feature-title">Can I set monthly budgets by category?</div>
                <div class="feature-desc">Yes, you can define budget limits for categories like food, travel,
                    shopping, and bills, then monitor progress through visual budget bars and trend summaries.</div>
            </div>

            <div class="feature-card">
                <div class="feature-title">Can I export my finance reports?</div>
                <div class="feature-desc">Yes, Expenio supports report exports so you can review monthly performance,
                    share summaries with your accountant, or keep records for planning and audits.</div>
            </div>

            <div class="feature-card">
                <div class="feature-title">Is my data secure in Expenio?</div>
                <div class="feature-desc">Your financial information is protected using encryption and secure access
                    controls. Expenio is designed to keep your expense and income data private.</div>
            </div>
        </div>
    </section>


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

    <script>
        (function() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;

            let isHidden = false;
            const hardTimeoutMs = 15000;

            const showLoader = function() {
                isHidden = false;
                loader.classList.remove('is-hidden');
                loader.setAttribute('aria-hidden', 'false');
            };

            const hideLoader = function() {
                if (isHidden) return;

                isHidden = true;
                loader.classList.add('is-hidden');
                loader.setAttribute('aria-hidden', 'true');
            };

            if (document.readyState === 'complete') {
                window.requestAnimationFrame(hideLoader);
            } else {
                window.addEventListener('load', hideLoader, {
                    once: true
                });
            }

            window.setTimeout(hideLoader, hardTimeoutMs);

            document.addEventListener('click', function(event) {
                const link = event.target.closest('a[href]');
                if (!link) {
                    return;
                }

                if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event
                    .shiftKey || event.altKey) {
                    return;
                }

                if (link.target === '_blank' || link.hasAttribute('download')) {
                    return;
                }

                const href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
                    return;
                }

                const nextUrl = new URL(link.href, window.location.href);
                if (nextUrl.origin !== window.location.origin) {
                    return;
                }

                showLoader();
            });

            document.addEventListener('submit', function(event) {
                const form = event.target;
                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                showLoader();
            });
        })();

        (function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileNav = document.getElementById('mobile-nav');

            if (!menuBtn || !mobileNav) return;

            const closeMenu = function() {
                mobileNav.classList.remove('is-open');
                mobileNav.setAttribute('aria-hidden', 'true');
                menuBtn.setAttribute('aria-expanded', 'false');
            };

            const openMenu = function() {
                mobileNav.classList.add('is-open');
                mobileNav.setAttribute('aria-hidden', 'false');
                menuBtn.setAttribute('aria-expanded', 'true');
            };

            menuBtn.addEventListener('click', function() {
                const isOpen = mobileNav.classList.contains('is-open');
                if (isOpen) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            mobileNav.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    closeMenu();
                });
            });

            document.addEventListener('click', function(event) {
                if (!mobileNav.classList.contains('is-open')) return;

                const clickedInsideMenu = mobileNav.contains(event.target);
                const clickedMenuButton = menuBtn.contains(event.target);
                if (!clickedInsideMenu && !clickedMenuButton) {
                    closeMenu();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 900) {
                    closeMenu();
                }
            });
        })();
    </script>

</body>

</html>
