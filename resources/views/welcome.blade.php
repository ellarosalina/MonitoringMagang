<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIM MagangGTK - Disdik Jabar</title>

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
            background: linear-gradient(135deg, #0757a8, #168bd1);
            color: white;
            overflow: hidden;
        }

        /* NAVBAR */
        .navbar {
            max-width: 1200px;
            margin: auto;
            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;

            color: white;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        .brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .nav-buttons a {
            padding: 10px 22px;
            border-radius: 8px;

            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .login {
            color: white;
            border: 1px solid white;
        }

        .login:hover {
            background: white;
            color: #0757a8;
        }

        .register {
            background: #ffc20e;
            color: #174a87;
        }

        .register:hover {
            background: #ffd447;
        }

        /* HERO */
        .hero {
            max-width: 1200px;
            height: calc(100vh - 85px);
            margin: auto;
            padding: 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
        }

        .hero-content {
            width: 55%;
        }

        .subtitle {
            margin-bottom: 15px;

            font-size: 15px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .hero h1 {
            margin: 0 0 20px;

            font-size: 52px;
            line-height: 1.1;
        }

        .hero h1 span {
            color: #ffc20e;
        }

        .description {
            max-width: 560px;

            font-size: 16px;
            line-height: 1.7;

            color: #e5f5ff;
        }

        /* LOGO */
        .logo-container {
            width: 40%;

            display: flex;
            justify-content: center;
        }

        .logo-box {
            width: 350px;
            height: 350px;

            padding: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: white;
            border-radius: 30px;

            box-shadow: 0 20px 50px rgba(0, 0, 0, .18);
        }

        .logo-box img {
            width: 100%;
            max-width: 270px;
        }

        /* FOOTER */
        .footer {
            position: absolute;
            bottom: 15px;
            width: 100%;

            text-align: center;

            font-size: 12px;
            color: rgba(255, 255, 255, .75);
        }

        /* RESPONSIVE */
        @media (max-width: 850px) {

            .hero {
                height: auto;
                min-height: calc(100vh - 85px);

                flex-direction: column;
                text-align: center;

                padding-top: 40px;
                padding-bottom: 60px;
            }

            .hero-content,
            .logo-container {
                width: 100%;
            }

            .hero-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero h1 {
                font-size: 40px;
            }

            .logo-box {
                width: 280px;
                height: 280px;
            }
        }

        @media (max-width: 500px) {

            .brand {
                font-size: 16px;
            }

            .brand img {
                width: 38px;
                height: 38px;
            }

            .nav-buttons a {
                padding: 8px 12px;
                font-size: 12px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .description {
                font-size: 14px;
            }

            .logo-box {
                width: 240px;
                height: 240px;
            }
        }
    </style>
</head>

<body>

<div class="home">

    <!-- NAVBAR -->
    <nav class="navbar">

        <a href="{{ url('/') }}" class="brand">

            <img
                src="{{ asset('images/logo-disdik-jabar.png') }}"
                alt="Logo Disdik Jabar"
            >

            <span>SIM MagangGTK</span>

        </a>

        <div class="nav-buttons">

            <a href="{{ route('login') }}" class="login">
                Masuk
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="register">
                    Daftar
                </a>
            @endif

        </div>

    </nav>


    <!-- HERO -->
    <section class="hero">

        <div class="hero-content">

            <div class="subtitle">
                DINAS PENDIDIKAN JAWA BARAT
            </div>

            <h1>
                Sistem Informasi<br>
                Monitoring <span>MagangGTK</span>
            </h1>

            <p class="description">
                Platform digital untuk membantu mahasiswa,
                guru pamong, dan admin dalam mengelola
                kegiatan magang secara terintegrasi,
                mulai dari absensi hingga logbook.
            </p>

        </div>


        <!-- LOGO -->
        <div class="logo-container">

            <div class="logo-box">

                <img
                    src="{{ asset('images/logo-disdik-jabar.png') }}"
                    alt="Logo Disdik Jabar"
                >

            </div>

        </div>

    </section>


    <!-- FOOTER -->
    <footer class="footer">

        © {{ date('Y') }} SIM MagangGTK —
        Dinas Pendidikan Jawa Barat

    </footer>

</div>

</body>
</html>