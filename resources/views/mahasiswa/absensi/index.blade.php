<x-layouts.mahasiswa title="Absensi" subtitle="">

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Absensi Saya
            </h1>
        </div>

        @if($penempatan)

                <div class="mb-6">

    @php
        $tanggalHariIni = \Carbon\Carbon::today();

        $sudahAbsenHariIni = $penempatan->absensis()
            ->whereDate('tanggal', $tanggalHariIni)
            ->exists();
    @endphp

    @if($tanggalHariIni->isWeekend())

        <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 text-sm font-medium rounded-lg">
            Hari Libur - Absensi Tidak Tersedia
        </span>

    @elseif($sudahAbsenHariIni)

        <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg">
            ✓ Sudah Absen Hari Ini
        </span>

    @else

        <a href="{{ route('mahasiswa.absensi.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            + Isi Absensi Hari Ini
        </a>

    @endif

</div>

<div class="text-sm text-gray-500 mb-6">
    Hari ini:
    <span class="font-medium text-gray-700">
        {{ $tanggalHariIni->locale('id')->translatedFormat('l, d F Y') }}
    </span>
</div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead>
                            <tr class="bg-gray-50 border-b">

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Hari
                                </th>

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Tanggal
                                </th>

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Jam Masuk
                                </th>

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Jam Pulang
                                </th>

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Status
                                </th>

                                <th class="text-left px-4 py-4 font-semibold text-gray-900">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @forelse($absensis as $absensi)

                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-4 text-gray-900">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->translatedFormat('l') }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-900">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $absensi->jam_masuk ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $absensi->jam_pulang ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4">

                                        @if($absensi->status === 'hadir')

                                            <span class="text-green-600 font-medium">
                                                Hadir
                                            </span>

                                        @elseif($absensi->status === 'sakit')

                                            <span class="text-yellow-600 font-medium">
                                                Sakit
                                            </span>

                                        @elseif($absensi->status === 'izin')

                                            <span class="text-blue-600 font-medium">
                                                Izin
                                            </span>

                                        @elseif($absensi->status === 'alpa')

                                            <span class="text-red-600 font-medium">
                                                Alpa
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-4">

                                        <a href="{{ route('mahasiswa.absensi.edit', $absensi->id) }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium">
                                            Edit
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6"
                                        class="px-4 py-8 text-center text-gray-500">
                                        Belum ada data absensi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if(method_exists($absensis, 'links'))
                    <div class="mt-4">
                        {{ $absensis->links() }}
                    </div>
                @endif

            </div>

        @else

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-gray-500">
                    Anda belum memiliki penempatan magang.
                </p>
            </div>

        @endif

    </div>

</x-layouts.mahasiswa>