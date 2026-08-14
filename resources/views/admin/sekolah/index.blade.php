<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Sekolah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('admin.sekolah.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Sekolah
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2">NPSN</th>
                            <th class="p-2">Nama Sekolah</th>
                            <th class="p-2">Kecamatan</th>
                            <th class="p-2">Kuota</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sekolahs as $sekolah)
                            <tr class="border-b">
                                <td class="p-2">{{ $sekolah->npsn }}</td>
                                <td class="p-2">{{ $sekolah->nama_sekolah }}</td>
                                <td class="p-2">{{ $sekolah->kecamatan }}</td>
                                <td class="p-2">{{ $sekolah->kuota_magang }}</td>
                                <td class="p-2">{{ $sekolah->status }}</td>
                                <td class="p-2 space-x-2">
                                    <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data sekolah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $sekolahs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>