<x-layouts.mahasiswa title="Edit Logbook" subtitle="">

    <div class="p-6">

        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- HEADER --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">

                    <h1 class="text-lg font-semibold text-gray-800">
                        Edit Logbook
                    </h1>

                    <a
                        href="{{ route('mahasiswa.logbook.index') }}"
                        class="text-gray-400 hover:text-gray-600 transition"
                        title="Kembali"
                    >
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
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </a>

                </div>


                {{-- ERROR --}}
                @if ($errors->any())

                    <div class="mx-6 mt-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">

                        <ul class="list-disc list-inside text-sm space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- FORM --}}
                <form
                    action="{{ route('mahasiswa.logbook.update', $logbook->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="px-6 py-5 space-y-5">


                        {{-- TANGGAL --}}
                        <div>

                            <label class="block text-xs font-medium text-gray-400 uppercase mb-2">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                value="{{ old('tanggal', \Carbon\Carbon::parse($logbook->tanggal)->format('Y-m-d')) }}"
                                class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >

                        </div>


                        {{-- KEGIATAN --}}
                        <div>

                            <label class="block text-xs font-medium text-gray-400 uppercase mb-2">
                                Kegiatan
                            </label>

                            <input
                                type="text"
                                name="kegiatan"
                                value="{{ old('kegiatan', $logbook->kegiatan) }}"
                                placeholder="Contoh: Sosialisasi Kebijakan Baru"
                                class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >

                        </div>


                        {{-- DETAIL KEGIATAN --}}
                        <div>

                            <label class="block text-xs font-medium text-gray-400 uppercase mb-2">
                                Detail Kegiatan
                            </label>

                            <textarea
                                name="detail_kegiatan"
                                rows="7"
                                placeholder="Jelaskan secara lengkap kegiatan yang dilakukan hari ini..."
                                class="w-full px-3 py-3 border border-gray-200 rounded-lg text-sm text-gray-800 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >{{ old('detail_kegiatan', $logbook->detail_kegiatan) }}</textarea>

                            <p class="text-xs text-gray-400 mt-2">
                                Jelaskan aktivitas, tugas yang dikerjakan, dan hasil kegiatan.
                            </p>

                        </div>


                        {{-- DOKUMENTASI --}}
                        <div>

                            <label class="block text-xs font-medium text-gray-400 uppercase mb-2">
                                Dokumentasi
                            </label>


                            @if ($logbook->dokumentasi)

                                <div class="mb-3">

                                    <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">

                                        <img
                                            src="{{ Storage::url($logbook->dokumentasi) }}"
                                            alt="Dokumentasi"
                                            class="w-full max-h-64 object-contain rounded-lg"
                                        >

                                    </div>

                                    <p class="text-xs text-gray-400 mt-2">
                                        Foto saat ini. Upload foto baru jika ingin menggantinya.
                                    </p>

                                </div>

                            @endif


                            <input
                                type="file"
                                name="dokumentasi"
                                accept="image/*"
                                class="w-full border border-gray-200 rounded-lg p-2.5 text-sm text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                Format JPG/PNG, maksimal 2MB.
                            </p>

                        </div>


                        {{-- CATATAN --}}
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">

                            <div class="flex gap-3">

                                <svg
                                    class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"
                                    />

                                </svg>

                                <p class="text-sm text-gray-700">

                                    <strong>Catatan:</strong>

                                    Jika logbook diedit, status verifikasi akan kembali menjadi
                                    <strong>Menunggu</strong> dan harus diverifikasi ulang oleh Guru Pamong.

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-end gap-2">

                        <a
                            href="{{ route('mahasiswa.logbook.index') }}"
                            class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts.mahasiswa>