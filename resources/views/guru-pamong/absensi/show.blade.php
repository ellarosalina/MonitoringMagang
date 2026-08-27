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

                        <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase text-center">
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

                                <div class="flex items-center justify-center">

                                    @if(in_array($status, ['hadir', 'izin', 'sakit', 'alpa']))

                                        {{-- BUKA KEMBALI ABSEN --}}
                                        <button
                                            type="button"
                                            onclick="bukaModalAbsensi('{{ $tanggal->format('Y-m-d') }}')"
                                            title="Buka Kembali Absensi"
                                            class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition"
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 7l2 2m0 0l-2 2m2-2H9a5 5 0 000 10h2"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 17l-2-2m0 0l2-2m-2 2h8a5 5 0 000-10h-2"
                                                />
                                            </svg>
                                        </button>

                                    @elseif($status === 'dibuka')

                                        {{-- MENUNGGU MAHASISWA --}}
                                        <span
                                            title="Menunggu mahasiswa mengisi ulang"
                                            class="w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-500 rounded-lg"
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </span>

                                    @elseif($status === 'belum_absen')

                                        <span
                                            title="Hari ini"
                                            class="text-xs text-gray-400"
                                        >
                                            -
                                        </span>

                                    @else

                                        <span class="text-xs text-gray-400">
                                            -
                                        </span>

                                    @endif

                                </div>

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

    {{-- MODAL KONFIRMASI BUKA ABSENSI --}}
    <div
        id="modalBukaAbsensi"
        class="hidden fixed inset-0 z-[9999] bg-black/50 p-4 items-center justify-center"
    >

        <div
            class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden"
            onclick="event.stopPropagation()"
        >

            {{-- HEADER MODAL --}}
            <div class="px-6 py-5 border-b border-gray-200">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 7l2 2m0 0l-2 2m2-2H9a5 5 0 000 10h2"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 17l-2-2m0 0l2-2m-2 2h8a5 5 0 000-10h-2"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-semibold text-gray-800">
                            Buka Kembali Absensi?
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Konfirmasi pembukaan absensi
                        </p>

                    </div>

                </div>

            </div>

            {{-- ISI MODAL --}}
            <div class="px-6 py-5">

                <p class="text-sm text-gray-600 leading-6">
                    Apakah Anda yakin ingin membuka kembali absensi mahasiswa pada tanggal ini?
                    Setelah dibuka, mahasiswa dapat mengisi ulang absensinya.
                </p>

            </div>

            {{-- FOOTER MODAL --}}
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2">

                <button
                    type="button"
                    onclick="tutupModalAbsensi()"
                    class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition"
                >
                    Batal
                </button>

                <form
                    id="formBukaAbsensi"
                    action="{{ route('guru-pamong.absensi.buka', $penempatan) }}"
                    method="POST"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="tanggal"
                        id="tanggalBukaAbsensi"
                        value=""
                    >

                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition"
                    >
                        Buka Absensi
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>

        function bukaModalAbsensi(tanggal) {

            const modal = document.getElementById('modalBukaAbsensi');
            const inputTanggal = document.getElementById('tanggalBukaAbsensi');

            inputTanggal.value = tanggal;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function tutupModalAbsensi() {

            const modal = document.getElementById('modalBukaAbsensi');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');

            document.getElementById('tanggalBukaAbsensi').value = '';
        }

        document.getElementById('modalBukaAbsensi').addEventListener('click', function(event) {

            if (event.target === this) {
                tutupModalAbsensi();
            }

        });

        document.addEventListener('keydown', function(event) {

            if (event.key === 'Escape') {
                tutupModalAbsensi();
            }

        });

    </script>

</x-layouts.guru-pamong>