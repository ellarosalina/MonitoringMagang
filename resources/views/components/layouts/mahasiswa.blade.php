<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - SIM Magang GTK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0 flex flex-col">

            <div class="p-4 text-lg font-bold border-b border-slate-700 flex items-center gap-2">
                <span class="text-blue-400">SIM</span>MagangGTK
            </div>

            <div class="p-4 flex items-center gap-3 border-b border-slate-700">
                <div class="w-10 h-10 rounded-full bg-slate-600 flex items-center justify-center text-lg font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-green-400 flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span> Online
                    </p>
                </div>
            </div>

            <p class="px-4 pt-4 pb-2 text-xs text-slate-400 uppercase tracking-wide">Main Navigation</p>

            <nav class="flex-1 overflow-y-auto">

                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-700 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>

                <a href="{{ route('mahasiswa.absensi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-700 {{ request()->routeIs('mahasiswa.absensi.*') ? 'bg-blue-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Absensi
                </a>

                <a href="{{ route('mahasiswa.logbook.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-700 {{ request()->routeIs('mahasiswa.logbook.*') ? 'bg-blue-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Logbook
                </a>

                <a href="{{ route('mahasiswa.profil.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-700 {{ request()->routeIs('mahasiswa.profil.*') ? 'bg-blue-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>

            </nav>
        </aside>

        <div class="flex-1 flex flex-col">

            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-gray-400">{{ $subtitle ?? '' }}</p>
                </div>
                <div class="text-sm text-gray-600">
                    {{ auth()->user()->name }} <span class="text-gray-400">- Mahasiswa</span>
                </div>
            </header>

            <main class="p-6 flex-1">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>
</html>