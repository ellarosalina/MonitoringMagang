<x-layouts.admin title="Data Sekolah" subtitle="Kelola sekolah mitra magang">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.sekolah.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Tambah Sekolah
    </a>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600">NPSN</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Nama Sekolah</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kecamatan</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Kuota</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sekolahs as $sekolah)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $sekolah->npsn }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->kecamatan }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->kuota_magang }}</td>
                        <td class="p-3 text-sm">{{ $sekolah->status }}</td>
                        <td class="p-3 text-sm space-x-2">
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
    </div>

    <div class="mt-4">
        {{ $sekolahs->links() }}
    </div>

</x-layouts.admin>