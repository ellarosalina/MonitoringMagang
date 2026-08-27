<x-layouts.admin title="Data Penempatan Magang" subtitle="Kelola penempatan mahasiswa ke sekolah">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.penempatan.create') }}" class="inline-block mb-4 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
        + Tambah Penempatan
    </a>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">No</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Mahasiswa</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Guru Pamong</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Periode</th>
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
                        <td class="p-3 text-sm">{{ $penempatan->guruPamong->user->name }}</td>
                        <td class="p-3 text-sm">{{ $penempatan->periode }}</td>
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
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.penempatan.edit', $penempatan->id) }}" title="Edit" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-8.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 8.5-8.5z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.penempatan.destroy', $penempatan->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus" class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M10 11v6M14 11v6M9 7V4h6v3m-8 0l1 13h6L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data penempatan.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t font-semibold">
                    <td colspan="7" class="p-3 text-sm">Total: {{ $penempatans->total() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if ($penempatans->hasPages())
        <div class="mt-4 flex justify-end">
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