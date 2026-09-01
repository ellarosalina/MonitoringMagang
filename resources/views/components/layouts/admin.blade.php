<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - SIM Magang GTK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
</head>

<body class="bg-gray-100 overflow-x-hidden">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0 sticky top-0 h-screen overflow-hidden flex flex-col">

            {{-- LOGO --}}
            <div class="p-4 text-lg font-bold border-b border-slate-700 flex items-center gap-2 flex-shrink-0">
                <span class="text-blue-400">SIM</span>MagangGTK
            </div>

            {{-- PROFILE ADMIN --}}
            <div class="p-4 flex items-center gap-3 border-b border-slate-700 flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-slate-600 flex items-center justify-center text-lg font-bold overflow-hidden flex-shrink-0">
                    @if (auth()->user()->foto)
                        <img
                            src="{{ asset('storage/' . auth()->user()->foto) }}"
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                        >
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-tight truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-green-400 flex items-center gap-1 mt-0.5">
                        <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                        Online
                    </p>
                </div>
            </div>
            {{-- MENU SIDEBAR --}}
            <nav class="flex-1 min-h-0 overflow-hidden py-2">
                {{-- UTAMA --}}
                <div class="px-4 pt-2 pb-1 text-xs text-slate-400 uppercase tracking-wide">
                    Utama
                </div>
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}"
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
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a2 2 0 001 2v-4a1 1 0 011-1h2a1 1 0 011 1v4a2 2 0 001 2m-6 0h6"
                        />
                    </svg>
                    <span>Dashboard</span>
                </a>
                {{-- DATA MASTER --}}
                <div class="px-4 pt-3 pb-1 text-xs text-slate-400 uppercase tracking-wide">
                    Data Master
                </div>
                <a
                    href="{{ route('admin.sekolah.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.sekolah.*') ? 'bg-blue-600' : '' }}"
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
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"
                        />
                    </svg>
                    <span>Sekolah</span>
                </a>
                <a
                    href="{{ route('admin.guru-pamong.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.guru-pamong.*') ? 'bg-blue-600' : '' }}"
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
                            d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0M19 8l2 2-4 4-2-2"
                        />
                    </svg>
                    <span>Guru Pamong</span>
                </a>
                <a
                    href="{{ route('admin.mahasiswa.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-blue-600' : '' }}"
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
                            d="M15 19a4 4 0 00-8 0m4-8a3 3 0 100-6 3 3 0 000 6zm7-1a2 2 0 100-4 2 2 0 000 4zm-1 3a3 3 0 013 3"
                        />
                    </svg>
                    <span>Mahasiswa</span>
                </a>
                {{-- MANAJEMEN --}}
                <div class="px-4 pt-3 pb-1 text-xs text-slate-400 uppercase tracking-wide">
                    Manajemen
                </div>
                <a
                    href="{{ route('admin.penempatan.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.penempatan.*') ? 'bg-blue-600' : '' }}"
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
                            d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 0 0-2-2h-2M9 5a3 3 0 006 0M9 5a2 2 0 012-2h2a2 2 0 012 2m-5 5h.01M9 13h6m-6 4h6"
                        />
                    </svg>
                    <span>Penempatan</span>
                </a>
                <a
                    href="{{ route('admin.monitoring.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-600' : '' }}"
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
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"
                        />
                    </svg>
                    <span>Monitoring</span>
                </a>
                {{-- PENGATURAN --}}
                <div class="px-4 pt-3 pb-1 text-xs text-slate-400 uppercase tracking-wide">
                    Pengaturan
                </div>
                <a
                    href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600' : '' }}"
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
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 2a4 4 0 00-3-3.87m-9 3.87a4 4 0 013-3.87"
                        />
                    </svg>
                    <span>Manajemen User</span>
                </a>
                <a
                    href="{{ route('admin.profil.index') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-slate-700 {{ request()->routeIs('admin.profil.*') ? 'bg-blue-600' : '' }}"
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
                            d="M12 12a5 5 0 100-10 5 5 0 000 10zm-8 9a8 8 0 0116 0"
                        />
                    </svg>
                    <span>Profil</span>
                </a>
                {{-- LOGOUT DISATUKAN DENGAN PENGATURAN --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="border-t border-slate-700 mt-2 pt-2"
                >
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-700"
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
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- KONTEN UTAMA --}}
        <div class="flex-1 min-w-0 flex flex-col">
            {{-- HEADER --}}
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center flex-shrink-0">
                <div class="min-w-0">
                    <h1 class="text-lg font-semibold text-gray-800 truncate">
                        {{ $title ?? 'Dashboard' }}
                    </h1>
                    <p class="text-xs text-gray-400 truncate">
                        {{ $subtitle ?? '' }}
                    </p>
                </div>
                <div class="text-sm text-gray-600 flex-shrink-0">
                    {{ auth()->user()->name }}
                    <span class="text-gray-400">
                        - Admin GTK
                    </span>
                </div>
            </header>

            {{-- ISI HALAMAN --}}
            <main class="flex-1 min-w-0 w-full max-w-full p-6 overflow-x-hidden">
                {{ $slot }}
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        window.choicesInstances = {};
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.searchable-select').forEach(function (el) {
                window.choicesInstances[el.name] = new Choices(el, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
                });
            });
        });
    </script>
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>
</body>
</html>