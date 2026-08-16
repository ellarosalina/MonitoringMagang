<x-layouts.admin title="Tambah Penempatan" subtitle="Assign mahasiswa ke sekolah, guru pamong, dan dosen pembimbing">

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.penempatan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Mahasiswa</label>
                 <select name="mahasiswa_id" class="w-full border rounded p-2 searchable-select" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach ($mahasiswas as $mahasiswa)
                        <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id') == $mahasiswa->id ? 'selected' : '' }}>
                            {{ $mahasiswa->user->name }} ({{ $mahasiswa->nim }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Sekolah</label>
                <select name="sekolah_id" class="w-full border rounded p-2 searchable-select" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach ($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Guru Pamong</label>
                <select name="guru_pamong_id" class="w-full border rounded p-2 searchable-select" required>
                    <option value="">-- Pilih Guru Pamong --</option>
                    @foreach ($guruPamongs as $guruPamong)
                        <option value="{{ $guruPamong->id }}" {{ old('guru_pamong_id') == $guruPamong->id ? 'selected' : '' }}>
                            {{ $guruPamong->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Periode</label>
                <input type="text" name="periode" value="{{ old('periode') }}" placeholder="Contoh: Ganjil 2026/2027" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full border rounded p-2" required>
blade
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2" required>
                    <option value="menunggu">Menunggu</option>
                    <option value="berjalan">Berjalan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('admin.penempatan.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

    <script>
        window.addEventListener('load', function () {
            const allGuruPamongs = @json($guruPamongs->map(fn($g) => ['id' => (string) $g->id, 'name' => $g->user->name, 'sekolah_id' => (string) $g->sekolah_id]));

            const sekolahSelect = document.querySelector('select[name="sekolah_id"]');

            function filterGuruPamong() {
                const sekolahId = sekolahSelect.value;
                const filtered = allGuruPamongs.filter(function (g) {
                    return g.sekolah_id === sekolahId;
                });

                const choicesData = filtered.length
                    ? filtered.map(function (g) { return { value: g.id, label: g.name }; })
                    : [{ value: '', label: '-- Tidak ada guru pamong di sekolah ini --', disabled: true }];

                const instance = window.choicesInstances && window.choicesInstances['guru_pamong_id'];
                if (instance) {
                    instance.clearStore();
                    instance.setChoices(choicesData, 'value', 'label', true);
                }
            }

            if (sekolahSelect) {
                filterGuruPamong();
                sekolahSelect.addEventListener('change', filterGuruPamong);
            }
        });
    </script>

</x-layouts.admin>