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
                        @forelse($rekapAbsensi as $item)
                            @php
                                $tanggal = $item['tanggal'];
                                $absensi = $item['absensi'];
                                $status = $item['status'];
                            @endphp

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-4 text-gray-900">
                                    {{ $tanggal->locale('id')->translatedFormat('l') }}
                                </td>

                                <td class="px-4 py-4 text-gray-900">
                                    {{ $tanggal->locale('id')->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-4 py-4">
                                    {{ $item['jam_masuk'] ?? '-' }}
                                </td>

                                <td class="px-4 py-4">
                                    {{ $item['jam_pulang'] ?? '-' }}
                                </td>

                                <td class="px-4 py-4">

                                    @if($status === 'hadir')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-100 text-green-700 font-medium text-xs">
                                            Hadir
                                        </span>

                                    @elseif($status === 'sakit')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-orange-100 text-orange-700 font-medium text-xs">
                                            Sakit
                                        </span>

                                    @elseif($status === 'izin')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-medium text-xs">
                                            Izin
                                        </span>

                                    @elseif($status === 'alpa')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-700 font-medium text-xs">
                                            Alpa
                                        </span>

                                    @elseif($status === 'belum_absen')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium text-xs">
                                            Belum Absen
                                        </span>

                                    @elseif($status === 'dibuka')

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 font-medium text-xs">
                                            Dibuka Kembali
                                        </span>

                                    @endif

                                </td>

                                <td class="px-4 py-4">

                                    @if($item['ada_data'] && $absensi)

                                        <a
                                            href="{{ route('mahasiswa.absensi.edit', $absensi->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium"
                                        >
                                            Edit
                                        </a>

                                    @elseif($status === 'belum_absen')

                                        <a
                                            href="{{ route('mahasiswa.absensi.create') }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs font-medium hover:bg-blue-700 transition"
                                        >
                                            Absen Sekarang
                                        </a>

                                    @elseif($status === 'dibuka')

                                        <a
                                            href="{{ route('mahasiswa.absensi.create', ['tanggal' => $tanggal->format('Y-m-d')]) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs font-medium hover:bg-indigo-700 transition"
                                        >
                                            Isi Absen
                                        </a>

                                    @elseif($status === 'alpa')

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @else

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="6"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Belum ada hari kerja dalam periode magang.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
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