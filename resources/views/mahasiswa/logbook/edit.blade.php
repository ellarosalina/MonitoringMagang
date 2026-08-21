<x-layouts.mahasiswa title="Edit Logbook" subtitle="">

    <div class="p-6">

        <div class="max-w-2xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Logbook
            </h1>


            @if ($errors->any())

                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="bg-white shadow-sm rounded-lg p-6">

                <form
                    action="{{ route('mahasiswa.logbook.update', $logbook->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="mb-5">

                        <label class="block font-medium text-gray-800 mb-2">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ old('tanggal', \Carbon\Carbon::parse($logbook->tanggal)->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >

                    </div>


                    <div class="mb-5">

                        <label class="block font-medium text-gray-800 mb-2">
                            Kegiatan
                        </label>

                        <input
                            type="text"
                            name="kegiatan"
                            value="{{ old('kegiatan', $logbook->kegiatan) }}"
                            placeholder="Contoh: Sosialisasi Kebijakan Baru"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >

                    </div>


                    <div class="mb-5">

                        <label class="block font-medium text-gray-800 mb-2">
                            Detail Kegiatan
                        </label>

                        <textarea
                            name="detail_kegiatan"
                            rows="6"
                            placeholder="Jelaskan secara lengkap kegiatan yang dilakukan hari ini..."
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >{{ old('detail_kegiatan', $logbook->detail_kegiatan) }}</textarea>

                        <p class="text-sm text-gray-500 mt-1">
                            Jelaskan aktivitas, tugas yang dikerjakan, dan hasil kegiatan.
                        </p>

                    </div>


                    <div class="mb-5">

                        <label class="block font-medium text-gray-800 mb-2">
                            Dokumentasi
                        </label>


                        @if ($logbook->dokumentasi)

                            <div class="mb-3">

                                <img
                                    src="{{ Storage::url($logbook->dokumentasi) }}"
                                    alt="Dokumentasi"
                                    class="w-40 rounded-lg border"
                                >

                                <p class="text-sm text-gray-500 mt-2">
                                    Foto saat ini. Upload foto baru jika ingin menggantinya.
                                </p>

                            </div>

                        @endif


                        <input
                            type="file"
                            name="dokumentasi"
                            accept="image/*"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >

                        <p class="text-sm text-gray-500 mt-1">
                            Format JPG/PNG, maksimal 2MB.
                        </p>

                    </div>


                    <div class="mb-5 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">

                        <p class="text-sm text-gray-700">

                            <strong>Catatan:</strong>

                            Jika logbook diedit, status verifikasi akan kembali menjadi
                            <strong>Menunggu</strong> dan harus diverifikasi ulang oleh Guru Pamong.

                        </p>

                    </div>


                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Update
                        </button>


                        <a
                            href="{{ route('mahasiswa.logbook.index') }}"
                            class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts.mahasiswa>