<x-layouts.mahasiswa>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Isi Absensi
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

                <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ old('tanggal', date('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpa">Alpa</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Jam Masuk
                        </label>

                        <input
                            type="time"
                            name="jam_masuk"
                            value="{{ old('jam_masuk') }}"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Jam Pulang
                        </label>

                        <input
                            type="time"
                            name="jam_pulang"
                            value="{{ old('jam_pulang') }}"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Catatan (opsional)
                        </label>

                        <textarea
                            name="catatan"
                            rows="4"
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >{{ old('catatan') }}</textarea>
                    </div>

                    <div class="flex gap-2 mt-6">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            Simpan
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