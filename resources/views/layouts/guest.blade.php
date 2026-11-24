<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library Electrical P611') }}</title>

    <!-- Favicon -->
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/Logo_Indocement.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Login CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v=1">
</head>

<body class="login-page antialiased">

    <!-- BACKGROUND SLIDESHOW -->
    <div class="login-backgrounds" aria-hidden="true">

        <img
            src="{{ asset('images/p611-slide-1.jpg') }}?v=1"
            alt="Workshop Electrical Department P611 - Slide 1"
            class="login-background is-active"
            fetchpriority="high">

        <img
            src="{{ asset('images/p611-slide-2.jpg') }}?v=1"
            alt="Workshop Electrical Department P611 - Slide 2"
            class="login-background">

        <img
            src="{{ asset('images/p611-slide-3.jpg') }}?v=1"
            alt="Workshop Electrical Department P611 - Slide 3"
            class="login-background">

    </div>

    <!-- DARK OVERLAY -->
    <div class="login-overlay" aria-hidden="true"></div>

    <!-- MAIN CONTENT -->
    <main class="login-content">

        <!-- LOGO AND TITLE -->
        <header class="login-brand">

            <img
                src="{{ asset('images/indocement.png') }}"
                alt="Logo Indocement"
                class="login-logo">

            <h1 class="login-title">
                Library Electrical P611
            </h1>

            <div class="login-subtitle">
                <span class="login-subtitle-line"></span>

                <span class="login-subtitle-text">
                    ELECTRICAL P611
                </span>

                <span class="login-subtitle-line"></span>
            </div>

        </header>

        <!-- LOGIN FORM -->
        <section class="login-card">
            {{ $slot }}
        </section>

    </main>

    <!-- SLIDESHOW CONTROLLER -->
    <script>
        (() => {
            const slides = Array.from(
                document.querySelectorAll('.login-background')
            );

            if (
                slides.length < 2 ||
                window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches
            ) {
                return;
            }

            let activeIndex = 0;

            window.setInterval(() => {
                slides[activeIndex].classList.remove('is-active');

                activeIndex = (activeIndex + 1) % slides.length;

                slides[activeIndex].classList.add('is-active');
            }, 3000);
        })();

        // Paksa browser HP memuat token CSRF baru jika kembali ke halaman Login lewat tombol Back (bfcache)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>
