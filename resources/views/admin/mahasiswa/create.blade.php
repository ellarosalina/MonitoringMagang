<x-layouts.admin title="Tambah Mahasiswa" subtitle="Buat akun dan data mahasiswa baru">

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
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
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

            <h3 class="font-semibold text-lg mb-2 mt-6">Data Mahasiswa</h3>

            <div class="mb-4">
                <label class="block font-medium mb-1">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Universitas</label>
                <input type="text" name="universitas" value="{{ old('universitas') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Fakultas</label>
                <input type="text" name="fakultas" value="{{ old('fakultas') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi</label>
                <input type="text" name="prodi" value="{{ old('prodi') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat') }}</textarea>
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('admin.mahasiswa.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>