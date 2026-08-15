<x-layouts.mahasiswa>

    <div class="p-6">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Logbook Saya
            </h1>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (!$penempatan)

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-gray-500">
                        Anda belum memiliki penempatan magang.
                        Hubungi Admin GTK.
                    </p>
                </div>

            @else

                <div class="bg-white shadow-sm rounded-lg p-6">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Daftar Logbook
                        </h2>

                        <a
                            href="{{ route('mahasiswa.logbook.create') }}"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            + Tambah Logbook
                        </a>
                    </div>

                    <div class="space-y-4">

                        @forelse ($logbooks as $logbook)

                            <div class="border rounded-lg p-4">

                                <div class="flex justify-between items-start mb-2">

                                    <span class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}
                                    </span>

                                    <span
                                        class="px-2 py-1 text-xs rounded
                                        @if($logbook->status_verifikasi == 'disetujui')
                                            bg-green-100 text-green-700
                                        @elseif($logbook->status_verifikasi == 'revisi')
                                            bg-red-100 text-red-700
                                        @else
                                            bg-yellow-100 text-yellow-700
                                        @endif"
                                    >
                                        {{ ucfirst($logbook->status_verifikasi) }}
                                    </span>

                                </div>

                                <p class="text-gray-700 mb-3">
                                    {{ $logbook->kegiatan }}
                                </p>

                                @if ($logbook->dokumentasi)

                                    <img
                                        src="{{ Storage::url($logbook->dokumentasi) }}"
                                        alt="Dokumentasi"
                                        class="w-32 rounded-lg border mb-3"
                                    >

                                @endif

                                @if ($logbook->catatan_guru_pamong)

                                    <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-600 mb-3">
                                        <strong>Catatan Guru Pamong:</strong>
                                        {{ $logbook->catatan_guru_pamong }}
                                    </div>

                                @endif

                                <div class="flex gap-3">

                                    <a
                                        href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}"
                                        class="text-blue-600 hover:underline text-sm"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('mahasiswa.logbook.destroy', $logbook->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus logbook tanggal {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-600 hover:underline text-sm"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-6">
                                <p class="text-gray-500">
                                    Belum ada data logbook.
                                </p>
                            </div>

                        @endforelse

                    </div>

                    <div class="mt-6">
                        {{ $logbooks->links() }}
                    </div>

                </div>

            @endif

        </div>
    </div>

</x-layouts.mahasiswa>