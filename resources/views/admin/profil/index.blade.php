<x-layouts.admin title="Profil" subtitle="Kelola informasi akun Anda">

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 items-start">

            <div class="space-y-4">

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">

                        <h2 class="text-base font-semibold text-gray-800">
                            Profil Admin
                        </h2>

                        <p class="text-xs text-gray-400 mt-1">
                            Informasi akun Anda
                        </p>

                    </div>

                    <div class="px-5 py-5">

                        <div class="flex items-center gap-4">

                            <div
                                id="foto-profil-admin"
                                class="w-20 h-20 rounded-full bg-slate-600 flex-shrink-0 flex items-center justify-center text-white text-2xl font-semibold overflow-hidden border border-gray-200"
                            >

                                @if ($user->foto)
                                    <img
                                        id="foto-profil-preview"
                                        src="{{ asset('storage/' . $user->foto) }}"
                                        alt="Foto Profil"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <span id="foto-profil-inisial">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                @endif

                            </div>

                            <div class="min-w-0">

                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $user->name }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1 break-all">
                                    {{ $user->email }}
                                </p>

                                <div class="flex items-center gap-2 mt-3">

                                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 border border-gray-200 text-gray-600 rounded-full text-xs font-medium">
                                        Admin GTK
                                    </span>

                                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">

                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>

                                        Aktif

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">

                        <h2 class="text-base font-semibold text-gray-800">
                            Informasi Akun
                        </h2>

                        <p class="text-xs text-gray-400 mt-1">
                            Detail akun yang sedang digunakan
                        </p>

                    </div>

                    <div class="px-5 py-5">

                        <div class="grid grid-cols-2 gap-y-4 gap-x-6">

                            <div>

                                <p class="text-xs text-gray-400">
                                    Nama
                                </p>

                                <p class="text-sm font-medium text-gray-700 mt-1">
                                    {{ $user->name }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Role
                                </p>

                                <p class="text-sm font-medium text-gray-700 mt-1">
                                    Admin GTK
                                </p>

                            </div>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Email
                                </p>

                                <p class="text-sm font-medium text-gray-700 mt-1 break-all">
                                    {{ $user->email }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Status
                                </p>

                                <span class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 bg-gray-50 border border-gray-200 text-gray-600 rounded-full text-xs font-medium">

                                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>

                                    Aktif

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="space-y-4">

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <h2 class="text-base font-semibold text-gray-800">
                                    Foto Profil
                                </h2>

                                <p class="text-xs text-gray-400 mt-1">
                                    Perbarui foto formal akun Anda
                                </p>

                            </div>

                            <label class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-200 text-gray-700 rounded-md text-xs font-medium cursor-pointer transition flex-shrink-0">

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M8 12l4-4m0 0l4 4m-4-4v9"
                                    />
                                </svg>

                                Pilih Foto

                                <input
                                    type="file"
                                    name="foto"
                                    id="foto"
                                    accept=".jpg,.jpeg,.png"
                                    class="hidden"
                                >

                            </label>

                        </div>

                    </div>

                    <div class="px-5 py-4">

                        <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-dashed border-gray-300 rounded-lg">

                            <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0">

                                <svg
                                    class="w-5 h-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0 flex-1">

                                <p
                                    id="nama-file"
                                    class="text-sm font-medium text-gray-700 truncate"
                                >
                                    Belum ada file baru dipilih
                                </p>

                                <p class="text-xs text-gray-400 mt-0.5">
                                    JPG, JPEG, PNG · Maksimal 2 MB
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">

                        <h2 class="text-base font-semibold text-gray-800">
                            Keamanan & Password
                        </h2>

                        <p class="text-xs text-gray-400 mt-1">
                            Amankan akun Anda dengan password yang kuat
                        </p>

                    </div>

                    <div class="px-5 py-5">

                        <div class="grid grid-cols-2 gap-4">

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Password Baru
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="w-full h-10 px-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-gray-50 focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-400 transition"
                                    placeholder="Masukkan password baru"
                                >

                                <p class="text-xs text-gray-400 mt-1.5">
                                    Minimal 8 karakter.
                                </p>

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full h-10 px-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-gray-50 focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-400 transition"
                                    placeholder="Ulangi password baru"
                                >

                            </div>

                        </div>

                        <div class="mt-4 px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-md">

                        </div>

                    </div>

                    <div class="px-5 py-4 border-t border-gray-100 flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 rounded-md text-sm font-medium shadow-sm transition"
                        >

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fotoInput = document.getElementById('foto');
            const fotoProfilAdmin = document.getElementById('foto-profil-admin');
            const namaFile = document.getElementById('nama-file');

            fotoInput.addEventListener('change', function () {
                const file = this.files[0];

                if (!file) {
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    namaFile.textContent = 'File yang dipilih bukan gambar.';
                    this.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    namaFile.textContent = 'Ukuran file maksimal 2 MB.';
                    this.value = '';
                    return;
                }

                namaFile.textContent = file.name;

                const reader = new FileReader();

                reader.onload = function (event) {
                    fotoProfilAdmin.innerHTML = `
                        <img
                            src="${event.target.result}"
                            alt="Preview Foto Profil"
                            class="w-full h-full object-cover"
                        >
                    `;
                };

                reader.readAsDataURL(file);
            });
        });
    </script>

</x-layouts.admin>