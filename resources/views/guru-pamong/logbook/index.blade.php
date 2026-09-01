<x-layouts.guru-pamong title="Verifikasi Logbook" subtitle="Pantau, lihat, dan verifikasi logbook mahasiswa bimbingan">

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

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside text-sm">
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

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">NO</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">MAHASISWA</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">TANGGAL</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">KEGIATAN</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">DOKUMENTASI</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">STATUS</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">CATATAN</th>
                        <th class="px-5 py-4 text-left font-semibold text-gray-700">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logbooks as $index => $logbook)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-5 py-4 text-gray-600 align-top">
                                {{ $logbooks->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-gray-800">
                                    {{ $logbook->penempatan->mahasiswa->user->name }}
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($logbook->tanggal)->locale('id')->translatedFormat('l') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-gray-800">
                                    {{ $logbook->kegiatan }}
                                </div>

                                @if ($logbook->detail_kegiatan)
                                    <div class="text-xs text-gray-500 mt-1 max-w-xs">
                                        {{ \Illuminate\Support\Str::limit($logbook->detail_kegiatan, 100) }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4 align-top">
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

                            <td class="px-5 py-4 align-top">
                                @if ($logbook->status_verifikasi === 'disetujui')
                                    <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        Disetujui
                                    </span>
                                @elseif ($logbook->status_verifikasi === 'revisi')
                                    <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        Revisi
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                        Menunggu
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 align-top">
                                @if ($logbook->catatan_guru_pamong)
                                    <div class="text-xs text-gray-600 max-w-xs">
                                        {{ \Illuminate\Support\Str::limit($logbook->catatan_guru_pamong, 80) }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">
                                        -
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div
                                    x-data="{
                                        showDetail: false,
                                        showVerifikasi: false,
                                        catatan: @js($logbook->catatan_guru_pamong ?? '')
                                    }"
                                >

                                    <button
                                        type="button"
                                        @click="showDetail = true"
                                        title="Lihat Detail"
                                        class="inline-flex items-center justify-center w-8 h-8 bg-gray-50 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100 transition"
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
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
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
                                                            <div class="border border-gray-200 rounded-lg bg-gray-50 p-3">
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

                                                        @if ($logbook->status_verifikasi === 'disetujui')
                                                            <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                                Disetujui
                                                            </span>
                                                        @elseif ($logbook->status_verifikasi === 'revisi')
                                                            <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                                                Revisi
                                                            </span>
                                                        @else
                                                            <span class="inline-flex px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
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

                                            <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-2">

                                                <button
                                                    type="button"
                                                    @click="showDetail = false"
                                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300"
                                                >
                                                    Tutup
                                                </button>

                                                <button
                                                    type="button"
                                                    @click="showDetail = false; showVerifikasi = true"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 cursor-pointer"
                                                >
                                                    Verifikasi
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
                                                    @click="showVerifikasi = false; showDetail = true"
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

                                                    @if ($logbook->status_verifikasi === 'disetujui')
                                                        <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                            Disetujui
                                                        </span>
                                                    @elseif ($logbook->status_verifikasi === 'revisi')
                                                        <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                                            Revisi
                                                        </span>
                                                    @else
                                                        <span class="inline-flex px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                            Menunggu
                                                        </span>
                                                    @endif
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
                                                        <div class="bg-gray-50 border rounded-lg p-3">
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

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Catatan Guru Pamong
                                                    </label>

                                                    <textarea
                                                        x-model="catatan"
                                                        rows="5"
                                                        maxlength="1000"
                                                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Berikan catatan untuk mahasiswa..."
                                                    ></textarea>

                                                    <p class="text-xs text-gray-400 mt-1">
                                                        Catatan akan ditampilkan kepada mahasiswa.
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="px-6 py-4 border-t bg-gray-50">

                                                <form
                                                    action="{{ route('guru-pamong.logbook.approve', $logbook->id) }}"
                                                    method="POST"
                                                    class="mb-2"
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
                                                    @click="showVerifikasi = false; showDetail = true"
                                                    class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300"
                                                >
                                                    Kembali ke Detail
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
                                class="px-5 py-10 text-center text-gray-500"
                            >
                                Belum ada logbook dari mahasiswa bimbingan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logbooks->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $logbooks->links() }}
            </div>
        @endif

    </div>

</x-layouts.guru-pamong>