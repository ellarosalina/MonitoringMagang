<x-layouts.guru-pamong title="Rekap Absensi" subtitle="Rekap absensi mahasiswa bimbingan">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    {{ $penempatan->mahasiswa->user->name }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $penempatan->sekolah->nama_sekolah }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Periode: {{ $penempatan->periode }}
                </p>
            </div>

            <a
                href="{{ route('guru-pamong.mahasiswa.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800">
                Rekap Absensi
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Absensi yang tidak diisi pada hari kerja akan ditampilkan sebagai Alpa.
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">
                            Tanggal
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">
                            Jam Masuk
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">
                            Jam Pulang
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($rekapAbsensi as $item)

                        @php
                            $tanggal = $item['tanggal'];
                            $absensi = $item['absensi'];
                            $status = $item['status'];
                        @endphp

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $tanggal->locale('id')->translatedFormat('l, d F Y') }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $absensi?->jam_masuk ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $absensi?->jam_pulang ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                @if($status === 'hadir')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Hadir
                                    </span>

                                @elseif($status === 'izin')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                        Izin
                                    </span>

                                @elseif($status === 'sakit')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                        Sakit
                                    </span>

                                @elseif($status === 'alpa')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        Alpa
                                    </span>

                                @elseif($status === 'belum_absen')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                        Belum Absen
                                    </span>

                                @elseif($status === 'dibuka')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                        Dibuka Kembali
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($status === 'alpa')

                                    <form
                                        action="{{ route('guru-pamong.absensi.buka', $penempatan) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="tanggal"
                                            value="{{ $tanggal->format('Y-m-d') }}"
                                        >

                                        <button
                                            type="submit"
                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition"
                                        >
                                            Buka Absen
                                        </button>
                                    </form>

                                @elseif($status === 'dibuka')

                                    <span class="text-xs text-indigo-600 font-medium">
                                        Menunggu mahasiswa
                                    </span>

                                @elseif($status === 'belum_absen')

                                    <span class="text-xs text-gray-400">
                                        Hari ini
                                    </span>

                                @else

                                    <span class="text-xs text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                Belum ada data absensi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.guru-pamong>