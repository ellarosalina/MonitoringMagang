<x-layouts.mahasiswa title="Absensi" subtitle="">
    <div class="space-y-1">
        @if($penempatan)
            @php
                $tanggalHariIni = \Carbon\Carbon::today();
                $sudahAbsenHariIni = $penempatan->absensis()
                    ->whereDate('tanggal', $tanggalHariIni)
                    ->exists();
            @endphp

            <div class="flex items-center justify-between mb-2">

    <div class="text-sm text-gray-600">
        Hari ini:
        <span class="font-semibold text-gray-900">
            {{ $tanggalHariIni->locale('id')->translatedFormat('l, d F Y') }}
        </span>
    </div>

    @if($tanggalHariIni->isWeekend())

        <span class="text-sm text-gray-600">
            Hari Libur - Absensi Tidak Tersedia
        </span>

    @elseif($sudahAbsenHariIni)

        <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg">
            ✓ Sudah Absen Hari Ini
        </span>

    @else

        <a
            href="{{ route('mahasiswa.absensi.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-600 border border-blue-600 text-sm font-medium rounded-lg hover:bg-blue-50 transition"
        >
            + Isi Absensi Hari Ini
        </a>

    @endif

</div>

            {{-- TABEL --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden ">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-center px-4 py-4 font-semibold text-gray-900 w-16">
                                    No
                                </th>
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
                                <th class="text-center px-4 py-4 font-semibold text-gray-900">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rekapAbsensi as $index => $item)
                                @php
                                    $tanggal = $item['tanggal'];
                                    $absensi = $item['absensi'];
                                    $status = $item['status'];
                                    $jamMasuk = $item['jam_masuk'] ?? '-';
                                    $jamPulang = $item['jam_pulang'] ?? '-';

                                    if ($jamMasuk !== '-') {
                                        $jamMasuk = \Carbon\Carbon::parse($jamMasuk)->format('G:i');
                                    }

                                    if ($jamPulang !== '-') {
                                        $jamPulang = \Carbon\Carbon::parse($jamPulang)->format('G:i');
                                    }
                                @endphp

                                <tr class="baris-absensi border-b border-gray-100 hover:bg-gray-50 transition">
                                    {{-- NO --}}
                                    <td class="px-4 py-4 text-center text-gray-500 nomor-baris">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- HARI --}}
                                    <td class="px-4 py-4 text-gray-900">
                                        {{ $tanggal->locale('id')->translatedFormat('l') }}
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-4 py-4 text-gray-900">
                                        {{ $tanggal->locale('id')->translatedFormat('d M Y') }}
                                    </td>

                                    {{-- JAM MASUK --}}
                                    <td class="px-4 py-4 text-gray-700">
                                        {{ $jamMasuk }}
                                    </td>

                                    {{-- JAM PULANG --}}
                                    <td class="px-4 py-4 text-gray-700">
                                        {{ $jamPulang }}
                                    </td>

                                    {{-- STATUS --}}
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

                                    {{-- AKSI --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($status === 'belum_absen')
                                                {{-- ISI ABSEN --}}
                                                <a
                                                    href="{{ route('mahasiswa.absensi.create') }}"
                                                    title="Isi Absen"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
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
                                                            d="M12 4v16m8-8H4"
                                                        />
                                                    </svg>
                                                </a>
                                            @elseif($status === 'dibuka')
                                                {{-- ISI ABSEN DIBUKA KEMBALI --}}
                                                <a
                                                    href="{{ route('mahasiswa.absensi.create', ['tanggal' => $tanggal->format('Y-m-d')]) }}"
                                                    title="Isi Absen"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition"
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
                                                            d="M12 4v16m8-8H4"
                                                        />
                                                    </svg>
                                                </a>
                                            @else
                                                {{-- LIHAT --}}
                                                <button
                                                    type="button"
                                                    onclick="lihatAbsensi(this)"
                                                    data-tanggal="{{ $tanggal->locale('id')->translatedFormat('l, d F Y') }}"
                                                    data-status="{{ ucfirst(str_replace('_', ' ', $status)) }}"
                                                    data-masuk="{{ $jamMasuk }}"
                                                    data-pulang="{{ $jamPulang }}"
                                                    title="Lihat Detail"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition"
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
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                        />
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 15a3 3 0 100-6 3 3 0 000 6z"
                                                        />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
                                        class="px-4 py-10 text-center text-gray-500"
                                    >
                                        Belum ada hari kerja dalam periode magang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- FOOTER TABEL --}}
                @if($rekapAbsensi->count() > 0)
                    <div class="border-t border-gray-200">
                        {{-- TOTAL --}}
                        <div class="px-6 py-4 bg-gray-50">
                            <span class="text-sm text-gray-500">
                                Total {{ count($rekapAbsensi) }} absensi
                            </span>
                        </div>

                        {{-- PAGINATION --}}
                        <div class="px-6 py-4 flex items-center justify-between">
                            <p
                                id="infoPagination"
                                class="text-sm text-gray-500"
                            >
                                Showing 1 to 10 of {{ count($rekapAbsensi) }} results
                            </p>

                            <div class="flex items-center">
                                {{-- PREVIOUS --}}
                                <button
                                    type="button"
                                    id="prevPage"
                                    onclick="ubahHalaman(halamanSekarang - 1)"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-700 text-white border-r border-gray-600 rounded-l-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-800 transition"
                                    disabled
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
                                            d="M15 19l-7-7 7-7"
                                        />
                                    </svg>
                                </button>

                                {{-- NOMOR HALAMAN --}}
                                <div
                                    id="nomorHalaman"
                                    class="flex"
                                ></div>

                                {{-- NEXT --}}
                                <button
                                    type="button"
                                    id="nextPage"
                                    onclick="ubahHalaman(halamanSekarang + 1)"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-700 text-white rounded-r-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-800 transition"
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
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
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

    {{-- MODAL DETAIL ABSENSI --}}
    <div
        id="modalAbsensi"
        class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4"
    >
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Detail Absensi
                </h2>
                <button
                    type="button"
                    onclick="tutupAbsensi()"
                    class="text-gray-400 hover:text-gray-600 text-xl"
                >
                    ×
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-gray-500">
                        Tanggal
                    </p>
                    <p
                        id="modalTanggal"
                        class="font-semibold text-gray-800 mt-1"
                    >
                        -
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Status
                    </p>
                    <p
                        id="modalStatus"
                        class="font-semibold text-gray-800 mt-1"
                    >
                        -
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">
                            Jam Masuk
                        </p>
                        <p
                            id="modalMasuk"
                            class="font-semibold text-gray-800 mt-1"
                        >
                            -
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Jam Pulang
                        </p>
                        <p
                            id="modalPulang"
                            class="font-semibold text-gray-800 mt-1"
                        >
                            -
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t flex justify-end">
                <button
                    type="button"
                    onclick="tutupAbsensi()"
                    class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        let halamanSekarang = 1;
        const dataPerHalaman = 10;
        const baris = document.querySelectorAll('.baris-absensi');
        const totalData = baris.length;
        const totalHalaman = Math.ceil(totalData / dataPerHalaman);

        function tampilkanHalaman(halaman) {
            halamanSekarang = halaman;

            const mulai = (halaman - 1) * dataPerHalaman;
            const selesai = mulai + dataPerHalaman;

            baris.forEach((row, index) => {
                row.style.display = index >= mulai && index < selesai ? '' : 'none';
            });

            const awal = totalData === 0 ? 0 : mulai + 1;
            const akhir = Math.min(selesai, totalData);

            document.getElementById('infoPagination').textContent =
                `Showing ${awal} to ${akhir} of ${totalData} results`;

            const prev = document.getElementById('prevPage');
            const next = document.getElementById('nextPage');

            prev.disabled = halaman === 1;
            next.disabled = halaman === totalHalaman;

            buatNomorHalaman();
        }

        function ubahHalaman(halaman) {
            if (halaman < 1 || halaman > totalHalaman) {
                return;
            }

            tampilkanHalaman(halaman);
        }

        function buatNomorHalaman() {
            const container = document.getElementById('nomorHalaman');

            container.innerHTML = '';

            for (let i = 1; i <= totalHalaman; i++) {
                const button = document.createElement('button');

                button.type = 'button';
                button.textContent = i;

                button.className =
                    'w-10 h-10 flex items-center justify-center text-sm border-r border-gray-600 transition ' +
                    (
                        i === halamanSekarang
                            ? 'bg-gray-700 text-white font-medium'
                            : 'bg-gray-600 text-gray-200 hover:bg-gray-700'
                    );

                button.onclick = function () {
                    ubahHalaman(i);
                };

                container.appendChild(button);
            }
        }

        function lihatAbsensi(button) {
            document.getElementById('modalTanggal').textContent =
                button.dataset.tanggal;

            document.getElementById('modalStatus').textContent =
                button.dataset.status;

            document.getElementById('modalMasuk').textContent =
                button.dataset.masuk;

            document.getElementById('modalPulang').textContent =
                button.dataset.pulang;

            const modal = document.getElementById('modalAbsensi');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function tutupAbsensi() {
            const modal = document.getElementById('modalAbsensi');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        const modal = document.getElementById('modalAbsensi');

        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    tutupAbsensi();
                }
            });
        }

        if (totalData > 0) {
            tampilkanHalaman(1);
        }
    </script>
</x-layouts.mahasiswa>