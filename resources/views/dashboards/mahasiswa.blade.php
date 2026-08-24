<x-layouts.mahasiswa title="Dashboard" subtitle="">

    {{-- HEADER SELAMAT DATANG --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-6 py-5 mb-5">
        <h2 class="text-xl font-bold text-gray-800">
        Selamat datang kembali, {{ auth()->user()->name }}! 👋
    </h2>
    <p class="text-sm text-gray-500 mt-1">
        Pantau perkembangan harian, ringkasan logbook, dan status kegiatan magangmu di sini.
    </p>
    </div>

    @if ($perluAbsenHariIni)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-5">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1">
                <h3 class="font-semibold text-amber-800">
                    Belum Absen Hari Ini
                </h3>

                <p class="text-sm text-amber-700 mt-1">
                    Kamu belum melakukan absensi hari ini.
                </p>
            </div>

            <a
                href="{{ route('mahasiswa.absensi.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-semibold transition"
            >
                Absen Sekarang

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
@endif

    @if ($logbookRevisi > 0)
    <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20h15.6a2 2 0 001.73-2.64l-7.82-13.5a2 2 0 00-3.42 0z" />
                </svg>
            </div>

            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-red-800">
                            Ada Logbook yang Perlu Direvisi
                        </h3>

                        <p class="text-sm text-red-700 mt-1">
                            Kamu memiliki
                            <span class="font-bold">
                                {{ $logbookRevisi }}
                            </span>
                            logbook oleh Guru Pamong untuk diperbaiki.
                        </p>
                    </div>

                    <a
                        href="{{ route('mahasiswa.logbook.index', ['status' => 'revisi']) }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition"
                    >
                        Lihat Revisi

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                @endif
            

    @if (!$penempatan)
        {{-- BELUM ADA PENEMPATAN --}}
        <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">Anda belum memiliki penempatan magang. Hubungi Admin GTK.</div>
    @else

    {{-- KPI --}}
        {{-- HARI MAGANG --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Hari Magang</p>
                <p class="text-3xl font-bold mt-1">{{ $hariMagang }}<span class="text-base font-normal text-gray-500">/ {{ $totalHariKerja }}</span></p>
                <p class="text-xs text-gray-500 mt-1">Hari Kerja</p>
                <p class="text-xs text-green-600 mt-1">↗ {{ ucfirst($penempatan->status) }}</p>
            </div>
            {{-- KEHADIRAN --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Kehadiran</p>
                <p class="text-3xl font-bold mt-1">{{ $persenKehadiran }}%</p>
                <p class="text-xs text-gray-500 mt-1">
                    @if ($persenKehadiran >= 90)
                        Sangat Baik
                    @elseif ($persenKehadiran >= 75)
                        Baik
                    @elseif ($persenKehadiran > 0)
                        Perlu Ditingkatkan
                    @else
                        Belum Ada Data
                    @endif
                </p>
            </div>
            {{-- LOGBOOK --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Logbook</p>
                <p class="text-3xl font-bold mt-1">{{ $logbookDisetujui }}<span class="text-base font-normal text-gray-500">/ {{ $totalLogbook }}</span></p>
                <p class="text-xs text-gray-500 mt-1">Logbook disetujui</p>
            </div>
            {{-- PROGRESS --}}
            <div class="bg-white rounded-lg shadow-sm p-5"><p class="text-xs text-gray-500 uppercase tracking-wide">Progress</p>
                <p class="text-3xl font-bold mt-1">{{ $penempatan->progress_percent }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $penempatan->progress_percent }}%"></div></div>
                <p class="text-xs text-gray-500 mt-2">Progress kegiatan magang</p>
            </div>
        </div>

            {{-- INFORMASI PENEMPATAN --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Informasi Penempatan Magang</h3>
                </div>
                {{-- STATUS --}}
                <span class="px-3 py-1 text-xs rounded-full
                    @if($penempatan->status == 'berjalan')
                        bg-green-100 text-green-700
                    @elseif($penempatan->status == 'selesai')
                        bg-blue-100 text-blue-700
                    @else
                        bg-yellow-100 text-yellow-700
                    @endif
                ">{{ ucfirst($penempatan->status) }}
                </span>
            </div>

            {{-- DETAIL PENEMPATAN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t">
                {{-- SEKOLAH --}}
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Sekolah</p>
                    <p class="font-semibold mt-1">{{ $penempatan->sekolah->nama_sekolah }}</p>
                </div>
                {{-- GURU PAMONG --}}
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Guru Pamong</p>
                    <p class="font-semibold mt-1">{{ $penempatan->guruPamong->user->name }}</p>
                </div>
                {{-- TANGGAL MULAI --}}
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Mulai</p>
                    <p class="font-semibold mt-1">{{ $penempatan->tanggal_mulai->format('d F Y') }}</p>
                </div>
                {{-- TANGGAL SELESAI --}}
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide"> Tanggal Selesai</p>
                    <p class="font-semibold mt-1">{{ $penempatan->tanggal_selesai->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    @endif

    
</x-layouts.mahasiswa>