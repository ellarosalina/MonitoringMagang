<x-layouts.admin title="Data Guru Pamong" subtitle="Kelola akun dan data guru pamong">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-2 mb-4">
        <form action="{{ route('admin.guru-pamong.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative w-80">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, Sekolah..." class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400">
            </div>
            <button type="submit" class="px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ route('admin.guru-pamong.index') }}" class="px-5 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.guru-pamong.create') }}" class="inline-block px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
            + Tambah Guru Pamong
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">No</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">NIP</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Mapel</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guruPamongs as $guruPamong)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $loop->iteration + ($guruPamongs->currentPage() - 1) * $guruPamongs->perPage() }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->user->name }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->user->email }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->nip }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->mapel }}</td>
                        <td class="p-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.guru-pamong.edit', $guruPamong->id) }}" title="Edit" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-8.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 8.5-8.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.guru-pamong.destroy', $guruPamong->id) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Yakin hapus data ini? Akun login guru pamong ini juga akan terhapus.')"
                                    
                                    >
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
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            @if (request('search'))
                                Data guru pamong "{{ request('search') }}" tidak ditemukan.
                            @else
                                Belum ada data guru pamong.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t font-semibold">
                    <td colspan="7" class="p-3 text-sm">Total: {{ $guruPamongs->total() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if ($guruPamongs->hasPages())
        <div class="mt-4 flex justify-end">
            <div class="flex items-center gap-1">
                @if ($guruPamongs->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">‹</span>
                @else
                    <a href="{{ $guruPamongs->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">‹</a>
                @endif

                @foreach ($guruPamongs->getUrlRange(1, $guruPamongs->lastPage()) as $page => $url)
                    @if ($page == $guruPamongs->currentPage())
                        <span class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-400 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($guruPamongs->hasMorePages())
                    <a href="{{ $guruPamongs->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">›</a>
                @else
                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">›</span>
                @endif
            </div>
        </div>
    @endif

</x-layouts.admin>