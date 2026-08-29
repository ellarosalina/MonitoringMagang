<x-layouts.guru-pamong title="Dashboard" subtitle="">

    <div class="bg-white rounded-lg shadow-sm p-6 mb-5">
        <p class="text-gray-800">
            Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span> 👋
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Pantau mahasiswa bimbingan dan aktivitas magang mereka.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">

        <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Mahasiswa Bimbingan
                    </p>
                    <p class="text-2xl font-semibold text-gray-800 mt-2">
                        {{ $mahasiswaCount }}
                    </p>
                </div>

                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19a4 4 0 00-8 0m4-8a3 3 0 100-6 3 3 0 000 6zm7-1a2 2 0 100-4 2 2 0 000 4zm-1 3a3 3 0 013 3"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Menunggu Verifikasi
                    </p>
                    <p class="text-2xl font-semibold text-gray-800 mt-2">
                        {{ $menungguVerifikasi }}
                    </p>
                </div>

                <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Logbook Disetujui
                    </p>
                    <p class="text-2xl font-semibold text-gray-800 mt-2">
                        {{ $logbookDisetujui }}
                    </p>
                </div>

                <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b">
            <h2 class="text-base font-semibold text-gray-800">
                Mahasiswa Bimbingan
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Daftar mahasiswa yang sedang Anda bimbing.
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b">

                    <tr>
                        <th class="p-3 text-sm font-semibold text-gray-600 w-12">
                            No
                        </th>

                        <th class="p-3 text-sm font-semibold text-gray-600">
                            Mahasiswa
                        </th>

                        <th class="p-3 text-sm font-semibold text-gray-600">
                            Sekolah
                        </th>

                        <th class="p-3 text-sm font-semibold text-gray-600">
                            Periode
                        </th>

                        <th class="p-3 text-sm font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="p-3 text-sm font-semibold text-gray-600">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($mahasiswaBimbingan as $penempatan)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3 text-sm">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-3 text-sm">
                                {{ $penempatan->mahasiswa->user->name }}
                            </td>

                            <td class="p-3 text-sm">
                                {{ $penempatan->sekolah->nama_sekolah }}
                            </td>

                            <td class="p-3 text-sm">
                                {{ $penempatan->periode }}
                            </td>

                            <td class="p-3 text-sm">

                                <span class="px-2 py-1 text-xs rounded
                                    @if($penempatan->status == 'berjalan')
                                        bg-blue-100 text-blue-700
                                    @elseif($penempatan->status == 'selesai')
                                        bg-green-100 text-green-700
                                    @elseif($penempatan->status == 'dibatalkan')
                                        bg-red-100 text-red-700
                                    @else
                                        bg-yellow-100 text-yellow-700
                                    @endif
                                ">
                                    {{ ucfirst($penempatan->status) }}
                                </span>

                            </td>

                            <td class="p-3 text-sm">

                                <a
                                    href="{{ route('guru-pamong.mahasiswa.index') }}"
                                    title="Lihat Mahasiswa"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition"
                                >

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="p-5 text-center text-sm text-gray-500">
                                Belum ada mahasiswa bimbingan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.guru-pamong>