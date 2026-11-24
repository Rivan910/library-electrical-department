
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

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body.login-page {
            min-height: 100vh;
            min-height: 100svh;
            overflow-x: hidden;
            background: #101820;
            font-family: 'Montserrat', sans-serif;
        }

        /* BACKGROUND SLIDESHOW */

        .login-backgrounds {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: #101820;
        }

        .login-background {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: fill;
            object-position: center;
            opacity: 0;
            transform: none;
            transition: opacity 0.9s ease-in-out;
            will-change: opacity;
        }

        .login-background.is-active {
            opacity: 1;
            transform: none;
        }

        /* DARK OVERLAY */

        .login-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background: linear-gradient(
                135deg,
                rgba(5, 16, 28, 0.65),
                rgba(5, 16, 28, 0.36),
                rgba(0, 0, 0, 0.58)
            );
        }

        /* MAIN CONTENT */

        .login-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            width: 100%;
            min-height: 100vh;
            min-height: 100svh;
            padding: 12px 20px;
        }

        /* BRAND */

        .login-brand {
            width: 100%;
            text-align: center;
            color: #fff;
        }

        /* INDOCEMENT LOGO */

        .login-logo {
            display: block;
            width: 250px;
            height: 250px;
            object-fit: contain;
            padding: 0;
            margin: 0 auto 8px;
            border: none;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            filter: drop-shadow(
                0 5px 12px rgba(0, 0, 0, 0.35)
            );
            flex-shrink: 0;
        }

        /* TITLE */

        .login-title {
            margin: 0;
            color: #fff;
            font-size: clamp(30px, 4vw, 50px);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.3px;
            text-shadow: 0 4px 18px rgba(0, 0, 0, 0.6);
        }

        .login-subtitle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-top: 8px;
        }

        .login-subtitle-line {
            width: 48px;
            height: 2px;
            background: rgba(255, 255, 255, 0.85);
        }

        .login-subtitle-text {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 6px;
        }

        /* LOGIN CARD */

        .login-card {
            width: 100%;
            max-width: 480px;
            padding: 26px 30px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 22px;
            background: rgba(10, 18, 28, 0.68);
            -webkit-backdrop-filter: blur(18px);
            backdrop-filter: blur(18px);
            box-shadow:
                0 24px 60px rgba(0, 0, 0, 0.32),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        /* RESPONSIVE: MOBILE */

        @media (max-width: 520px) {
            .login-content {
                gap: 24px;
                padding: 26px 16px;
            }

            .login-logo {
                width: 170px;
                height: 170px;
                margin-bottom: 6px;
            }

            .login-title {
                font-size: clamp(28px, 3vw, 42px);
                letter-spacing: -0.8px;
            }

            .login-subtitle {
                gap: 12px;
                margin-top: 6px;
            }

            .login-subtitle-line {
                width: 30px;
            }

            .login-subtitle-text {
                font-size: 11px;
                letter-spacing: 4px;
            }

            .login-card {
                padding: 22px 28px;
                border-radius: 18px;
            }
        }

        /* RESPONSIVE: SHORT DESKTOP SCREENS */

        @media (max-height: 700px) and (min-width: 521px) {
            .login-content {
                padding-top: 20px;
                padding-bottom: 20px;
                gap: 18px;
            }

            .login-logo {
                width: 92px;
                height: 92px;
                margin-bottom: 10px;
            }

            .login-title {
                font-size: clamp(28px, 3.5vw, 42px);
            }

            .login-card {
                padding-top: 26px;
                padding-bottom: 26px;
            }
        }

        /* ACCESSIBILITY */

        @media (prefers-reduced-motion: reduce) {
            .login-background {
                transition: none;
                transform: none;
            }
        }
    </style>
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
