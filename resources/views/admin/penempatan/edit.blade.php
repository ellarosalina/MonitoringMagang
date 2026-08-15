<x-layouts.admin title="Edit Penempatan" subtitle="Ubah data penempatan magang">

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
        <form action="{{ route('admin.penempatan.update', $penempatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Mahasiswa</label>
                <select name="mahasiswa_id" class="w-full border rounded p-2 searchable-select" required>
                    @foreach ($mahasiswas as $mahasiswa)
                        <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id', $penempatan->mahasiswa_id) == $mahasiswa->id ? 'selected' : '' }}>
                            {{ $mahasiswa->user->name }} ({{ $mahasiswa->nim }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Sekolah</label>
                <select name="sekolah_id" class="w-full border rounded p-2 searchable-select" required>
                    @foreach ($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id', $penempatan->sekolah_id) == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Guru Pamong</label>
                <select name="guru_pamong_id" class="w-full border rounded p-2 searchable-select" required>
                    @foreach ($guruPamongs as $guruPamong)
                        <option value="{{ $guruPamong->id }}" {{ old('guru_pamong_id', $penempatan->guru_pamong_id) == $guruPamong->id ? 'selected' : '' }}>
                            {{ $guruPamong->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Dosen Pembimbing</label>
                <select name="dosen_pembimbing_id" class="w-full border rounded p-2">
                    <option value="">-- Pilih Dosen Pembimbing --</option>
                    @foreach ($dosenPembimbings as $dosenPembimbing)
                        <option value="{{ $dosenPembimbing->id }}" {{ old('dosen_pembimbing_id', $penempatan->dosen_pembimbing_id) == $dosenPembimbing->id ? 'selected' : '' }}>
                            {{ $dosenPembimbing->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Periode</label>
               <input type="text" name="periode" value="{{ old('periode', $penempatan->periode) }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $penempatan->tanggal_mulai->format('Y-m-d')) }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $penempatan->tanggal_selesai->format('Y-m-d')) }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2" required>
                    <option value="menunggu" {{ $penempatan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="berjalan" {{ $penempatan->status == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="selesai" {{ $penempatan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $penempatan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('admin.penempatan.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>