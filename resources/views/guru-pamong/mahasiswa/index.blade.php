<x-layouts.guru-pamong title="Mahasiswa Bimbingan" subtitle="Daftar mahasiswa yang Anda bimbing"> 
 
    <div class="bg-white rounded-lg shadow-sm overflow-x-auto"> 
        <table class="w-full text-left"> 
            <thead class="bg-gray-50 border-b"> 
                <tr> 
                    <th class="p-3 text-sm font-semibold text-gray-600">No</th> 
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
                @forelse ($penempatans as $index => $penempatan) 
                    <tr class="border-b hover:bg-gray-50"> 
                        <td class="p-3 text-sm">{{ $index + 1 }}</td> 
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
                                title="Lihat Absensi"
                                class="inline-flex items-center justify-center w-8 h-8 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition" 
                            > 
                                <svg 
                                    class="w-4 h-4" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                > 
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" 
                                    /> 
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M12 15a3 3 0 100-6 3 3 0 000 6z" 
                                    /> 
                                </svg> 
                            </a> 
                        </td> 
                    </tr> 
                @empty 
                    <tr> 
                        <td colspan="8" class="p-4 text-center text-gray-500">Belum ada mahasiswa bimbingan.</td> 
                    </tr> 
                @endforelse 
            </tbody> 
        </table> 
    </div> 
 
</x-layouts.guru-pamong>