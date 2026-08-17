<x-layouts.admin title="Data Penempatan Magang" subtitle="Kelola penempatan mahasiswa ke sekolah">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.penempatan.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
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
                        <td class="p-3 text-sm space-x-2">
                            <a href="{{ route('admin.penempatan.edit', $penempatan->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.penempatan.destroy', $penempatan->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data penempatan.</td>
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

    <div class="mt-4">
        {{ $penempatans->links() }}
    </div>

</x-layouts.admin>