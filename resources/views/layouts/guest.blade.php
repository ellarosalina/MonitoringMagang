<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM MagangGTK') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
        }

        .login-page {
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #0757a8 0%,
                #0878c9 50%,
                #07529b 100%
            );

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px 20px;

            position: relative;
            overflow: hidden;
        }

        /* Lingkaran dekorasi */

        .circle-one {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -120px;
            left: -100px;
        }

        .circle-two {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
            bottom: -180px;
            right: -100px;
        }

        .login-card {
            width: 100%;
            max-width: 900px;
            min-height: 500px;

            background: white;

            border-radius: 24px;

            overflow: hidden;

            display: flex;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.20);

            position: relative;
            z-index: 2;
        }

        /* ============================= */
        /* BAGIAN KIRI                   */
        /* ============================= */

        .login-left {
            width: 50%;

            background: linear-gradient(
                145deg,
                #0757a8,
                #168bd1
            );

            color: white;

            padding: 55px 50px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-wrapper {
            margin-bottom: 30px;
        }

        .logo-disdik {
            width: 190px;
            height: auto;

            display: block;

            object-fit: contain;
        }

        .welcome-label {
            font-size: 13px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 2px;

            color: #dbeeff;

            margin-bottom: 8px;
        }

        .app-title {
            font-size: 34px;

            font-weight: 700;

            line-height: 1.2;

            margin: 0 0 15px;
        }

        .app-description {
            font-size: 15px;

            line-height: 1.7;

            color: #e4f3ff;

            max-width: 350px;

            margin: 0;
        }

        .features {
            margin-top: 30px;

            display: flex;
            flex-direction: column;

            gap: 12px;
        }

        .feature {
            display: flex;
            align-items: center;

            gap: 10px;

            font-size: 13px;

            color: #e5f4ff;
        }

        .feature-dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background: #ffc20e;

            flex-shrink: 0;
        }


        /* ============================= */
        /* BAGIAN KANAN                  */
        /* ============================= */

        .login-right {
            width: 50%;

            padding: 55px 55px;

            display: flex;
            align-items: center;
        }

        .login-form {
            width: 100%;
        }


        /* ============================= */
        /* RESPONSIVE                     */
        /* ============================= */

        @media (max-width: 768px) {

            .login-page {
                padding: 25px 15px;
            }

            .login-card {
                max-width: 500px;

                flex-direction: column;

                min-height: auto;
            }

            .login-left {
                width: 100%;

                padding: 40px 30px;

                text-align: center;

                align-items: center;
            }

            .logo-disdik {
                width: 170px;
                margin: auto;
            }

            .app-title {
                font-size: 28px;
            }

            .app-description {
                max-width: 400px;
            }

            .features {
                text-align: left;
            }

            .login-right {
                width: 100%;

                padding: 40px 30px;
            }
        }
    </style>

</head>


<body>

    <div class="login-page">

        {{-- Background decoration --}}
        <div class="circle-one"></div>
        <div class="circle-two"></div>


        {{-- ================================ --}}
        {{-- CARD UTAMA                       --}}
        {{-- ================================ --}}

        <div class="login-card">


            {{-- ============================== --}}
            {{-- BAGIAN KIRI                    --}}
            {{-- ============================== --}}

            <div class="login-left">

                <div class="logo-wrapper">

                    <img
                        src="{{ asset('images/logo-disdik-jabar.png') }}"
                        alt="Logo Dinas Pendidikan Jawa Barat"
                        class="logo-disdik"></div>
                <div class="welcome-label">Selamat Datang</div>
                <h1 class="app-title">SIM Magang Mahasiswa</h1>
                <p class="app-description">
                    Sistem Informasi Monitoring Magang
                    untuk membantu pengelolaan kegiatan
                    magang mahasiswa secara terintegrasi.
                </p>


                <div class="features">
                    <div class="feature">
                        <span class="feature-dot"></span>Monitoring kegiatan magang</div>
                    <div class="feature">
                        <span class="feature-dot"></span>Pengelolaan absensi dan logbook</div>
                    <div class="feature">
                        <span class="feature-dot"></span>Terintegrasi dengan Disdik Jawa Barat</div>
                </div>
            </div>

            {{-- BAGIAN KANAN --}}

            <div class="login-right">

                <div class="login-form">

                    {{ $slot }}

                </div>

            </div>

        </div>


    </div>

</body>

</html>