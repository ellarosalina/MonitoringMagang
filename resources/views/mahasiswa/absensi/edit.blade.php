<x-layouts.mahasiswa>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Absensi
            </h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('mahasiswa.absensi.update', $absensi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Hari --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Hari
                        </label>

                        <input
                            type="text"
                            value="{{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->translatedFormat('l') }}"
                            readonly
                            class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700"
                        >
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Tanggal
                        </label>

                        <input
                            type="text"
                            value="{{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->translatedFormat('d F Y') }}"
                            readonly
                            class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-700"
                        >
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            required
                        >
                            <option value="hadir" {{ $absensi->status == 'hadir' ? 'selected' : '' }}>
                                Hadir
                            </option>

                            <option value="izin" {{ $absensi->status == 'izin' ? 'selected' : '' }}>
                                Izin
                            </option>

                            <option value="sakit" {{ $absensi->status == 'sakit' ? 'selected' : '' }}>
                                Sakit
                            </option>

                            <option value="alpa" {{ $absensi->status == 'alpa' ? 'selected' : '' }}>
                                Alpa
                            </option>
                        </select>
                    </div>

                    {{-- Jam Masuk --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Jam Masuk
                        </label>

                        <input
                            type="time"
                            name="jam_masuk"
                            value="{{ old('jam_masuk', $absensi->jam_masuk) }}"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    {{-- Jam Pulang --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Jam Pulang
                        </label>

                        <input
                            type="time"
                            name="jam_pulang"
                            value="{{ old('jam_pulang', $absensi->jam_pulang) }}"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    <div class="flex gap-2 mt-6">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Update
                        </button>

                        <a
                            href="{{ route('mahasiswa.absensi.index') }}"
                            class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>
        </div>
    </div>

</x-layouts.mahasiswa>