<x-layouts.admin title="Data Dosen Pembimbing" subtitle="Kelola data dosen pembimbing dari kampus">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.dosen-pembimbing.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Tambah Dosen Pembimbing
    </a>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">NIP/NIDN</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Universitas</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">No. HP</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosenPembimbings as $dosenPembimbing)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $dosenPembimbing->nama }}</td>
                        <td class="p-3 text-sm">{{ $dosenPembimbing->nip_nidn }}</td>
                        <td class="p-3 text-sm">{{ $dosenPembimbing->universitas }}</td>
                        <td class="p-3 text-sm">{{ $dosenPembimbing->no_hp }}</td>
                        <td class="p-3 text-sm">{{ $dosenPembimbing->email }}</td>
                        <td class="p-3 text-sm space-x-2">
                            <a href="{{ route('admin.dosen-pembimbing.edit', $dosenPembimbing->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.dosen-pembimbing.destroy', $dosenPembimbing->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data dosen pembimbing.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $dosenPembimbings->links() }}
    </div>

</x-layouts.admin>