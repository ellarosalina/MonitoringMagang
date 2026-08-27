<x-layouts.admin title="Monitoring Magang" subtitle="Pantau progress seluruh mahasiswa magang">

    <div class="flex items-center gap-2 mb-4">
        <form method="GET" action="{{ route('admin.monitoring.index') }}" class="flex items-center gap-2">
            <div class="relative w-80">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari mahasiswa atau sekolah..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400">
            </div>
            <button type="submit" class="px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">Cari</button>
            @if(!empty($search))
                <a href="{{ route('admin.monitoring.index') }}" class="px-5 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.monitoring.export') }}" class="inline-block px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">
            Export ke Excel
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">No</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Mahasiswa</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Periode</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Progress</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kehadiran</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Logbook</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penempatans as $penempatan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $loop->iteration + ($penempatans->currentPage() - 1) * $penempatans->perPage() }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->mahasiswa->user->name }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->periode }}</td>
                        <td class="p-3 text-sm w-40">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $penempatan->progress_percent }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $penempatan->progress_percent }}%</span>
                            </div>
                        </td>
                        <td class="p-3 text-sm">{{ $penempatan->hadir_count }}/{{ $penempatan->absensis_count }}</td>
                        <td class="p-3 text-sm">
                            {{ $penempatan->logbook_disetujui_count }}/{{ $penempatan->logbooks_count }}
                            @if ($penempatan->logbook_menunggu_count > 0)
                                <span class="text-xs text-yellow-600">({{ $penempatan->logbook_menunggu_count }} menunggu)</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded
                                @if($penempatan->status == 'berjalan') bg-blue-100 text-blue-700
                                @elseif($penempatan->status == 'selesai') bg-green-100 text-green-700
                                @elseif($penempatan->status == 'dibatalkan') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst($penempatan->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm">
                            <a href="{{ route('admin.monitoring.show', $penempatan->id) }}" title="Lihat Detail" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">Belum ada data penempatan.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t font-semibold">
                    <td colspan="9" class="p-3 text-sm">Total: {{ $penempatans->total() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if ($penempatans->hasPages())
        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $penempatans->firstItem() }}–{{ $penempatans->lastItem() }} dari {{ $penempatans->total() }} data
            </div>
            <div class="flex items-center gap-1">
                @if ($penempatans->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">‹</span>
                @else
                    <a href="{{ $penempatans->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">‹</a>
                @endif

                @foreach ($penempatans->getUrlRange(1, $penempatans->lastPage()) as $page => $url)
                    @if ($page == $penempatans->currentPage())
                        <span class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-400 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($penempatans->hasMorePages())
                    <a href="{{ $penempatans->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">›</a>
                @else
                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">›</span>
                @endif
            </div>
        </div>
    @endif

</x-layouts.admin>