<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Dashboard' }} - SIM Magang GTK</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Mencegah submenu berkedip saat halaman dimuat --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-gray-100"
    x-data="{
        dataMasterOpen: {{ request()->routeIs(
            'admin.sekolah.*',
            'admin.guru-pamong.*',
            'admin.dosen-pembimbing.*',
            'admin.mahasiswa.*'
        ) ? 'true' : 'false' }}
    }"
>

<div class="flex min-h-screen">


    <aside class="w-64 bg-slate-800 text-white flex-shrink-0 flex flex-col">

        {{-- BRAND --}}
        <div class="p-4 text-lg font-bold border-b border-slate-700 flex items-center gap-2">

            <span class="text-blue-400">
                SIM
            </span>

            MagangGTK

        </div>


        {{-- =================================================
             PROFIL ADMIN
        ================================================== --}}
        <div class="p-4 flex items-center gap-3 border-b border-slate-700">

            {{-- Avatar --}}
            <div
                class="w-10 h-10 rounded-full bg-slate-600
                       flex items-center justify-center
                       text-lg font-bold"
            >
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            {{-- Nama --}}
            <div>

                <p class="text-sm font-semibold leading-tight">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-green-400 flex items-center gap-1">

                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>

                    Online

                </p>

            </div>

        </div>


        {{-- NAVIGATION TITLE --}}
        <p class="px-4 pt-4 pb-2 text-xs text-slate-400 uppercase tracking-wide">
            Main Navigation
        </p>


        {{-- =================================================
             MENU
        ================================================== --}}
        <nav class="flex-1 overflow-y-auto">


            {{-- =================================================
                 DASHBOARD
            ================================================== --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm
                       transition-colors duration-150
                       hover:bg-slate-700
                       {{ request()->routeIs('admin.dashboard')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                {{-- Icon Dashboard --}}
                <svg
                    class="w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    />
                </svg>

                Dashboard

            </a>


            {{-- =================================================
                 DATA MASTER
            ================================================== --}}
            <button
                type="button"
                @click="dataMasterOpen = !dataMasterOpen"
                class="w-full flex items-center justify-between
                       px-4 py-3 text-sm
                       transition-colors duration-150
                       hover:bg-slate-700
                       {{ request()->routeIs(
                            'admin.sekolah.*',
                            'admin.guru-pamong.*',
                            'admin.dosen-pembimbing.*',
                            'admin.mahasiswa.*'
                       )
                            ? 'bg-slate-700'
                            : '' }}"
            >

                <span class="flex items-center gap-3">

                    {{-- Icon --}}
                    <svg
                        class="w-5 h-5 flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"
                        />
                    </svg>

                    Data Master

                </span>


                {{-- Arrow --}}
                <svg
                    class="w-4 h-4 flex-shrink-0
                           transition-transform duration-200"
                    :class="dataMasterOpen ? 'rotate-90' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"
                    />
                </svg>

            </button>


    
            <div
                x-show="dataMasterOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="bg-slate-900"
            >

                {{-- SEKOLAH --}}
                <a
                    href="{{ route('admin.sekolah.index') }}"
                    class="flex items-center gap-2 pl-12 pr-4 py-2.5 text-sm
                           transition-colors duration-150
                           hover:bg-slate-700
                           {{ request()->routeIs('admin.sekolah.*')
                                ? 'bg-slate-700 text-blue-400'
                                : 'text-slate-300' }}"
                >

                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>

                    Sekolah

                </a>


                {{-- GURU PAMONG --}}
                <a
                    href="{{ route('admin.guru-pamong.index') }}"
                    class="flex items-center gap-2 pl-12 pr-4 py-2.5 text-sm
                           transition-colors duration-150
                           hover:bg-slate-700
                           {{ request()->routeIs('admin.guru-pamong.*')
                                ? 'bg-slate-700 text-blue-400'
                                : 'text-slate-300' }}"
                >

                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>

                    Guru Pamong

                </a>


                {{-- DOSEN PEMBIMBING --}}
                <a
                    href="{{ route('admin.dosen-pembimbing.index') }}"
                    class="flex items-center gap-2 pl-12 pr-4 py-2.5 text-sm
                           transition-colors duration-150
                           hover:bg-slate-700
                           {{ request()->routeIs('admin.dosen-pembimbing.*')
                                ? 'bg-slate-700 text-blue-400'
                                : 'text-slate-300' }}"
                >

                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>

                    Dosen Pembimbing

                </a>


                {{-- MAHASISWA --}}
                <a
                    href="{{ route('admin.mahasiswa.index') }}"
                    class="flex items-center gap-2 pl-12 pr-4 py-2.5 text-sm
                           transition-colors duration-150
                           hover:bg-slate-700
                           {{ request()->routeIs('admin.mahasiswa.*')
                                ? 'bg-slate-700 text-blue-400'
                                : 'text-slate-300' }}"
                >

                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>

                    Mahasiswa

                </a>

            </div>


            {{-- =================================================
                 PENEMPATAN
            ================================================== --}}
            <a
                href="{{ route('admin.penempatan.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-sm
                       transition-colors duration-150
                       hover:bg-slate-700
                       {{ request()->routeIs('admin.penempatan.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                {{-- Icon --}}
                <svg
                    class="w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                    />
                </svg>

                Penempatan

            </a>
            <a
                href="#"
                class="flex items-center gap-3 px-4 py-3 text-sm
                       transition-colors duration-150
                       hover:bg-slate-700"
            >

                <svg
                    class="w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                </svg>

                Ganti Password

            </a>
            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-left
                           flex items-center gap-3
                           px-4 py-3 text-sm
                           transition-colors duration-150
                           hover:bg-slate-700"
                >

                    <svg
                        class="w-5 h-5 flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>

                    Logout

                </button>

            </form>

        </nav>

    </aside>


    {{-- =====================================================
         KONTEN UTAMA
    ====================================================== --}}
    <div class="flex-1 flex flex-col min-w-0">


        {{-- TOPBAR --}}
        <header
            class="bg-white shadow-sm px-6 py-4
                   flex justify-between items-center"
        >

            <div>

                <h1 class="text-lg font-semibold text-gray-800">
                    {{ $title ?? 'Dashboard' }}
                </h1>

                @if (!empty($subtitle))
                    <p class="text-xs text-gray-400">
                        {{ $subtitle }}
                    </p>
                @endif

            </div>


            <div class="text-sm text-gray-600">

                {{ auth()->user()->name }}

                <span class="text-gray-400">
                    - Admin GTK
                </span>

            </div>

        </header>


        {{-- ISI HALAMAN --}}
        <main class="p-6 flex-1">

            {{ $slot }}

        </main>

    </div>

</div>


{{-- =====================================================
     ALPINE JS
====================================================== --}}
<script
    defer
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
></script>

</body>
</html>