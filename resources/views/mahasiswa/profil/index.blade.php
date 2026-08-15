<x-layouts.mahasiswa title="Profil Saya" subtitle="Data diri dan pengaturan akun">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Data yang tidak bisa diubah --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Data Akademik</h3>

            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Nama</dt>
                    <dd class="font-medium">{{ $mahasiswa->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium">{{ $mahasiswa->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">NIM</dt>
                    <dd class="font-medium">{{ $mahasiswa->nim }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Universitas</dt>
                    <dd class="font-medium">{{ $mahasiswa->universitas ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Fakultas</dt>
                    <dd class="font-medium">{{ $mahasiswa->fakultas ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Program Studi</dt>
                    <dd class="font-medium">{{ $mahasiswa->prodi ?? '-' }}</dd>
                </div>
            </dl>

            <p class="text-xs text-gray-400 mt-4">Data di atas hanya dapat diubah oleh Admin GTK.</p>
        </div>

        {{-- Form yang bisa diubah --}}
        <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
            <h3 class="font-semibold text-gray-700 mb-4">Ubah Data Kontak & Password</h3>

            <form action="{{ route('mahasiswa.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1 text-sm">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1 text-sm">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                </div>

                <hr class="my-4">

                <p class="text-sm text-gray-500 mb-3">Kosongkan bagian di bawah ini jika tidak ingin mengubah password.</p>

                <div class="mb-4">
                    <label class="block font-medium mb-1 text-sm">Password Baru</label>
                    <input type="password" name="password" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1 text-sm">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded p-2">
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
            </form>
        </div>

    </div>

</x-layouts.mahasiswa>