<x-layouts.guru-pamong title="Profil Saya" subtitle="Kelola data diri dan foto profil">

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

    <div class="bg-white rounded-lg shadow-sm p-6 max-w-2xl">

        <form
            action="{{ route('guru-pamong.profil.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="mb-6 flex items-center gap-4">

                <div class="flex-shrink-0">

                    @if (auth()->user()->foto)

                        <img
                            id="previewFoto"
                            src="{{ Storage::url(auth()->user()->foto) }}"
                            alt="Foto Profil"
                            class="w-20 h-20 rounded-full object-cover border"
                        >

                    @else

                        <div
                            id="previewFotoContainer"
                            class="w-20 h-20 rounded-full bg-slate-600
                                   text-white flex items-center justify-center
                                   text-2xl font-bold overflow-hidden"
                        >

                            <span id="previewInisial">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
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

                    <label class="block font-medium mb-1 text-sm">
                        Ganti Foto Profil
                    </label>

                    <input
                        type="file"
                        name="foto"
                        id="inputFoto"
                        accept="image/jpeg,image/png,image/jpg"
                        class="text-sm"
                    >

                    <p class="text-xs text-gray-500 mt-1">
                        JPG, JPEG, atau PNG. Maksimal 2MB.
                    </p>

                    <p
                        id="statusFoto"
                        class="text-xs text-blue-600 mt-1 hidden"
                    >
                        Foto baru dipilih. Klik "Simpan Perubahan" untuk menyimpan.
                    </p>

                </div>

            </div>

            <div class="mb-4">

                <label class="block font-medium mb-1">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    class="w-full border rounded p-2"
                >

            </div>

            <div class="mb-4">

                <label class="block font-medium mb-1">
                    Email
                </label>

                <input
                    type="text"
                    value="{{ auth()->user()->email }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    disabled
                >

                <p class="text-xs text-gray-500 mt-1">
                    Email tidak dapat diubah sendiri, hubungi Admin GTK.
                </p>

            </div>

            <div class="mb-4">

                <label class="block font-medium mb-1">
                    No. HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ old('no_hp', $guruPamong->no_hp) }}"
                    class="w-full border rounded p-2"
                >

            </div>

            <div class="mb-4">

                <label class="block font-medium mb-1">
                    Mata Pelajaran
                </label>

                <input
                    type="text"
                    name="mapel"
                    value="{{ old('mapel', $guruPamong->mapel) }}"
                    class="w-full border rounded p-2"
                >

            </div>

            <hr class="my-4">

            <p class="text-sm text-gray-500 mb-3">
                Kosongkan bagian di bawah ini jika tidak ingin mengubah password.
            </p>

            <div class="mb-4">

                <label class="block font-medium mb-1">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded p-2"
                >

            </div>

            <div class="mb-4">

                <label class="block font-medium mb-1">
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

                const allowedTypes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ];

                if (!allowedTypes.includes(file.type)) {

                    alert('Foto harus berupa JPG, JPEG, atau PNG.');

                    inputFoto.value = '';

                    if (statusFoto) {
                        statusFoto.classList.add('hidden');
                    }

                    return;
                }

                if (file.size > 2 * 1024 * 1024) {

                    alert('Ukuran foto maksimal 2 MB.');

                    inputFoto.value = '';

                    if (statusFoto) {
                        statusFoto.classList.add('hidden');
                    }

                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {

                    if (previewFoto) {

                        previewFoto.src = e.target.result;

                        previewFoto.classList.remove('hidden');

                    }

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

</x-layouts.guru-pamong>