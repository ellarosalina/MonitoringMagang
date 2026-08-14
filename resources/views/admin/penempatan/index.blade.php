<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Penempatan Magang
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

                <a href="{{ route('admin.penempatan.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Penempatan
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2">Mahasiswa</th>
                            <th class="p-2">Sekolah</th>
                            <th class="p-2">Guru Pamong</th>
                            <th class="p-2">Dosen Pembimbing</th>
                            <th class="p-2">Periode</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penempatans as $penempatan)
                            <tr class="border-b">
                                <td class="p-2">{{ $penempatan->mahasiswa->user->name }}</td>
                                <td class="p-2">{{ $penempatan->sekolah->nama_sekolah }}</td>
                                <td class="p-2">{{ $penempatan->guruPamong->user->name }}</td>
                                <td class="p-2">{{ $penempatan->dosenPembimbing->nama ?? '-' }}</td>
                                <td class="p-2">{{ $penempatan->periode }}</td>
                                <td class="p-2">
                                    <span class="px-2 py-1 text-xs rounded
                                        @if($penempatan->status == 'berjalan') bg-blue-100 text-blue-700
                                        @elseif($penempatan->status == 'selesai') bg-green-100 text-green-700
                                        @elseif($penempatan->status == 'dibatalkan') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ $penempatan->status }}
                                    </span>
                                </td>
                                <td class="p-2 space-x-2">
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
                                <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data penempatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $penempatans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>