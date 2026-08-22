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

        {{-- Data Akademik --}}
        <div class="bg-white rounded-lg shadow-sm p-6">

            <h3 class="font-semibold text-gray-700 mb-4">
                Data Akademik
            </h3>

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center mb-6">

                @if($mahasiswa->foto)

                    <img
                        src="{{ asset('storage/' . $mahasiswa->foto) }}"
                        alt="Foto Profil"
                        class="w-28 h-28 rounded-full object-cover border-4 border-gray-100 shadow-sm"
                    >

                @else

                    <div class="w-28 h-28 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-bold">
                        {{ strtoupper(substr($mahasiswa->user->name, 0, 1)) }}
                    </div>

                @endif

                <p class="mt-3 text-sm font-medium text-gray-700">
                    {{ $mahasiswa->user->name }}
                </p>

            </div>

            <dl class="space-y-3 text-sm">

                <div>
                    <dt class="text-gray-500">Nama</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->user->name }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->user->email }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">NIM</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->nim }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Universitas</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->universitas ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Fakultas</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->fakultas ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Program Studi</dt>
                    <dd class="font-medium">
                        {{ $mahasiswa->prodi ?? '-' }}
                    </dd>
                </div>

            </dl>

            <p class="text-xs text-gray-400 mt-4">
                Data akademik hanya dapat diubah oleh Admin GTK.
            </p>

        </div>


        {{-- Form Profil --}}
        <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">

            <h3 class="font-semibold text-gray-700 mb-4">
                Ubah Data Profil & Password
            </h3>

            <form
                action="{{ route('mahasiswa.profil.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
<div class="mb-6">

    <label class="block font-medium mb-2 text-sm">
        Foto Profil
    </label>

    <div class="flex items-center gap-4">

        <div class="flex-shrink-0">

            @if($mahasiswa->foto)

                <img
                    id="previewFoto"
                    src="{{ asset('storage/' . $mahasiswa->foto) }}"
                    alt="Foto Profil"
                    class="w-20 h-20 rounded-full object-cover border"
                >

            @else

                <div
                    id="previewFotoContainer"
                    class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-xl font-semibold overflow-hidden"
                >
                    <span id="previewInisial">
                        {{ strtoupper(substr($mahasiswa->user->name, 0, 1)) }}
                    </span>

                    <img
                        id="previewFoto"
                        src=""
                        alt="Preview Foto"
                        class="hidden w-full h-full rounded-full object-cover"
                    >
                </div>

            @endif

        </div>

        <div class="flex-1">

            <input
                type="file"
                name="foto"
                id="inputFoto"
                accept="image/jpeg,image/png"
                class="w-full border border-gray-300 rounded-lg p-2 text-sm"
            >

            <p class="text-xs text-gray-500 mt-1">
                JPG, JPEG, atau PNG. Maksimal 2 MB.
            </p>

            <p
                id="statusFoto"
                class="text-xs text-blue-600 mt-1 hidden"
            >
                Foto baru dipilih. Klik "Simpan Perubahan" untuk menyimpan.
            </p>

        </div>

    </div>

</div>


                {{-- Dosen Pembimbing --}}
                <div class="mb-4">

                    <label class="block font-medium mb-1 text-sm">
                        Dosen Pembimbing
                    </label>

                    <input
                        type="text"
                        name="dosen_pembimbing"
                        value="{{ old('dosen_pembimbing', $mahasiswa->dosen_pembimbing) }}"
                        placeholder="Nama dosen pembimbing dari kampus"
                        class="w-full border rounded p-2"
                    >

                </div>


                {{-- No HP --}}
                <div class="mb-4">

                    <label class="block font-medium mb-1 text-sm">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                        class="w-full border rounded p-2"
                    >

                </div>


                {{-- Alamat --}}
                <div class="mb-4">

                    <label class="block font-medium mb-1 text-sm">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="3"
                        class="w-full border rounded p-2"
                    >{{ old('alamat', $mahasiswa->alamat) }}</textarea>

                </div>


                <hr class="my-4">


                <p class="text-sm text-gray-500 mb-3">
                    Kosongkan bagian di bawah ini jika tidak ingin mengubah password.
                </p>


                {{-- Password --}}
                <div class="mb-4">

                    <label class="block font-medium mb-1 text-sm">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border rounded p-2"
                    >

                </div>


                {{-- Konfirmasi Password --}}
                <div class="mb-4">

                    <label class="block font-medium mb-1 text-sm">
                        Konfirmasi Password Baru
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full border rounded p-2"
                    >

                </div>


                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

            </form>

        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const inputFoto = document.getElementById('inputFoto');
        const previewFoto = document.getElementById('previewFoto');
        const previewInisial = document.getElementById('previewInisial');
        const statusFoto = document.getElementById('statusFoto');

        if (!inputFoto) {
            return;
        }

        inputFoto.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) {
                return;
            }

            // Pastikan file adalah gambar
            if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                alert('Foto harus berupa JPG, JPEG, atau PNG.');
                inputFoto.value = '';
                return;
            }

            // Maksimal 2 MB
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto maksimal 2 MB.');
                inputFoto.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {

                // Kalau sebelumnya sudah ada foto
                if (previewFoto) {

                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('hidden');

                }

                // Kalau sebelumnya belum ada foto
                if (previewInisial) {
                    previewInisial.classList.add('hidden');
                }

                if (statusFoto) {
                    statusFoto.classList.remove('hidden');
                }
            };

            reader.readAsDataURL(file);
        });

    });
</script>

</x-layouts.mahasiswa>