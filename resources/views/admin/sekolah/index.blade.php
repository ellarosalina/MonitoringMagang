<x-layouts.admin title="Data Sekolah" subtitle="Kelola sekolah mitra magang">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">

        <a href="{{ route('admin.sekolah.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4" />

            </svg>

            <span>Tambah Sekolah</span>

        </a>

        <div class="flex items-center gap-2">

            <form action="{{ route('admin.sekolah.index') }}" method="GET">

                <div class="relative">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Sekolah, NPSN..."
                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400"
                    >

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

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z" />

                        </svg>

                    </button>

                </div>

            </form>

            @if (request('search'))

                <a
                    href="{{ route('admin.sekolah.index') }}"
                    class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50"
                    title="Reset pencarian">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4v5h5" />

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20v-5h-5" />

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 9A7.5 7.5 0 0 1 18 6.5L20 9M18.5 15A7.5 7.5 0 0 1 6 17.5L4 15" />

                    </svg>

                </a>

            @else

                <button
                    type="button"
                    class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-400 bg-gray-50 cursor-default"
                    title="Reset pencarian">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4v5h5" />

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20v-5h-5" />

                        <path stroke-linecap="round"
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
                        NPSN
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Nama Sekolah
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Kepala Sekolah
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Kecamatan
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Kuota
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

                @forelse ($sekolahs as $sekolah)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3 text-sm">
                            {{ $loop->iteration + ($sekolahs->currentPage() - 1) * $sekolahs->perPage() }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $sekolah->npsn }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $sekolah->nama_sekolah }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $sekolah->kepala_sekolah }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $sekolah->kecamatan }}
                        </td>

                        <td class="p-3 text-sm">
                            {{ $sekolah->kuota_magang }}
                        </td>

                        <td class="p-3 text-sm">

                            <span class="px-2 py-1 text-xs rounded {{ $sekolah->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($sekolah->status) }}
                            </span>

                        </td>

                        <td class="p-3 text-sm">

                            <div class="flex items-center gap-2">

                                <a
                                    href="{{ route('admin.sekolah.edit', $sekolah->id) }}"
                                    title="Edit"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100">

                                    <svg
                                        class="w-4 h-4"
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
                                    action="{{ route('admin.sekolah.destroy', $sekolah->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin hapus data sekolah ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Hapus"
                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100">

                                        <svg
                                            class="w-4 h-4"
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

                        <td colspan="8" class="p-4 text-center text-gray-500">

                            @if (request('search'))

                                Data sekolah tidak ditemukan.

                            @else

                                Belum ada data sekolah.

                            @endif

                        </td>

                    </tr>

                @endforelse

            </tbody>

            <tfoot>

                <tr class="bg-gray-50 border-t font-semibold">

                    <td colspan="8" class="p-3 text-sm">
                        Total: {{ $sekolahs->total() }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-4">
        {{ $sekolahs->withQueryString()->links() }}
    </div>

</x-layouts.admin>