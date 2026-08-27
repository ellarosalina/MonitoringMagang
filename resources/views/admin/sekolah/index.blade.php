<x-layouts.admin title="Data Sekolah" subtitle="Kelola sekolah mitra magang">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-2 mb-4">
        <form action="{{ route('admin.sekolah.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative w-80">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sekolah, NPSN..." class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400">
            </div>
            <button type="submit" class="px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                Cari
            </button>
        </form>

        <a href="{{ route('admin.sekolah.create') }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
            + Tambah Sekolah
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">No</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">NPSN</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Nama Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kepala Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kecamatan</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kuota</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sekolahs as $sekolah)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $loop->iteration + ($sekolahs->currentPage() - 1) * $sekolahs->perPage() }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->npsn }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->kepala_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->kecamatan }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->kuota_magang }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded {{ $sekolah->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($sekolah->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" title="Edit" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-8.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 8.5-8.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data sekolah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus" class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100">
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
                        <td colspan="8" class="p-4 text-center text-gray-500">Belum ada data sekolah.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t font-semibold">
                    <td colspan="8" class="p-3 text-sm">Total: {{ $sekolahs->total() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-4">
        {{ $sekolahs->withQueryString()->links() }}
    </div>

</x-layouts.admin>