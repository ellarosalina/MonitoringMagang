<x-layouts.guru-pamong title="Verifikasi Logbook" subtitle="Pantau, lihat, dan verifikasi logbook mahasiswa bimbingan">

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

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="flex items-center gap-2 mb-4">

        <form action="{{ route('guru-pamong.logbook.index') }}" method="GET">

            <div class="flex items-center gap-2">

                <div class="relative">

                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="appearance-none w-32 pl-4 pr-8 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400"
                    >
                        <option value="semua" {{ ($status ?? 'semua') === 'semua' ? 'selected' : '' }}>
                            Semua
                        </option>

                        <option value="menunggu" {{ ($status ?? '') === 'menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="revisi" {{ ($status ?? '') === 'revisi' ? 'selected' : '' }}>
                            Revisi
                        </option>

                        <option value="disetujui" {{ ($status ?? '') === 'disetujui' ? 'selected' : '' }}>
                            Disetujui
                        </option>
                    </select>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6 9 6 6 6-6"
                        />
                    </svg>

                </div>

                <div class="relative">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari Mahasiswa..."
                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400"
                    >

                    <button
                        type="submit"
                        class="absolute left-0 top-0 h-full px-3 text-gray-400 hover:text-gray-600"
                        title="Cari"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"
                            />
                        </svg>

                    </button>

                </div>

            </div>

        </form>

        @if (($search ?? '') || ($status ?? 'semua') !== 'semua')

            <a
                href="{{ route('guru-pamong.logbook.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50"
                title="Reset pencarian"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 4v5h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 20v-5h-5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.5 9A7.5 7.5 0 0 1 18 6.5L20 9M18.5 15A7.5 7.5 0 0 1 6 17.5L4 15"
                    />
                </svg>

            </a>

        @else

            <button
                type="button"
                class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg text-gray-400 bg-gray-50 cursor-default"
                title="Reset pencarian"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 4v5h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 20v-5h-5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.5 9A7.5 7.5 0 0 1 18 6.5L20 9M18.5 15A7.5 7.5 0 0 1 6 17.5L4 15"
                    />
                </svg>

            </button>

        @endif

    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">

        <table class="w-full text-left">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        No
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Mahasiswa
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Tanggal
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Kegiatan
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Dokumentasi
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Status
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Catatan
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600 whitespace-nowrap">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse ($logbooks as $logbook)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3 text-sm whitespace-nowrap">
                            {{ $loop->iteration + ($logbooks->currentPage() - 1) * $logbooks->perPage() }}
                        </td>

                        <td class="p-3 text-sm whitespace-nowrap">

                            <div class="font-medium text-gray-800">
                                {{ $logbook->penempatan->mahasiswa->user->name }}
                            </div>

                        </td>

                        <td class="p-3 text-sm whitespace-nowrap">

                            <div class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($logbook->tanggal)->locale('id')->translatedFormat('l') }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}
                            </div>

                        </td>

                        <td class="p-3 text-sm min-w-[280px]">

                            <div class="font-medium text-gray-800">
                                {{ $logbook->kegiatan }}
                            </div>

                            @if ($logbook->detail_kegiatan)

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit($logbook->detail_kegiatan, 100) }}
                                </div>

                            @endif

                        </td>

                        <td class="p-3 text-sm whitespace-nowrap">

                            @if ($logbook->dokumentasi)

                                <div class="w-20 h-16 border rounded-lg bg-gray-50 overflow-hidden flex items-center justify-center">

                                    <img
                                        src="{{ Storage::url($logbook->dokumentasi) }}"
                                        alt="Dokumentasi"
                                        class="w-full h-full object-contain"
                                    >

                                </div>

                            @else

                                <span class="text-xs text-gray-400">
                                    Tidak ada
                                </span>

                            @endif

                        </td>

                        <td class="p-3 text-sm whitespace-nowrap">

                            @if ($logbook->status_verifikasi == 'disetujui')

                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Disetujui
                                </span>

                            @elseif ($logbook->status_verifikasi == 'revisi')

                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Revisi
                                </span>

                            @else

                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>

                            @endif

                        </td>

                        <td class="p-3 text-sm min-w-[220px]">

                            @if ($logbook->catatan_guru_pamong)

                                <span class="text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($logbook->catatan_guru_pamong, 80) }}
                                </span>

                            @else

                                <span class="text-gray-400">
                                    -
                                </span>

                            @endif

                        </td>

                        <td class="p-3 text-sm whitespace-nowrap">

                            <div
                                x-data="{
                                    showDetail: false,
                                    showVerifikasi: false,
                                    catatan: @js($logbook->catatan_guru_pamong ?? ''),
                                    catatanError: false
                                }"
                                class="flex items-center gap-2"
                            >

                                <button
                                    type="button"
                                    @click="showDetail = true"
                                    title="Lihat"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-600 transition"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 8.943 7.523 6.5 12 6.5s8.268 2.443 9.542 5.5C20.268 15.057 16.477 17.5 12 17.5S3.732 15.057 2.458 12z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                        />

                                    </svg>

                                </button>

                                <button
                                    type="button"
                                    @click="showVerifikasi = true; catatanError = false"
                                    title="Verifikasi"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v17H7.5A2.5 2.5 0 0 0 5 21.5V4.5z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 21.5A2.5 2.5 0 0 1 7.5 19H20"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 6h7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 10h7"
                                        />

                                    </svg>

                                </button>

                                <div
                                    x-show="showDetail"
                                    x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
                                    @keydown.escape.window="showDetail = false"
                                >

                                    <div
                                        class="bg-white rounded-xl shadow-xl w-full max-w-xl max-h-[90vh] overflow-hidden flex flex-col"
                                        @click.stop
                                    >

                                        <div class="flex items-center justify-between px-6 py-4 border-b">

                                            <div>

                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    Detail Logbook
                                                </h3>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $logbook->penempatan->mahasiswa->user->name }}
                                                </p>

                                            </div>

                                            <button
                                                type="button"
                                                @click="showDetail = false"
                                                class="text-gray-400 hover:text-gray-700 text-2xl leading-none"
                                            >
                                                ×
                                            </button>

                                        </div>

                                        <div class="px-6 py-5 overflow-y-auto">

                                            <div class="space-y-5">

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-1">
                                                        Tanggal
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-800">
                                                        {{ \Carbon\Carbon::parse($logbook->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                                    </p>

                                                </div>

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-1">
                                                        Kegiatan
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-800">
                                                        {{ $logbook->kegiatan }}
                                                    </p>

                                                </div>

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                        Detail Kegiatan
                                                    </p>

                                                    @if ($logbook->detail_kegiatan)

                                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                                                {{ $logbook->detail_kegiatan }}
                                                            </p>

                                                        </div>

                                                    @else

                                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                                            <p class="text-sm text-gray-400">
                                                                Tidak ada detail kegiatan.
                                                            </p>

                                                        </div>

                                                    @endif

                                                </div>

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                        Dokumentasi
                                                    </p>

                                                    @if ($logbook->dokumentasi)

                                                        <div class="border border-gray-200 rounded-lg bg-gray-50 p-2 w-fit">

                                                            <img
                                                                src="{{ Storage::url($logbook->dokumentasi) }}"
                                                                alt="Dokumentasi Logbook"
                                                                class="w-52 h-40 object-contain rounded-lg"
                                                            >

                                                        </div>

                                                    @else

                                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">

                                                            <p class="text-sm text-gray-400">
                                                                Tidak ada dokumentasi.
                                                            </p>

                                                        </div>

                                                    @endif

                                                </div>

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                        Status Verifikasi
                                                    </p>

                                                    @if ($logbook->status_verifikasi == 'disetujui')

                                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                                            Disetujui
                                                        </span>

                                                    @elseif ($logbook->status_verifikasi == 'revisi')

                                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                                            Revisi
                                                        </span>

                                                    @else

                                                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                                            Menunggu
                                                        </span>

                                                    @endif

                                                </div>

                                                <div>

                                                    <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                        Catatan Guru Pamong
                                                    </p>

                                                    @if ($logbook->catatan_guru_pamong)

                                                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3">

                                                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                                                {{ $logbook->catatan_guru_pamong }}
                                                            </p>

                                                        </div>

                                                    @else

                                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">

                                                            <p class="text-sm text-gray-400">
                                                                Belum ada catatan.
                                                            </p>

                                                        </div>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">

                                            <button
                                                type="button"
                                                @click="showDetail = false"
                                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300"
                                            >
                                                Tutup
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div
                                    x-show="showVerifikasi"
                                    x-cloak
                                    class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4"
                                    @keydown.escape.window="showVerifikasi = false"
                                >

                                    <div
                                        class="bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-hidden flex flex-col"
                                        @click.stop
                                    >

                                        <div class="flex items-center justify-between px-6 py-4 border-b">

                                            <div>

                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    Verifikasi Logbook
                                                </h3>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $logbook->penempatan->mahasiswa->user->name }}
                                                </p>

                                            </div>

                                            <button
                                                type="button"
                                                @click="showVerifikasi = false"
                                                class="text-gray-400 hover:text-gray-700 text-2xl leading-none"
                                            >
                                                ×
                                            </button>

                                        </div>

                                        <div class="px-6 py-5 overflow-y-auto">

                                            <div class="mb-5">

                                                <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                    Status Saat Ini
                                                </p>

                                                @if ($logbook->status_verifikasi == 'disetujui')

                                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                                        Disetujui
                                                    </span>

                                                @elseif ($logbook->status_verifikasi == 'revisi')

                                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                                        Revisi
                                                    </span>

                                                @else

                                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                                        Menunggu
                                                    </span>

                                                @endif

                                            </div>

                                            <div class="mb-5">

                                                <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                    Tanggal
                                                </p>

                                                <p class="text-sm text-gray-800">
                                                    {{ \Carbon\Carbon::parse($logbook->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                                </p>

                                            </div>

                                            <div class="mb-5">

                                                <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                    Kegiatan
                                                </p>

                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $logbook->kegiatan }}
                                                </p>

                                            </div>

                                            <div class="mb-5">

                                                <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                    Detail Kegiatan
                                                </p>

                                                @if ($logbook->detail_kegiatan)

                                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">

                                                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                                            {{ $logbook->detail_kegiatan }}
                                                        </p>

                                                    </div>

                                                @else

                                                    <p class="text-sm text-gray-400">
                                                        Tidak ada detail kegiatan.
                                                    </p>

                                                @endif

                                            </div>

                                            <div class="mb-5">

                                                <p class="text-xs font-medium text-gray-400 uppercase mb-2">
                                                    Dokumentasi
                                                </p>

                                                @if ($logbook->dokumentasi)

                                                    <div class="border border-gray-200 rounded-lg bg-gray-50 p-2 w-fit">

                                                        <img
                                                            src="{{ Storage::url($logbook->dokumentasi) }}"
                                                            alt="Dokumentasi Logbook"
                                                            class="w-52 h-40 object-contain rounded-lg"
                                                        >

                                                    </div>

                                                @else

                                                    <p class="text-sm text-gray-400">
                                                        Tidak ada dokumentasi.
                                                    </p>

                                                @endif

                                            </div>

                                            <div>

                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Catatan Guru Pamong
                                                </label>

                                                <textarea
                                                    x-model="catatan"
                                                    rows="5"
                                                    maxlength="1000"
                                                    @input="catatanError = false"
                                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Berikan catatan untuk mahasiswa..."
                                                ></textarea>

                                                <p
                                                    x-show="catatanError"
                                                    x-cloak
                                                    class="text-xs text-red-500 mt-2"
                                                >
                                                    Catatan wajib diisi sebelum logbook diverifikasi.
                                                </p>

                                            </div>

                                        </div>

                                        <div class="px-6 py-4 border-t bg-gray-50">

                                            <form
                                                action="{{ route('guru-pamong.logbook.approve', $logbook->id) }}"
                                                method="POST"
                                                class="mb-2"
                                                @submit="if (!catatan.trim()) { catatanError = true; $event.preventDefault(); }"
                                            >

                                                @csrf
                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="catatan_guru_pamong"
                                                    x-model="catatan"
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full px-4 py-2.5 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700"
                                                >
                                                    ✓ Setujui Logbook
                                                </button>

                                            </form>

                                            <form
                                                action="{{ route('guru-pamong.logbook.revisi', $logbook->id) }}"
                                                method="POST"
                                                class="mb-2"
                                                @submit="if (!catatan.trim()) { catatanError = true; $event.preventDefault(); }"
                                            >

                                                @csrf
                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="catatan_guru_pamong"
                                                    x-model="catatan"
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700"
                                                >
                                                    ↻ Minta Revisi
                                                </button>

                                            </form>

                                            <button
                                                type="button"
                                                @click="showVerifikasi = false"
                                                class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300"
                                            >
                                                Batal
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="p-8 text-center text-gray-500"
                        >

                            @if (($search ?? '') || ($status ?? 'semua') !== 'semua')

                                Data logbook tidak ditemukan.

                            @else

                                Belum ada data logbook.

                            @endif

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $logbooks->appends(request()->query())->links() }}
    </div>

</x-layouts.guru-pamong>