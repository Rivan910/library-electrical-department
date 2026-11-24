<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('images/Logo_Indocement.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/Logo_Indocement.png') }}?v=3">

    <title>@yield('title', 'Workshop Technical Library') - Electrical Department</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EEF3F9;
            color: #0F172A;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
            align-items: stretch;
        }

        /* =========================================================
           LEFT SIDEBAR
        ========================================================= */
        .wtl-sidebar {
            width: 248px;
            min-width: 248px;
            background: linear-gradient(180deg, #113D73 0%, #0A294E 55%, #071D38 100%);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            height: 100vh;
            align-self: flex-start;
            z-index: 40;
            box-shadow: 4px 0 24px rgba(7, 29, 56, 0.18);
            overflow: hidden;
        }

        .wtl-brand {
            padding: 18px 18px 14px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .wtl-brand-logo {
            width: 72px;
            height: 80px;
            margin: 0 auto 10px;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 6px 8px;
        }

        .wtl-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .wtl-brand-title {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.22;
            letter-spacing: -0.01em;
            color: #FFFFFF;
        }

        .wtl-brand-sub {
            margin: 4px 0 0;
            font-size: 11px;
            font-weight: 500;
            color: rgba(219, 234, 254, 0.78);
            letter-spacing: 0.04em;
        }

        .wtl-nav {
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: relative;
            z-index: 3;
            flex-shrink: 0;
        }

        .wtl-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(226, 232, 240, 0.85);
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .wtl-nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }

        .wtl-nav-link.is-active {
            background: linear-gradient(90deg, #1976D2 0%, #2196F3 100%);
            color: #FFFFFF;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(25, 118, 210, 0.38);
        }

        .wtl-nav-link i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .wtl-sidebar-bottom {
            position: relative;
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .wtl-sidebar-art {
            position: relative;
            width: 100%;
            flex: 1;
            min-height: 90px;
            overflow: hidden;
        }

        .wtl-sidebar-art img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: 0.75;
            display: block;
        }

        .wtl-sidebar-art::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                #092547 0%,
                rgba(9, 37, 71, 0.25) 30%,
                rgba(7, 29, 56, 0.35) 70%,
                #071D38 100%
            );
            z-index: 1;
        }

        .wtl-sidebar-footer {
            position: relative;
            z-index: 2;
            padding: 8px 14px 12px;
            text-align: center;
            font-size: 10.5px;
            line-height: 1.4;
            color: rgba(203, 213, 225, 0.72);
            background: #071D38;
            flex-shrink: 0;
        }

        .wtl-sidebar-footer strong {
            display: block;
            color: rgba(241, 245, 249, 0.9);
            font-weight: 600;
        }

        /* =========================================================
           MAIN CONTENT AREA
        ========================================================= */
        .wtl-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: #EEF3F9;
            overflow-x: hidden;
        }

        /* Mobile Topbar */
        .wtl-mobile-bar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #0F396B;
            color: #FFFFFF;
        }

        .wtl-mobile-btn {
            background: rgba(255, 255, 255, 0.12);
            border: 0;
            color: #FFFFFF;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
        }

        .wtl-overlay {
            display: none;
        }

        @media (max-width: 960px) {
            .wtl-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .wtl-sidebar.is-open {
                transform: translateX(0);
            }

            .wtl-mobile-bar {
                display: flex;
            }

            .wtl-overlay.is-open {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                z-index: 35;
            }
        }
    </style>
</head>

<body>
    <div class="wtl-mobile-bar">
        <div style="display:flex;align-items:center;gap:10px;font-weight:800;font-size:15px;">
            <i class="fas fa-book-open"></i>
            <span>Workshop Technical Library</span>
        </div>
        <button type="button" class="wtl-mobile-btn" id="mobileToggleBtn" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="wtl-overlay" id="mobileOverlay"></div>

    <div class="app-shell">
        <!-- LEFT SIDEBAR -->
        <aside class="wtl-sidebar" id="wtlSidebar">
            <div>
                <div class="wtl-brand">
                    <div class="wtl-brand-logo">
                        <img src="{{ asset('images/logo-indocement-sidebar.png') }}?v=1" alt="Logo Indocement">
                    </div>
                    <h1 class="wtl-brand-title">Workshop<br>Technical Library</h1>
                    <p class="wtl-brand-sub">Find &bull; Access &bull; Use</p>
                </div>

                <nav class="wtl-nav">
                    <a href="{{ route('dashboard') }}" class="wtl-nav-link is-active">
                        <i class="fas fa-th-large"></i>
                        <span>Library</span>
                    </a>
                    <a href="#add-document" onclick="openAddModal(); return false;" class="wtl-nav-link">
                        <i class="far fa-file-alt"></i>
                        <span>Add Document</span>
                    </a>
                    <a href="#rack-filter" onclick="document.getElementById('selectRack').focus(); return false;" class="wtl-nav-link">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Browse by Rack</span>
                    </a>
                    <a href="#reports" class="wtl-nav-link">
                        <i class="far fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <a href="#settings" class="wtl-nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </nav>
            </div>

            <div class="wtl-sidebar-bottom">
                <div class="wtl-sidebar-art">
                    <img src="{{ asset('images/workshop-electrical-p611.jpg') }}?v=4" alt="Workshop Electrical Department P611">
                </div>
                <div class="wtl-sidebar-footer">
                    <strong>ITP Workshop</strong>
                    Technical Library System<br>
                    v1.0.0
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="wtl-main">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobileToggleBtn');
            const sidebar = document.getElementById('wtlSidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (btn && sidebar && overlay) {
                btn.addEventListener('click', function () {
                    sidebar.classList.toggle('is-open');
                    overlay.classList.toggle('is-open');
                });
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('is-open');
                    overlay.classList.remove('is-open');
                });
            }
        });
    </script>
</body>

</html>
