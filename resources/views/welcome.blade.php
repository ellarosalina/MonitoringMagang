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


        /* =====================================================
           NAVBAR
        ===================================================== */

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


        /* =====================================================
           HERO
           DESKTOP / LAPTOP - TETAP
        ===================================================== */

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


        /* =====================================================
           LOGO
        ===================================================== */

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


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            position: absolute;
            bottom: 15px;
            width: 100%;

            text-align: center;

            font-size: 12px;
            color: rgba(255, 255, 255, .75);
        }


        /* =====================================================
           TABLET
           501px - 850px
        ===================================================== */

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


        /* =====================================================
           HP
           KHUSUS <= 500px
        ===================================================== */

        @media (max-width: 500px) {

            /*
             * NAVBAR HP
             */

            .navbar {
                padding: 12px 12px;
            }

            .brand {
                font-size: 16px;
                gap: 6px;
            }

            .brand img {
                width: 34px;
                height: 34px;
            }

            .nav-buttons {
                gap: 6px;
            }

            .nav-buttons a {
                padding: 8px 11px;
                font-size: 11px;
                border-radius: 8px;
            }


            /*
             * HERO HP
             *
             * Dibuat vertikal seperti sebelumnya.
             * Logo turun ke bawah.
             */

            .hero {
                height: auto;

                /*
                 * Jangan pakai min-height 100vh
                 * supaya isi tidak dipaksa terlalu panjang.
                 */

                min-height: 0;

                margin: 0;

                padding: 45px 18px 80px;

                display: flex;

                flex-direction: column;

                align-items: center;

                justify-content: flex-start;

                gap: 35px;

                text-align: center;
            }


            /*
             * TEXT HP
             */

            .hero-content {
                width: 100%;

                display: flex;

                flex-direction: column;

                align-items: center;
            }

            .subtitle {
                margin-bottom: 14px;

                font-size: 14px;

                line-height: 1.5;

                letter-spacing: 1.8px;
            }

            .hero h1 {
                margin: 0 0 16px;

                font-size: 32px;

                line-height: 1.08;
            }

            .description {
                max-width: 360px;

                margin: 0;

                font-size: 14px;

                line-height: 1.7;
            }


            /*
             * LOGO HP
             *
             * Logo boleh turun ke bawah,
             * tetapi dibuat lebih kecil agar tidak
             * menabrak footer.
             */

            .logo-container {
                width: 100%;

                display: flex;

                justify-content: center;

                align-items: center;

                padding: 0;

                margin: 0;
            }

            .logo-box {
                width: 220px;

                height: 220px;

                padding: 25px;

                border-radius: 28px;

                box-shadow: 0 15px 35px rgba(0, 0, 0, .16);
            }

            .logo-box img {
                width: 100%;

                max-width: 170px;
            }


            /*
             * FOOTER HP
             */

            .footer {
                position: fixed;

                bottom: 8px;

                left: 0;

                width: 100%;

                padding: 0 10px;

                text-align: center;

                font-size: 9px;

                line-height: 1.4;

                z-index: 10;
            }
        }


        /* =====================================================
           HP KECIL
           <= 360px
        ===================================================== */

        @media (max-width: 360px) {

            .navbar {
                padding: 10px;
            }

            .brand {
                font-size: 13px;
                gap: 4px;
            }

            .brand img {
                width: 28px;
                height: 28px;
            }

            .nav-buttons {
                gap: 4px;
            }

            .nav-buttons a {
                padding: 7px 9px;
                font-size: 10px;
            }


            /*
             * HERO
             */

            .hero {
                padding: 38px 14px 75px;

                gap: 28px;
            }


            /*
             * TEXT
             */

            .subtitle {
                font-size: 11px;

                letter-spacing: 1.2px;

                margin-bottom: 10px;
            }

            .hero h1 {
                font-size: 27px;

                line-height: 1.08;

                margin-bottom: 13px;
            }

            .description {
                max-width: 310px;

                font-size: 12px;

                line-height: 1.6;
            }


            /*
             * LOGO
             */

            .logo-box {
                width: 180px;

                height: 180px;

                padding: 20px;

                border-radius: 24px;
            }

            .logo-box img {
                max-width: 140px;
            }


            /*
             * FOOTER
             */

            .footer {
                bottom: 5px;

                font-size: 8px;
            }
        }

    </style>
</head>


<body>

<div class="home">


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <nav class="navbar">

        <a href="{{ url('/') }}" class="brand">

            <img
                src="{{ asset('images/logo-disdik-jabar.png') }}"
                alt="Logo Disdik Jabar"
            >

            <span>
                SIM MagangGTK
            </span>

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


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="hero">


        <!-- TEXT -->

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


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="footer">

        © {{ date('Y') }} SIM MagangGTK —
        Dinas Pendidikan Jawa Barat

    </footer>


</div>

</body>

</html>