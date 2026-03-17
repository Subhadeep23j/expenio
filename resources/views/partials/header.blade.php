<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('Expenio_logo.png') }}">

    <title>{{ config('app.name', 'Expenio') }}@hasSection('title')
            – @yield('title')
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        /* ── Design Tokens ── */
        :root {
            --bg: #f6f3ee;
            --surface: #ffffff;
            --sidebar-bg: #0f0e0c;
            --sidebar-tx: #f0ead8;
            --border: #e3ddd4;
            --text: #1a1814;
            --muted: #8c8070;
            --accent: #3d6b4f;
            --accent-lt: #5a9470;
            --danger: #b83a24;
            --gold: #b8892a;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            min-height: 100vh;
        }

        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: 252px;
            background: var(--sidebar-bg);
            color: var(--sidebar-tx);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.25s ease;
        }

        /* ── Nav links ── */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 1.4rem;
            font-size: 0.875rem;
            color: rgba(240, 234, 216, 0.58);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }

        .nav-link:hover {
            color: var(--sidebar-tx);
            background: rgba(255, 255, 255, .05);
            border-left-color: var(--accent-lt);
        }

        .nav-link.active {
            color: var(--sidebar-tx);
            background: rgba(255, 255, 255, .08);
            border-left-color: var(--accent-lt);
            font-weight: 500;
        }

        .nav-section {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: var(--muted);
            padding: 1.1rem 1.4rem 0.3rem;
        }

        /* ── Top bar ── */
        #topbar {
            height: 58px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 1.75rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        /* ── Main wrapper ── */
        #main-wrap {
            margin-left: 252px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #page-content {
            flex: 1;
            padding: 2rem 1.75rem;
        }

        /* Hamburger hidden on desktop */
        #sidebar-toggle {
            display: none;
        }

        /* ── Flash messages ── */
        .flash {
            padding: 0.75rem 1.2rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            border-left: 4px solid;
        }

        .flash-success {
            background: #eaf5ec;
            border-color: #4caf70;
            color: #1e5c30;
        }

        .flash-error {
            background: #fdecea;
            border-color: #e05a42;
            color: #7a2010;
        }

        .flash-warning {
            background: #fef8ea;
            border-color: #e0a830;
            color: #6a4a08;
        }

        .flash-info {
            background: #eaf2fd;
            border-color: #5090e0;
            color: #1a3a7a;
        }

        /* ══════════════════════════════════════════════
           SHARED RESPONSIVE COMPONENT CLASSES
        ══════════════════════════════════════════════ */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text);
        }

        .card-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }

        .card-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
        }

        .card-sub {
            font-size: 0.78rem;
            color: var(--muted);
            margin-top: 0.4rem;
        }

        .card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .grid-chart {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 1.25rem;
        }

        .flex-col-gap {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
        }

        .form-span-2 {
            grid-column: span 2;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.35rem;
        }

        .form-input {
            width: 100%;
            padding: 0.6rem 0.85rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            background: var(--bg);
            color: var(--text);
            transition: border-color 0.15s;
            font-family: inherit;
        }

        .form-input:focus {
            border-color: var(--accent);
            outline: none;
        }

        .type-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .type-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.55rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.82rem;
            transition: all 0.15s;
            background: var(--bg);
            color: var(--text);
        }

        .type-btn.selected {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .btn-submit {
            width: 100%;
            padding: 0.7rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: inherit;
        }

        .btn-submit:hover {
            background: var(--accent-lt);
        }

        .chart-wrap {
            position: relative;
            height: 240px;
        }

        .expense-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }

        .expense-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .expense-info {
            flex: 1;
            min-width: 0;
        }

        .expense-name {
            font-size: 0.875rem;
            color: var(--text);
        }

        .expense-amt {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--danger);
            white-space: nowrap;
        }

        .badge {
            display: inline-block;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-size: 0.65rem;
        }

        .badge-online {
            background: rgba(80, 120, 200, 0.1);
            color: #5078c8;
        }

        .badge-offline {
            background: rgba(184, 137, 42, 0.1);
            color: #b8892a;
        }

        .badge-today {
            background: rgba(61, 107, 79, 0.1);
            color: var(--accent);
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .date-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 2px solid var(--border);
        }

        .date-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
        }

        .date-total {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--danger);
        }

        .del-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            color: var(--muted);
            transition: all 0.15s;
            line-height: 0;
        }

        .del-btn:hover {
            color: var(--danger);
            background: rgba(192, 90, 66, 0.08);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 0;
            color: var(--muted);
        }

        .tx-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
        }

        .tx-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tx-name {
            font-size: 0.82rem;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tx-date {
            font-size: 0.68rem;
            color: var(--muted);
            margin-top: 0.1rem;
        }

        .tx-amt {
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
        }

        /* ══════════════════════════════════════════════
           TABLET (1024px)
        ══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            #sidebar {
                width: 220px;
            }

            #main-wrap {
                margin-left: 220px;
            }
        }

        /* ══════════════════════════════════════════════
           MOBILE (768px) — sidebar hidden, full width
        ══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                width: 252px;
            }

            #sidebar.open {
                transform: translateX(0);
            }

            #main-wrap {
                margin-left: 0 !important;
            }

            #sidebar-toggle {
                display: block;
            }

            #topbar {
                padding: 0 1rem;
                height: 54px;
            }

            #page-content {
                padding: 1.25rem 1rem;
            }

            .topbar-subtitle {
                display: none;
            }

            .topbar-login-link {
                padding: 6px 10px !important;
                font-size: 0.75rem !important;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }

            .grid-4 {
                grid-template-columns: 1fr 1fr;
            }

            .grid-chart {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-span-2 {
                grid-column: span 1;
            }

            .card {
                padding: 1.25rem;
            }

            .card-value {
                font-size: 1.5rem;
            }

            .chart-wrap {
                height: 200px;
            }

            .expense-icon {
                width: 30px;
                height: 30px;
            }

            .expense-name {
                font-size: 0.82rem;
            }

            .expense-amt {
                font-size: 0.82rem;
            }

            .tx-icon {
                width: 28px;
                height: 28px;
            }

            .card-icon {
                width: 30px;
                height: 30px;
            }
        }

        /* ══════════════════════════════════════════════
           SMALL MOBILE (480px) — ultra compact
        ══════════════════════════════════════════════ */
        @media (max-width: 480px) {
            #topbar {
                padding: 0 0.75rem;
                height: 50px;
                gap: 0.5rem;
            }

            #page-content {
                padding: 1rem 0.75rem;
            }

            .topbar-login-link {
                display: none !important;
            }

            .grid-4 {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 1rem;
                border-radius: 10px;
            }

            .card-value {
                font-size: 1.3rem;
            }

            .card-label {
                font-size: 0.65rem;
            }

            .card-sub {
                font-size: 0.7rem;
            }

            .card-title {
                font-size: 0.85rem;
            }

            .card-icon {
                width: 28px;
                height: 28px;
            }

            .chart-wrap {
                height: 180px;
            }

            .form-input {
                padding: 0.55rem 0.75rem;
                font-size: 0.8rem;
            }

            .form-label {
                font-size: 0.75rem;
            }

            .type-btn {
                padding: 0.45rem;
                font-size: 0.75rem;
                gap: 0.35rem;
            }

            .btn-submit {
                padding: 0.6rem;
                font-size: 0.8rem;
            }

            .expense-row {
                gap: 0.5rem;
                padding: 0.5rem 0;
            }

            .expense-icon {
                width: 26px;
                height: 26px;
            }

            .expense-icon svg {
                width: 12px;
                height: 12px;
            }

            .expense-name {
                font-size: 0.75rem;
            }

            .expense-amt {
                font-size: 0.75rem;
            }

            .date-label {
                font-size: 0.75rem;
            }

            .date-total {
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.6rem;
                padding: 0.05rem 0.3rem;
            }

            .tx-row {
                gap: 0.5rem;
                padding: 0.45rem 0;
            }

            .tx-icon {
                width: 24px;
                height: 24px;
            }

            .tx-icon svg {
                width: 12px;
                height: 12px;
            }

            .tx-name {
                font-size: 0.75rem;
            }

            .tx-date {
                font-size: 0.6rem;
            }

            .tx-amt {
                font-size: 0.75rem;
            }

            .del-btn svg {
                width: 12px;
                height: 12px;
            }

            h1.serif {
                font-size: 1rem !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body style="min-height:100vh;">

    <!-- ═══════════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════════ -->
    <aside id="sidebar">

        {{-- Brand --}}
        <div
            style="display:flex; align-items:center; gap:0.75rem; padding:1.25rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.07)">
            <div
                style="width:36px; height:36px; background:var(--accent); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            <div>
                <div class="serif" style="font-size:1.25rem; line-height:1.1; color:var(--sidebar-tx)">Expenio</div>
                <div style="font-size:.6rem;letter-spacing:.13em;text-transform:uppercase;color:var(--muted)">
                    Expense Tracker
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav style="flex:1; overflow-y:auto; padding:0.5rem 0;">

            <div class="nav-section">Overview</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9" />
                    <rect x="14" y="3" width="7" height="5" />
                    <rect x="14" y="12" width="7" height="9" />
                    <rect x="3" y="16" width="7" height="5" />
                </svg>
                Dashboard
            </a>

            <div class="nav-section">Money</div>
            <a href="{{ route('expenses.index') }}"
                class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                Expenses
            </a>
            <a href="{{ route('income.index') }}" class="nav-link {{ request()->routeIs('income.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                </svg>
                Income
            </a>
            <a href="{{ route('budgets.index') }}"
                class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
                Budgets
            </a>

            <div class="nav-section">Insights</div>
            <a href="{{ route('reports.index') }}"
                class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                Reports
            </a>
            <a href="{{ route('categories.index') }}"
                class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                    <line x1="4" y1="22" x2="4" y2="15" />
                </svg>
                Categories
            </a>

            <div class="nav-section">Account</div>
            @auth
                <a href="{{ route('profile.edit') }}"
                    class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Profile
                </a>
                <a href="{{ route('settings.index') }}"
                    class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    Settings
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Login
                </a>
            @endauth

        </nav>

        {{-- User Footer --}}
        <div style="padding:1rem; border-top:1px solid rgba(255,255,255,.07);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                {{-- Avatar --}}
                <div
                    style="width:32px; height:32px; border-radius:50%; background:var(--accent); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:600; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                {{-- Info --}}
                <div style="flex:1; min-width:0; overflow:hidden;">
                    <div
                        style="font-size:0.875rem; font-weight:500; color:var(--sidebar-tx); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <div
                        style="font-size:0.75rem; color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->email ?? '' }}
                    </div>
                </div>
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Sign out"
                        style="color:var(--muted);background:none;border:none;cursor:pointer;padding:4px;line-height:0;border-radius:4px;transition:color .15s;flex-shrink:0;"
                        onmouseover="this.style.color='var(--sidebar-tx)'"
                        onmouseout="this.style.color='var(--muted)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>


    <!-- ═══════════════════════════════════════════
     MAIN WRAPPER
═══════════════════════════════════════════ -->
    <div id="main-wrap">

        {{-- ── Top Bar ── --}}
        <header id="topbar">

            {{-- Mobile hamburger --}}
            <button id="sidebar-toggle"
                onclick="var s=document.getElementById('sidebar'),o=document.getElementById('sidebar-overlay');
                         s.classList.toggle('open'); o.style.display=s.classList.contains('open')?'block':'none';"
                style="color:var(--muted);background:none;border:none;cursor:pointer;padding:4px;border-radius:4px">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>

            {{-- Page heading --}}
            <div style="flex:1;">
                <h1 class="serif"
                    style="font-size:1.25rem; line-height:1.1; font-weight:600; color:var(--text); margin:0;">
                    @yield('page-title', 'Dashboard')
                </h1>
                @hasSection('page-subtitle')
                    <p class="topbar-subtitle" style="font-size:0.75rem; margin:0.15rem 0 0; color:var(--muted);">
                        @yield('page-subtitle')</p>
                @endif
            </div>

            {{-- Slot for page-level CTA buttons --}}
            @yield('topbar-actions')

            {{-- Notification bell --}}
            <button title="Notifications" class="topbar-icon-btn"
                style="color:var(--muted);background:none;border:none;cursor:pointer;
                       padding:6px;border-radius:8px;transition:background .15s"
                onmouseover="this.style.background='var(--border)'" onmouseout="this.style.background='transparent'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </button>

            {{-- Login button (only shown when not authenticated) --}}
            @guest
                <a href="{{ route('login') }}" title="Login" class="topbar-login-link"
                    style="color:var(--accent);background:none;border:1px solid var(--accent);cursor:pointer;
                           padding:6px 12px;border-radius:8px;font-size:0.875rem;text-decoration:none;transition:background .15s"
                    onmouseover="this.style.background='var(--accent)'; this.style.color='white'"
                    onmouseout="this.style.background='transparent'; this.style.color='var(--accent)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="vertical-align:middle; margin-right:4px;">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Login
                </a>
            @endguest

        </header>

        {{-- ── Flash Messages ── --}}
        @if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
            <div style="padding: 1.25rem 1.75rem 0;">
                @if (session('success'))
                    <div class="flash flash-success">✓ &nbsp;{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="flash flash-error">✕ &nbsp;{{ session('error') }}</div>
                @endif
                @if (session('warning'))
                    <div class="flash flash-warning">⚠ &nbsp;{{ session('warning') }}</div>
                @endif
                @if (session('info'))
                    <div class="flash flash-info">ℹ &nbsp;{{ session('info') }}</div>
                @endif
                @if ($errors->any())
                    <div class="flash flash-error">
                        @foreach ($errors->all() as $error)
                            <div>✕ &nbsp;{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
