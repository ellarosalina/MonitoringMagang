<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Logbook
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">


                {{-- ================================================= --}}
                {{-- ERROR UMUM --}}
                {{-- ================================================= --}}

                @if (session('error'))

                    <div class="mb-5 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">

                        <p class="font-semibold">
                            Logbook tidak dapat diperbarui
                        </p>

                        <p class="text-sm mt-1">
                            {{ session('error') }}
                        </p>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- ERROR VALIDASI --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div class="mb-5 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">

                        <p class="font-semibold mb-1">
                            Terdapat kesalahan pada data:
                        </p>

                        <ul class="list-disc list-inside text-sm">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                @if ($logbook->status_verifikasi === 'revisi')

                    <div class="mb-5 p-4 bg-orange-50 border border-orange-200 rounded-lg">

                        <p class="font-semibold text-orange-700">
                            Logbook perlu diperbaiki
                        </p>


                        @if ($logbook->catatan_guru_pamong)

                            <p class="text-sm text-orange-700 mt-1">
                                Catatan Guru Pamong:
                            </p>

                            <p class="text-sm text-orange-600 mt-1">
                                {{ $logbook->catatan_guru_pamong }}
                            </p>

                        @endif

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- FORM --}}
                {{-- ================================================= --}}

                <form
                    action="{{ route('mahasiswa.logbook.update', $logbook->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @method('PUT')


                    {{-- TANGGAL --}}

                    <div class="mb-5">

                        <label
                            for="tanggal"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tanggal
                        </label>


                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            value="{{ old('tanggal', \Carbon\Carbon::parse($logbook->tanggal)->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm
                                   focus:border-blue-500 focus:ring-blue-500
                                   @error('tanggal') border-red-500 @enderror"
                            required
                        >


                        @error('tanggal')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- KEGIATAN --}}

                    <div class="mb-5">

                        <label
                            for="kegiatan"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Kegiatan
                        </label>


                        <textarea
                            name="kegiatan"
                            id="kegiatan"
                            rows="5"
                            class="w-full rounded-lg border-gray-300 shadow-sm
                                   focus:border-blue-500 focus:ring-blue-500
                                   @error('kegiatan') border-red-500 @enderror"
                            required
                        >{{ old('kegiatan', $logbook->kegiatan) }}</textarea>


                        @error('kegiatan')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- DOKUMENTASI LAMA --}}

                    @if ($logbook->dokumentasi)

                        <div class="mb-5">

                            <p class="text-sm font-medium text-gray-700 mb-2">
                                Dokumentasi Saat Ini
                            </p>


                            <img
                                src="{{ Storage::url($logbook->dokumentasi) }}"
                                alt="Dokumentasi saat ini"
                                class="w-48 h-48 object-cover rounded-lg border"
                            >

                        </div>

                    @endif



                    {{-- DOKUMENTASI BARU --}}

                    <div class="mb-6">

                        <label
                            for="dokumentasi"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Ganti Dokumentasi
                        </label>


                        <input
                            type="file"
                            name="dokumentasi"
                            id="dokumentasi"
                            accept="image/*"
                            class="w-full rounded-lg border border-gray-300 p-2
                                   focus:border-blue-500 focus:ring-blue-500"
                        >


                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ingin mengganti dokumentasi.
                            Maksimal 2 MB.
                        </p>


                        @error('dokumentasi')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- BUTTON --}}

                    <div class="flex items-center gap-3">

                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg
                                   hover:bg-blue-700 transition"
                        >
                            Simpan Perubahan
                        </button>


                        <a
                            href="{{ route('mahasiswa.logbook.index') }}"
                            class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg
                                   hover:bg-gray-300 transition"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>