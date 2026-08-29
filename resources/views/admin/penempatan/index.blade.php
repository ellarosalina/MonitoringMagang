<x-layouts.admin title="Data Penempatan Magang" subtitle="Kelola penempatan mahasiswa ke sekolah">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">

        <div class="flex items-center gap-2">

            <a href="{{ route('admin.penempatan.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4" />

                </svg>

                <span>Tambah Penempatan</span>

            </a>

            <a href="{{ route('admin.penempatan.export', request()->query()) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-green-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 17v-6m0 0 3 3m-3-3-3 3m8-7h3m-3 4h3m-3 4h3M5 21h14a2 2 0 0 0 2-2V7.5L16.5 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z" />

                </svg>

                <span>Export Excel</span>

            </a>

        </div>

        <div class="flex items-center gap-2">

            <form method="GET" action="{{ route('admin.penempatan.index') }}">

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    <option value="semua" {{ !request('status') || request('status') == 'semua' ? 'selected' : '' }}>
                        Semua
                    </option>

                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>

                    <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>
                        Berjalan
                    </option>

                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>

                </select>

                @if (request('search'))
                    <input
                        type="hidden"
                        name="search"
                        value="{{ request('search') }}">
                @endif

            </form>

            <form action="{{ route('admin.penempatan.index') }}" method="GET">

                @if (request('status') && request('status') != 'semua')
                    <input
                        type="hidden"
                        name="status"
                        value="{{ request('status') }}">
                @endif

                <div class="relative">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Penempatan..."
                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400">

                    <button
                        type="submit"
                        class="absolute left-0 top-0 h-full px-3 text-gray-400 hover:text-gray-600"
                        title="Cari">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z" />

                        </svg>

                    </button>

                </div>

            </form>

            @if (request('search') || (request('status') && request('status') != 'semua'))

                <a
                    href="{{ route('admin.penempatan.index') }}"
                    class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition"
                    title="Reset">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4v5h5" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20v-5h-5" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 9A7.5 7.5 0 0 1 18 6.5L20 9M18.5 15A7.5 7.5 0 0 1 6 17.5L4 15" />

                    </svg>

                </a>

            @else

                <button
                    type="button"
                    class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-400 bg-gray-50 cursor-default"
                    title="Reset">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4v5h5" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20v-5h-5" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 9A7.5 7.5 0 0 1 18 6.5L20 9M18.5 15A7.5 7.5 0 0 1 6 17.5L4 15" />

                    </svg>

                </button>

            @endif

        </div>

    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">

        <table class="w-full text-left">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">
                        No
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Mahasiswa
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Sekolah
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Guru Pamong
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Periode
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse ($penempatans as $penempatan)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3 text-sm">
                            {{ $loop->iteration + ($penempatans->currentPage() - 1) * $penempatans->perPage() }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $penempatan->mahasiswa->user->name }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $penempatan->sekolah->nama_sekolah }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $penempatan->guruPamong->user->name }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $penempatan->periode }}
                        </td>

                        <td class="p-3 text-sm">

                            <span class="px-2 py-1 text-xs rounded
                                @if($penempatan->status == 'berjalan')
                                    bg-blue-100 text-blue-700
                                @elseif($penempatan->status == 'selesai')
                                    bg-green-100 text-green-700
                                @elseif($penempatan->status == 'dibatalkan')
                                    bg-red-100 text-red-700
                                @else
                                    bg-yellow-100 text-yellow-700
                                @endif">

                                {{ ucfirst($penempatan->status) }}

                            </span>

                        </td>

                        <td class="p-3 text-sm">

                            <div class="flex items-center gap-2">

                                <a
                                    href="{{ route('admin.penempatan.edit', $penempatan->id) }}"
                                    title="Edit"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition">

                                    <svg class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-8.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 8.5-8.5z"/>

                                    </svg>

                                </a>

                                <form
                                    action="{{ route('admin.penempatan.destroy', $penempatan->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin hapus data ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Hapus"
                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 transition">

                                        <svg class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 7h12M10 11v6M14 11v6M9 7V4h6v3m-8 0l1 13h6L19 7"/>

                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="p-4 text-center text-gray-500">

                            @if (request('search') || (request('status') && request('status') != 'semua'))

                                Data penempatan tidak ditemukan.

                            @else

                                Belum ada data penempatan.

                            @endif

                        </td>

                    </tr>

                @endforelse

            </tbody>

            <tfoot>

                <tr class="bg-gray-50 border-t font-semibold">

                    <td colspan="7" class="p-3 text-sm">
                        Total: {{ $penempatans->total() }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    @if ($penempatans->hasPages())

        <div class="mt-4 flex justify-end">

            <div class="flex items-center gap-1">

                @if ($penempatans->onFirstPage())

                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">
                        ‹
                    </span>

                @else

                    <a
                        href="{{ $penempatans->previousPageUrl() }}"
                        class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">

                        ‹

                    </a>

                @endif

                @foreach ($penempatans->getUrlRange(1, $penempatans->lastPage()) as $page => $url)

                    @if ($page == $penempatans->currentPage())

                        <span class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-400 rounded-md">
                            {{ $page }}
                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">

                            {{ $page }}

                        </a>

                    @endif

                @endforeach

                @if ($penempatans->hasMorePages())

                    <a
                        href="{{ $penempatans->nextPageUrl() }}"
                        class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">

                        ›

                    </a>

                @else

                    <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-md">
                        ›
                    </span>

                @endif

            </div>

        </div>

    @endif

</x-layouts.admin>