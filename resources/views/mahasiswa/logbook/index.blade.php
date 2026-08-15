<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Logbook Saya
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
                    <a href="{{ route('mahasiswa.logbook.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Logbook
                    </a>

                    <div class="space-y-4">
                        @forelse ($logbooks as $logbook)
                            <div class="border rounded p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</span>
                                    <span class="px-2 py-1 text-xs rounded
                                        @if($logbook->status_verifikasi == 'disetujui') bg-green-100 text-green-700
                                        @elseif($logbook->status_verifikasi == 'revisi') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ ucfirst($logbook->status_verifikasi) }}
                                    </span>
                                </div>
                                <p class="text-gray-700 mb-2">{{ $logbook->kegiatan }}</p>

                                @if ($logbook->dokumentasi)
                                    <img src="{{ Storage::url($logbook->dokumentasi) }}" alt="Dokumentasi" class="w-32 rounded border mb-2">
                                @endif

                                @if ($logbook->catatan_guru_pamong)
                                    <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 mb-2">
                                        <strong>Catatan Guru Pamong:</strong> {{ $logbook->catatan_guru_pamong }}
                                    </div>
                                @endif

                                <div class="flex gap-3">
                                    <a href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                    <form action="{{ route('mahasiswa.logbook.destroy', $logbook->id) }}" method="POST" onsubmit="return confirm('Yakin hapus logbook tanggal {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                </div>
                                
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Belum ada data logbook.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $logbooks->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>