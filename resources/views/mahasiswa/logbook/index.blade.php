<x-layouts.mahasiswa title="Logbook" subtitle="">
    <div class="space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">{{ session('error') }}</div>
        @endif

        @if (!$penempatan)
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <h2 class="text-lg font-semibold text-gray-800">Belum Ada Penempatan Magang</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan hubungi Admin GTK untuk informasi lebih lanjut.</p>
            </div>
        @else

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-5 border-b">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Daftar Logbook</h2>
                            <p class="text-sm text-gray-500 mt-1">Riwayat kegiatan magang kamu.</p>
                        </div>
                    </div>

                    {{-- FILTER + TAMBAH --}}
                    <div class="flex items-center justify-between mt-4">
                        <form method="GET" action="{{ route('mahasiswa.logbook.index') }}">
                            <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua Logbook</option>
                                <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="revisi" {{ $status == 'revisi' ? 'selected' : '' }}>Direvisi</option>
                            </select>
                        </form>

                        <a href="{{ route('mahasiswa.logbook.create') }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition">
                            + Tambah Logbook
                        </a>
                    </div>
                </div>

                {{-- TABEL --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs text-gray-500 uppercase">No</th>
                                <th class="px-5 py-4 text-left text-xs text-gray-500 uppercase">Tanggal</th>
                                <th class="px-5 py-4 text-left text-xs text-gray-500 uppercase">Kegiatan</th>
                                <th class="px-5 py-4 text-center text-xs text-gray-500 uppercase">Dokumentasi</th>
                                <th class="px-5 py-4 text-center text-xs text-gray-500 uppercase">Status</th>
                                <th class="px-5 py-4 text-left text-xs text-gray-500 uppercase">Catatan</th>
                                <th class="px-5 py-4 text-center text-xs text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($logbooks as $index => $logbook)
                                <tr class="hover:bg-gray-50">

                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $logbooks->firstItem() + $index }}
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <p class="font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="font-medium text-gray-800">{{ $logbook->kegiatan }}</p>
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        @if ($logbook->dokumentasi)
                                            <img src="{{ Storage::url($logbook->dokumentasi) }}" alt="Dokumentasi" class="w-20 h-14 object-cover rounded-lg mx-auto">
                                        @else
                                            <span class="text-xs text-gray-400">Tidak ada</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        @if ($logbook->status_verifikasi === 'disetujui')
                                            <span class="inline-flex px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs">Disetujui</span>
                                        @elseif ($logbook->status_verifikasi === 'revisi')
                                            <span class="inline-flex px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs">Direvisi</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Menunggu</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $logbook->catatan_guru_pamong ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex justify-center items-center gap-2">

                                            {{-- LIHAT --}}
                                            <button type="button" onclick='lihatLogbook(@json($logbook))' title="Lihat" class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
                                                </svg>
                                            </button>

                                            {{-- EDIT --}}
                                            <a href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}" title="Edit" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </a>

                                            {{-- HAPUS --}}
                                            <button
                                                type="button"
                                                onclick="bukaModalHapus('{{ route('mahasiswa.logbook.destroy', $logbook->id) }}')"
                                                title="Hapus"
                                                class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6V7m-7 0h8"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                                </svg>
                                            </button>

                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <p class="text-sm text-gray-400">
                                            Tidak ada logbook dengan status
                                            <span class="font-semibold">
                                                {{ $status === 'menunggu' ? 'Menunggu' : ($status === 'disetujui' ? 'Disetujui' : ($status === 'revisi' ? 'Direvisi' : 'tersebut')) }}
                                            </span>.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- TOTAL --}}
                <div class="px-6 py-4 border-t bg-gray-50">
                    <p class="text-sm text-gray-500">
                        Total <span class="font-semibold text-gray-700">{{ $logbooks->total() }}</span> logbook
                    </p>
                </div>

                {{-- PAGINATION --}}
                @if ($logbooks->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $logbooks->links() }}
                    </div>
                @endif

            </div>
        @endif
    </div>

    {{-- MODAL DETAIL LOGBOOK --}}
    <div id="modalLogbook" class="hidden fixed inset-0 z-[9999] bg-black/50 p-4 items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden" onclick="event.stopPropagation()">

            <div class="flex-shrink-0 flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Detail Logbook</h2>
                <button type="button" onclick="tutupLogbook()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100">✕</button>
            </div>

            <div id="modalContent" class="flex-1 min-h-0 overflow-y-auto px-6 py-5">

                <div class="mb-5">
                    <p class="text-xs uppercase text-gray-400 mb-1">Tanggal</p>
                    <p id="detailTanggal" class="font-semibold text-gray-800">-</p>
                </div>

                <div class="mb-5">
                    <p class="text-xs uppercase text-gray-400 mb-1">Kegiatan</p>
                    <p id="detailKegiatan" class="font-semibold text-gray-800">-</p>
                </div>

                <div class="mb-5">
                    <p class="text-xs uppercase text-gray-400 mb-2">Detail Kegiatan</p>
                    <div id="detailKegiatanLengkap" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 whitespace-pre-line break-words leading-6">-</div>
                </div>

                <div class="mb-5">
                    <p class="text-xs uppercase text-gray-400 mb-2">Status</p>
                    <div id="detailStatus">-</div>
                </div>

                <div class="mb-5">
                    <p class="text-xs uppercase text-gray-400 mb-2">Catatan Guru Pamong</p>
                    <div id="detailCatatan" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 whitespace-pre-line break-words">-</div>
                </div>

                <div>
                    <p class="text-xs uppercase text-gray-400 mb-2">Dokumentasi</p>
                    <div id="detailDokumentasi">
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-sm text-gray-400">Tidak ada dokumentasi.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex-shrink-0 px-6 py-4 border-t bg-gray-50 flex justify-end">
                <button type="button" onclick="tutupLogbook()" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Tutup</button>
            </div>

        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="modalHapus" class="hidden fixed inset-0 z-[10000] bg-black/50 p-4 items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">

            <div class="px-6 py-5 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.84 21h16.32a2 2 0 001.73-3.14l-8.18-14a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Hapus Logbook?
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Konfirmasi penghapusan data
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5">
                <p class="text-sm text-gray-600 leading-6">
                    Apakah kamu yakin ingin menghapus logbook ini?
                    Data yang sudah dihapus tidak dapat dikembalikan.
                </p>
            </div>

            <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-2">
                <button
                    type="button"
                    onclick="tutupModalHapus()"
                    class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium transition"
                >
                    Batal
                </button>

                <form id="formHapusLogbook" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition"
                    >
                        Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function lihatLogbook(logbook) {
            document.getElementById('detailTanggal').textContent = formatTanggal(logbook.tanggal);
            document.getElementById('detailKegiatan').textContent = logbook.kegiatan || '-';
            document.getElementById('detailKegiatanLengkap').textContent = logbook.detail_kegiatan || '-';
            document.getElementById('detailCatatan').textContent = logbook.catatan_guru_pamong || '-';

            const detailStatus = document.getElementById('detailStatus');

            if (logbook.status_verifikasi === 'disetujui') {
                detailStatus.innerHTML = `<span class="inline-flex px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs">Disetujui</span>`;
            } else if (logbook.status_verifikasi === 'revisi') {
                detailStatus.innerHTML = `<span class="inline-flex px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs">Direvisi</span>`;
            } else {
                detailStatus.innerHTML = `<span class="inline-flex px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Menunggu</span>`;
            }

            const detailDokumentasi = document.getElementById('detailDokumentasi');

            if (logbook.dokumentasi) {
                const url = "{{ asset('storage') }}/" + logbook.dokumentasi;
                detailDokumentasi.innerHTML = `<div class="p-3 bg-gray-50 border border-gray-200 rounded-lg"><img src="${url}" alt="Dokumentasi Logbook" class="w-full max-h-80 object-contain rounded-lg"></div>`;
            } else {
                detailDokumentasi.innerHTML = `<div class="p-4 bg-gray-50 border border-gray-200 rounded-lg"><p class="text-sm text-gray-400">Tidak ada dokumentasi.</p></div>`;
            }

            const modal = document.getElementById('modalLogbook');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function tutupLogbook() {
            const modal = document.getElementById('modalLogbook');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function bukaModalHapus(url) {
            const modal = document.getElementById('modalHapus');
            const form = document.getElementById('formHapusLogbook');

            form.action = url;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function tutupModalHapus() {
            const modal = document.getElementById('modalHapus');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');

            document.getElementById('formHapusLogbook').action = '';
        }

        function formatTanggal(tanggal) {
            if (!tanggal) return '-';

            const date = new Date(tanggal);

            if (isNaN(date.getTime())) return tanggal;

            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        document.getElementById('modalLogbook').addEventListener('click', function(event) {
            if (event.target === this) {
                tutupLogbook();
            }
        });

        document.getElementById('modalHapus').addEventListener('click', function(event) {
            if (event.target === this) {
                tutupModalHapus();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                tutupLogbook();
                tutupModalHapus();
            }
        });
    </script>

</x-layouts.mahasiswa>