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

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v=1">
    @stack('styles')
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
