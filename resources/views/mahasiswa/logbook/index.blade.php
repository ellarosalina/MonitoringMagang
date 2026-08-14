<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Logbook Saya
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


                {{-- ===================================================== --}}
                {{-- NOTIFIKASI --}}
                {{-- ===================================================== --}}

                @if (session('success'))

                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>

                @endif


                @if (session('error'))

                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>

                @endif


                {{-- ===================================================== --}}
                {{-- BELUM ADA PENEMPATAN --}}
                {{-- ===================================================== --}}

                @if (!$penempatan)

                    <div class="text-center py-8">

                        <p class="text-gray-500">
                            Anda belum memiliki penempatan magang.
                        </p>

                        <p class="text-sm text-gray-400 mt-2">
                            Silakan hubungi Admin GTK untuk informasi lebih lanjut.
                        </p>

                    </div>


                @else


                    {{-- ================================================= --}}
                    {{-- HEADER --}}
                    {{-- ================================================= --}}

                    <div class="flex justify-between items-center mb-6">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Daftar Logbook
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Catatan kegiatan magang Anda
                            </p>

                        </div>


                        <a
                            href="{{ route('mahasiswa.logbook.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            + Tambah Logbook
                        </a>

                    </div>



                    {{-- ================================================= --}}
                    {{-- DAFTAR LOGBOOK --}}
                    {{-- ================================================= --}}

                    <div class="space-y-4">

                        @forelse ($logbooks as $logbook)

                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-sm transition">

                                {{-- HEADER --}}

                                <div class="p-5">

                                    <div class="flex justify-between items-start mb-3">

                                        {{-- TANGGAL --}}

                                        <div>

                                            <span class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}
                                            </span>

                                        </div>


                                        {{-- STATUS --}}

                                        @if ($logbook->status_verifikasi === 'disetujui')

                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                                Disetujui
                                            </span>

                                        @elseif ($logbook->status_verifikasi === 'revisi')

                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                                Revisi
                                            </span>

                                        @else

                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                                Menunggu Verifikasi
                                            </span>

                                        @endif

                                    </div>


                                    {{-- KEGIATAN --}}

                                    <div class="mb-4">

                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">
                                            Kegiatan
                                        </h4>

                                        <p class="text-gray-700">
                                            {{ $logbook->kegiatan }}
                                        </p>

                                    </div>


                                    {{-- DOKUMENTASI --}}

                                    @if ($logbook->dokumentasi)

                                        <div class="mb-4">

                                            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                                                Dokumentasi
                                            </h4>

                                            <img
                                                src="{{ Storage::url($logbook->dokumentasi) }}"
                                                alt="Dokumentasi kegiatan"
                                                class="w-48 h-48 object-cover rounded-lg border border-gray-200"
                                            >

                                        </div>

                                    @endif


                                    {{-- CATATAN GURU PAMONG --}}

                                    @if ($logbook->catatan_guru_pamong)

                                        <div class="bg-red-50 border border-red-200 p-3 rounded-lg mb-4">

                                            <p class="text-sm font-semibold text-red-700">
                                                Catatan Guru Pamong
                                            </p>

                                            <p class="text-sm text-red-600 mt-1">
                                                {{ $logbook->catatan_guru_pamong }}
                                            </p>

                                        </div>

                                    @endif

                                </div>


                                {{-- ================================================= --}}
                                {{-- ACTION --}}
                                {{-- ================================================= --}}

                                <div class="px-5 py-3 border-t border-gray-200 bg-gray-50 flex items-center gap-4">


                                    {{-- MENUNGGU VERIFIKASI --}}

                                    @if ($logbook->status_verifikasi === 'menunggu')

                                        <a
                                            href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}"
                                            class="text-sm text-blue-600 hover:text-blue-800 hover:underline"
                                        >
                                            Edit Logbook
                                        </a>


                                        <form
                                            action="{{ route('mahasiswa.logbook.destroy', $logbook->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus logbook tanggal {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-sm text-red-600 hover:text-red-800 hover:underline"
                                            >
                                                Hapus
                                            </button>

                                        </form>


                                    {{-- REVISI --}}

                                    @elseif ($logbook->status_verifikasi === 'revisi')

                                        <a
                                            href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}"
                                            class="text-sm text-orange-600 hover:text-orange-800 hover:underline"
                                        >
                                            Edit & Perbaiki
                                        </a>


                                    {{-- DISETUJUI --}}

                                    @elseif ($logbook->status_verifikasi === 'disetujui')

                                        <span class="text-sm text-green-600">
                                            ✓ Logbook telah disetujui
                                        </span>

                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-10 border border-dashed border-gray-300 rounded-lg">

                                <p class="text-gray-500">
                                    Belum ada data logbook.
                                </p>

                                <a
                                    href="{{ route('mahasiswa.logbook.create') }}"
                                    class="inline-block mt-3 text-blue-600 hover:underline text-sm"
                                >
                                    Tambahkan logbook pertama Anda
                                </a>

                            </div>

                        @endforelse

                    </div>


                    {{-- PAGINATION --}}

                    @if ($logbooks->hasPages())

                        <div class="mt-6">
                            {{ $logbooks->links() }}
                        </div>

                    @endif


                @endif

            </div>

        </div>

    </div>

</x-app-layout>