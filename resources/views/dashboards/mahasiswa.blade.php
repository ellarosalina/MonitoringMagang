<x-layouts.mahasiswa title="Dashboard" subtitle="">

    {{-- HEADER SELAMAT DATANG --}}
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-white mb-6">
        <h2 class="text-2xl font-bold mb-2">Selamat datang kembali, {{ auth()->user()->name }}! 👋</h2>
        <p class="text-blue-100">Pantau perkembangan harian, ringkasan logbook, dan status kegiatan magangmu secara terorganisir di sini.</p>
    </div>

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