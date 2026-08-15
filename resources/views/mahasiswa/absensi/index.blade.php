<x-layouts.mahasiswa>

    <div class="p-6">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Absensi Saya
            </h1>

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

            @if (!$penempatan)

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-gray-500">
                        Anda belum memiliki penempatan magang.
                        Hubungi Admin GTK.
                    </p>
                </div>

            @else

                <div class="bg-white shadow-sm rounded-lg p-6">

                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">
                            Penempatan:
                            <strong>
                                {{ $penempatan->sekolah->nama_sekolah }}
                            </strong>
                            ({{ $penempatan->periode }})
                        </p>
                    </div>

                    <a
                        href="{{ route('mahasiswa.absensi.create') }}"
                        class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        + Isi Absensi Hari Ini
                    </a>

                    <div class="overflow-x-auto">

                        <table class="w-full text-left border-collapse">

                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="p-3 font-semibold">
                                        Tanggal
                                    </th>

                                    <th class="p-3 font-semibold">
                                        Jam Masuk
                                    </th>

                                    <th class="p-3 font-semibold">
                                        Jam Pulang
                                    </th>

                                    <th class="p-3 font-semibold">
                                        Status
                                    </th>

                                    <th class="p-3 font-semibold">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($absensis as $absensi)

                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="p-3">
                                            {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}
                                        </td>

                                        <td class="p-3">
                                            {{ $absensi->jam_masuk ?? '-' }}
                                        </td>

                                        <td class="p-3">
                                            {{ $absensi->jam_pulang ?? '-' }}
                                        </td>

                                        <td class="p-3">
                                            {{ ucfirst($absensi->status) }}
                                        </td>

                                        <td class="p-3">
                                            <a
                                                href="{{ route('mahasiswa.absensi.edit', $absensi->id) }}"
                                                class="text-blue-600 hover:underline"
                                            >
                                                Edit
                                            </a>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="5"
                                            class="p-4 text-center text-gray-500"
                                        >
                                            Belum ada data absensi.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-6">
                        {{ $absensis->links() }}
                    </div>

                </div>

            @endif

        </div>
    </div>

</x-layouts.mahasiswa>