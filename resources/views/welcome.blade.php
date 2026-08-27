<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIM Magang Mahasiswa - Disdik Jabar</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .home {
        min-height: 100vh;
        background: linear-gradient(
        180deg,
        #6ec6ed 0%,
        #168bd1 38%,
        #0757a8 100%
);
        color: white;
        overflow: hidden;
        }

        /* NAVBAR */

        .navbar {
            max-width: 1250px;
            margin: auto;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            color: white;
            text-decoration: none;
        }

        .brand img {
            width: 68px;
            height: 58px;
            object-fit: contain;
            transform: scale(1.12);
        }

        .brand-divider {
            width: 1px;
            height: 38px;
            background: rgba(255, 255, 255, .35);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: bold;
            white-space: nowrap;
        }

        .brand-subtitle {
            font-size: 9px;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, .78);
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .nav-buttons a {
            padding: 11px 22px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: .2s ease;
        }

        .nav-buttons a:hover {
            transform: translateY(-2px);
        }

        .login {
            color: white;
            border: 1px solid white;
            background: rgba(255, 255, 255, .04);
        }

        .login:hover {
            background: white;
            color: #0757a8;
        }

        .register {
            background: #ffc20e;
            color: #174a87;
            border: 1px solid #ffc20e;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .12);
        }

        .register:hover {
            background: #ffd447;
        }

        /* HERO */

        .hero {
            max-width: 1250px;
            min-height: calc(100vh - 85px);
            margin: auto;
            padding: 25px 30px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 65px;
        }

        .hero-content {
            width: 56%;
        }

        .subtitle {
            margin-bottom: 15px;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 2.2px;
        }

        .hero h1 {
            margin: 0 0 20px;
            font-size: 54px;
            line-height: 1.08;
            letter-spacing: -1px;
        }

        .hero h1 span {
            color: #ffc20e;
        }

        .description {
            max-width: 580px;
            margin: 0;
            font-size: 16px;
            line-height: 1.7;
            color: #e5f5ff;
        }

        /* LOGO */

        .logo-container {
            width: 44%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-box {
            width: 380px;
            height: 380px;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 60px rgba(0, 40, 90, .25);
            transition: .3s ease;
        }

        .logo-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 70px rgba(0, 40, 90, .30);
        }

        .logo-box img {
            width: 100%;
            max-width: 295px;
            object-fit: contain;
        }

        /* FOOTER */

        .footer {
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, .75);
        }

        /* TABLET */

        @media (max-width: 900px) {

            .navbar {
                padding: 18px 25px;
            }

            .hero {
                min-height: auto;
                padding: 50px 30px 100px;
                flex-direction: column;
                text-align: center;
                gap: 45px;
            }

            .hero-content {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero h1 {
                font-size: 45px;
            }

            .description {
                max-width: 650px;
            }

            .logo-container {
                width: 100%;
            }

            .logo-box {
                width: 320px;
                height: 320px;
            }

        }

        /* HP */

        @media (max-width: 600px) {

            .navbar {
                padding: 13px 15px;
                gap: 10px;
            }

            .brand {
                gap: 8px;
            }

            .brand img {
                width: 48px;
                height: 43px;
                transform: scale(1.1);
            }

            .brand-divider {
                height: 30px;
            }

            .brand-title {
                font-size: 15px;
            }

            .brand-subtitle {
                font-size: 7px;
                letter-spacing: 1px;
            }

            .nav-buttons {
                gap: 6px;
            }

            .nav-buttons a {
                padding: 8px 12px;
                font-size: 11px;
                border-radius: 7px;
            }

            .hero {
                min-height: 0;
                padding: 45px 18px 85px;
                flex-direction: column;
                justify-content: flex-start;
                gap: 38px;
                text-align: center;
            }

            .hero-content {
                width: 100%;
            }

            .subtitle {
                margin-bottom: 13px;
                font-size: 11px;
                letter-spacing: 1.6px;
            }

            .hero h1 {
                margin: 0 0 17px;
                font-size: 32px;
                line-height: 1.08;
            }

            .description {
                max-width: 350px;
                margin: auto;
                font-size: 13px;
                line-height: 1.7;
            }

            .logo-container {
                width: 100%;
            }

            .logo-box {
                width: 245px;
                height: 245px;
                padding: 28px;
                border-radius: 27px;
            }

            .logo-box img {
                max-width: 190px;
            }

            .footer {
                position: fixed;
                bottom: 8px;
                padding: 0 10px;
                font-size: 9px;
                line-height: 1.4;
            }

        }

        /* HP KECIL */

        @media (max-width: 380px) {

            .navbar {
                padding: 10px;
            }

            .brand img {
                width: 40px;
                height: 36px;
            }

            .brand-title {
                font-size: 13px;
            }

            .brand-subtitle {
                display: none;
            }

            .brand-divider {
                height: 25px;
            }

            .nav-buttons {
                gap: 4px;
            }

            .nav-buttons a {
                padding: 7px 9px;
                font-size: 10px;
            }

            .hero {
                padding: 38px 14px 75px;
                gap: 30px;
            }

            .subtitle {
                font-size: 10px;
                letter-spacing: 1.1px;
            }

            .hero h1 {
                font-size: 28px;
                line-height: 1.08;
            }

            .description {
                max-width: 310px;
                font-size: 12px;
                line-height: 1.6;
            }

            .logo-box {
                width: 205px;
                height: 205px;
                padding: 23px;
            }

            .logo-box img {
                max-width: 160px;
            }

            .footer {
                font-size: 8px;
            }

        }

    </style>
</head>

<body>

<div class="home">

    {{-- NAVBAR --}}

    <nav class="navbar">

        <a href="{{ url('/') }}" class="brand">

            <img
                src="{{ asset('images/logo-disdik-jabar.png') }}"
                alt="Logo Disdik Jabar"
            >

            <div class="brand-divider"></div>

            <div class="brand-text">

                <div class="brand-title">
                    SIM Magang Mahasiswa
                </div>

                <div class="brand-subtitle">
                    DINAS PENDIDIKAN JAWA BARAT
                </div>

            </div>

        </a>

        <div class="nav-buttons">

            <a
                href="{{ route('login') }}"
                class="login"
            >
                Masuk
            </a>

            @if (Route::has('register'))

                <a
                    href="{{ route('register') }}"
                    class="register"
                >
                    Daftar
                </a>

            @endif

        </div>

    </nav>

    {{-- HERO --}}

    <section class="hero">

        <div class="hero-content">

            <div class="subtitle">
                DINAS PENDIDIKAN JAWA BARAT
            </div>

            <h1>
                Sistem Informasi<br>
                Monitoring <span>Magang Mahasiswa</span>
            </h1>

            <p class="description">
                Platform digital untuk membantu mahasiswa,
                guru pamong, dan admin dalam mengelola
                kegiatan magang secara terintegrasi,
                mulai dari absensi hingga logbook.
            </p>

        </div>

        <div class="logo-container">

            <div class="logo-box">

                <img
                    src="{{ asset('images/logo-disdik-jabar.png') }}"
                    alt="Logo Disdik Jabar"
                >

            </div>

        </div>

    </section>

    {{-- FOOTER --}}

    <footer class="footer">

        © {{ date('Y') }} SIM Magang Mahasiswa —
        Dinas Pendidikan Jawa Barat

    </footer>

</div>

</body>

</html>