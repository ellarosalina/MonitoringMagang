<x-layouts.admin title="Detail Monitoring" subtitle="{{ $penempatan->mahasiswa->user->name }}">

    <a href="{{ route('admin.monitoring.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; Kembali ke daftar</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-lg shadow-sm p-5 lg:col-span-1">
            <h3 class="font-semibold text-gray-700 mb-3">Info Penempatan</h3>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-500">Mahasiswa</dt><dd class="font-medium">{{ $penempatan->mahasiswa->user->name }} ({{ $penempatan->mahasiswa->nim }})</dd></div>
                <div><dt class="text-gray-500">Sekolah</dt><dd class="font-medium">{{ $penempatan->sekolah->nama_sekolah }}</dd></div>
                <div><dt class="text-gray-500">Guru Pamong</dt><dd class="font-medium">{{ $penempatan->guruPamong->user->name }}</dd></div>
                <div><dt class="text-gray-500">Dosen Pembimbing</dt><dd class="font-medium">{{ $penempatan->dosenPembimbing->nama ?? '-' }}</dd></div>
                <div><dt class="text-gray-500">Periode</dt><dd class="font-medium">{{ $penempatan->periode }}</dd></div>
                <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ ucfirst($penempatan->status) }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5 lg:col-span-2">
            <h3 class="font-semibold text-gray-700 mb-3">Progress Magang</h3>
            <div class="flex items-center gap-3 mb-6">
                <div class="flex-1 bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $penempatan->progress_percent }}%"></div>
                </div>
                <span class="font-semibold">{{ $penempatan->progress_percent }}%</span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Kehadiran</h4>
                    <ul class="text-sm space-y-1">
                        <li>Hadir: <strong>{{ $absensiPerStatus['hadir'] }}</strong></li>
                        <li>Izin: <strong>{{ $absensiPerStatus['izin'] }}</strong></li>
                        <li>Sakit: <strong>{{ $absensiPerStatus['sakit'] }}</strong></li>
                        <li>Alpa: <strong>{{ $absensiPerStatus['alpa'] }}</strong></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Logbook</h4>
                    <ul class="text-sm space-y-1">
                        <li>Menunggu: <strong>{{ $logbookPerStatus['menunggu'] }}</strong></li>
                        <li>Disetujui: <strong>{{ $logbookPerStatus['disetujui'] }}</strong></li>
                        <li>Revisi: <strong>{{ $logbookPerStatus['revisi'] }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-lg shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Daftar Logbook</h3>

        <div class="space-y-3">
            @forelse ($logbooks as $logbook)
                <div class="border rounded p-3">
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-sm font-semibold">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</span>
                        <span class="px-2 py-1 text-xs rounded
                            @if($logbook->status_verifikasi == 'disetujui') bg-green-100 text-green-700
                            @elseif($logbook->status_verifikasi == 'revisi') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700
                            @endif">
                            {{ ucfirst($logbook->status_verifikasi) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-700">{{ $logbook->kegiatan }}</p>
                    @if ($logbook->catatan_guru_pamong)
                        <p class="text-xs text-gray-500 mt-1"><strong>Catatan:</strong> {{ $logbook->catatan_guru_pamong }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada logbook.</p>
            @endforelse
        </div>
    </div>

</x-layouts.admin>