<x-layouts.guru-pamong title="Mahasiswa Bimbingan" subtitle="Daftar mahasiswa yang Anda bimbing">

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600">Mahasiswa</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Periode</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kehadiran</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Logbook</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penempatans as $penempatan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $penempatan->mahasiswa->user->name }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->periode }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->hadir_count }}/{{ $penempatan->absensis_count }}</td>
                        <td class="p-3 text-sm">
                            {{ $penempatan->logbooks_count }} total
                            @if ($penempatan->logbook_menunggu_count > 0)
                                <span class="text-xs text-yellow-600">({{ $penempatan->logbook_menunggu_count }} perlu diverifikasi)</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded
                                @if($penempatan->status == 'berjalan') bg-blue-100 text-blue-700
                                @elseif($penempatan->status == 'selesai') bg-green-100 text-green-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst($penempatan->status) }}
                            </span>
                        </td>

                        <td class="p-3 text-sm">
                            <a
                                href="{{ route('guru-pamong.absensi.show', $penempatan) }}"
                                class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition"
                                >
                                    Lihat Absensi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Belum ada mahasiswa bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.guru-pamong>