<x-layouts.admin title="Tambah Dosen Pembimbing" subtitle="Tambahkan data dosen pembimbing baru">

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
        <form action="{{ route('admin.dosen-pembimbing.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">NIP/NIDN</label>
                <input type="text" name="nip_nidn" value="{{ old('nip_nidn') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Universitas</label>
                <input type="text" name="universitas" value="{{ old('universitas') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('admin.dosen-pembimbing.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>