<x-layouts.admin title="Data Guru Pamong" subtitle="Kelola akun dan data guru pamong">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.guru-pamong.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Tambah Guru Pamong
    </a>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
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
                        <td class="p-3 text-sm">{{ $guruPamong->user->name }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->user->email }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->sekolah->nama_sekolah }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->nip }}</td>
                        <td class="p-3 text-sm">{{ $guruPamong->mapel }}</td>
                        <td class="p-3 text-sm space-x-2">
                            <a href="{{ route('admin.guru-pamong.edit', $guruPamong->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.guru-pamong.destroy', $guruPamong->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini? Akun login guru pamong ini juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data guru pamong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $guruPamongs->links() }}
    </div>

</x-layouts.admin>