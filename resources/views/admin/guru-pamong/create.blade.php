<x-layouts.admin title="Tambah Guru Pamong" subtitle="Buat akun dan data guru pamong baru">

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
        <form action="{{ route('admin.guru-pamong.store') }}" method="POST">
            @csrf

            <h3 class="font-semibold text-lg mb-2 mt-2">Akun Login</h3>

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter.</p>
            </div>

            <h3 class="font-semibold text-lg mb-2 mt-6">Data Guru Pamong</h3>

            <div class="mb-4">
                <label class="block font-medium mb-1">Sekolah</label>
                <select name="sekolah_id" class="w-full border rounded p-2 searchable-select">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach ($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Mata Pelajaran</label>
                <input type="text" name="mapel" value="{{ old('mapel') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('admin.guru-pamong.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>