<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Absensi Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (!$penempatan)
                    <p class="text-gray-500">Anda belum memiliki penempatan magang. Hubungi Admin GTK.</p>
                @else
                    <div class="mb-4 p-4 bg-gray-50 rounded">
                        <p class="text-sm text-gray-600">Penempatan: <strong>{{ $penempatan->sekolah->nama_sekolah }}</strong> ({{ $penempatan->periode }})</p>
                    </div>

                    <a href="{{ route('mahasiswa.absensi.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Isi Absensi Hari Ini
                    </a>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Jam Masuk</th>
                                <th class="p-2">Jam Pulang</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absensis as $absensi)
                                <tr class="border-b">
                                    <td class="p-2">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                                    <td class="p-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                                    <td class="p-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                                    <td class="p-2">{{ ucfirst($absensi->status) }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('mahasiswa.absensi.edit', $absensi->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $absensis->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>