<x-layouts.admin title="Manajemen User" subtitle="Semua akun pengguna sistem">

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FILTER DAN PENCARIAN --}}
    <div class="flex flex-col lg:flex-row lg:items-center gap-3 mb-5">

        {{-- DROPDOWN ROLE --}}
        <div class="relative w-full lg:w-48">
            <select
                onchange="window.location.href = this.value"
                class="appearance-none w-full px-4 py-2 pr-10 rounded-lg text-sm border border-gray-300 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400"
            >

                {{-- SEMUA --}}
                <option
                    value="{{ route('admin.users.index', ['search' => $search ?? '']) }}"
                    {{ !$role ? 'selected' : '' }}
                >
                    Semua
                </option>

                {{-- ADMIN GTK --}}
                <option
                    value="{{ route('admin.users.index', ['role' => 'admin_gtk', 'search' => $search ?? '']) }}"
                    {{ $role == 'admin_gtk' ? 'selected' : '' }}
                >
                    Admin GTK
                </option>

                {{-- GURU PAMONG --}}
                <option
                    value="{{ route('admin.users.index', ['role' => 'guru_pamong', 'search' => $search ?? '']) }}"
                    {{ $role == 'guru_pamong' ? 'selected' : '' }}
                >
                    Guru Pamong
                </option>

                {{-- MAHASISWA --}}
                <option
                    value="{{ route('admin.users.index', ['role' => 'mahasiswa', 'search' => $search ?? '']) }}"
                    {{ $role == 'mahasiswa' ? 'selected' : '' }}
                >
                    Mahasiswa
                </option>

            </select>

            {{-- ICON DROPDOWN --}}
            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
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
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </div>
        </div>


        {{-- FORM PENCARIAN --}}
        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="w-full lg:w-auto flex gap-2"
        >

            {{-- PERTAHANKAN ROLE --}}
            @if ($role)
                <input
                    type="hidden"
                    name="role"
                    value="{{ $role }}"
                >
            @endif


            {{-- INPUT SEARCH --}}
            <div class="relative w-full lg:w-80">

                {{-- ICON SEARCH --}}
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
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
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"
                        />
                    </svg>
                </div>

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari nama atau email..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400"
                >

            </div>


            {{-- TOMBOL CARI --}}
            <button
                type="submit"
                title="Cari"
                class="inline-flex items-center justify-center px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition"
            >
                Cari
            </button>


            {{-- TOMBOL RESET --}}
            @if (!empty($search))
                <a
                    href="{{ route('admin.users.index', $role ? ['role' => $role] : []) }}"
                    title="Reset pencarian"
                    class="inline-flex items-center justify-center px-5 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition"
                >
                    Reset
                </a>
            @endif

        </form>


        {{-- TAMBAH ADMIN GTK --}}
        @if ($role == 'admin_gtk')

            <a
                href="{{ route('admin.users.create') }}"
                title="Tambah Admin GTK"
                class="inline-flex items-center justify-center px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition whitespace-nowrap"
            >
                <span class="mr-1 text-base">+</span>
                Tambah Admin GTK
            </a>

        @endif

    </div>


    {{-- TABEL USER --}}
    <div
        class="bg-white rounded-lg shadow-sm overflow-x-auto"
        x-data="{ openId: null, showPassword: false }"
    >

        <table class="w-full text-left">

            {{-- HEADER TABEL --}}
            <thead class="bg-gray-50 border-b">
                <tr>

                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">
                        No
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Nama
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Email
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Role
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Terdaftar
                    </th>

                    <th class="p-3 text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>
            </thead>


            {{-- DATA USER --}}
            <tbody>

                @forelse ($users as $user)

                    <tr class="border-b hover:bg-gray-50">

                        {{-- NOMOR --}}
                        <td class="p-3 text-sm">
                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                        </td>


                        {{-- NAMA --}}
                        <td class="p-3 text-sm">

                            {{ $user->name }}

                            @if ($user->id === auth()->id())
                                <span class="text-xs text-gray-400">
                                    (Anda)
                                </span>
                            @endif

                        </td>


                        {{-- EMAIL --}}
                        <td class="p-3 text-sm">
                            {{ $user->email }}
                        </td>


                        {{-- ROLE --}}
                        <td class="p-3 text-sm">

                            @foreach ($user->roles as $r)

                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs rounded
                                    @if($r->name == 'admin_gtk')
                                        bg-purple-100 text-purple-700
                                    @elseif($r->name == 'guru_pamong')
                                        bg-blue-100 text-blue-700
                                    @else
                                        bg-green-100 text-green-700
                                    @endif"
                                >
                                    {{ str_replace('_', ' ', ucfirst($r->name)) }}
                                </span>

                            @endforeach

                        </td>


                        {{-- TANGGAL TERDAFTAR --}}
                        <td class="p-3 text-sm">
                            {{ $user->created_at->format('d M Y') }}
                        </td>


                        {{-- AKSI --}}
                        <td class="p-3 text-sm">

                            <div class="flex items-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    type="button"
                                    title="Edit"
                                    aria-label="Edit {{ $user->name }}"
                                    @click="openId = {{ $user->id }}; showPassword = false"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md text-blue-600 bg-blue-50 border border-blue-200 hover:bg-blue-100 transition"
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
                                            d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-8.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 8.5-8.5z"
                                        />
                                    </svg>

                                </button>


                                {{-- HAPUS --}}
                                @if ($user->id !== auth()->id())

                                    <form
                                        action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin hapus akun {{ $user->name }}? Semua data terkait akun ini juga akan terhapus.')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus"
                                            aria-label="Hapus {{ $user->name }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 transition"
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
                                                    d="M6 7h12M10 11v6M14 11v6M9 7V4h6v3m-8 0l1 13h6L19 7"
                                                />
                                            </svg>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>


                    {{-- MODAL EDIT --}}
                    <tr
                        x-show="openId === {{ $user->id }}"
                        x-cloak
                    >

                        <td
                            colspan="6"
                            class="p-0"
                        >

                            <div
                                x-show="openId === {{ $user->id }}"
                                x-cloak
                                class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                                @click.self="openId = null"
                            >

                                <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[85vh] overflow-y-auto p-6">

                                    <h3 class="font-semibold text-lg mb-4">
                                        Edit {{ $user->name }}
                                    </h3>


                                    {{-- FORM EDIT --}}
                                    <form
                                        action="{{ route('admin.users.update', $user->id) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PUT')


                                        {{-- NAMA --}}
                                        <div class="mb-3">

                                            <label class="block text-sm font-medium mb-1">
                                                Nama
                                            </label>

                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ $user->name }}"
                                                class="w-full border rounded p-2"
                                            >

                                        </div>


                                        {{-- EMAIL --}}
                                        <div class="mb-3">

                                            <label class="block text-sm font-medium mb-1">
                                                Email
                                            </label>

                                            <input
                                                type="email"
                                                name="email"
                                                value="{{ $user->email }}"
                                                class="w-full border rounded p-2"
                                            >

                                        </div>


                                        {{-- PASSWORD --}}
                                        <div class="mb-3">

                                            <label class="block text-sm font-medium mb-1">
                                                Password Baru
                                            </label>

                                            <div class="relative">

                                                <input
                                                    :type="showPassword ? 'text' : 'password'"
                                                    name="password"
                                                    class="w-full border rounded p-2 pr-10"
                                                >

                                                <button
                                                    type="button"
                                                    title="Tampilkan password"
                                                    @click="showPassword = !showPassword"
                                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500"
                                                >

                                                    {{-- ICON PASSWORD TERLIHAT --}}
                                                    <svg
                                                        x-show="!showPassword"
                                                        class="w-5 h-5"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
                                                        />

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                        />
                                                    </svg>


                                                    {{-- ICON PASSWORD TERSEMBUNYI --}}
                                                    <svg
                                                        x-show="showPassword"
                                                        x-cloak
                                                        class="w-5 h-5"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.875 18.825A10.05 10.05 0 0 1 12 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 0 1 2.132-3.411m3.712-2.687A9.98 9.98 0 0 1 12 5c4.478 0 8.268 2.943 9.542 7a9.957 9.957 0 0 1-4.132 5.411M3 3l18 18"
                                                        />
                                                    </svg>

                                                </button>

                                            </div>

                                            <p class="text-xs text-gray-500 mt-1">
                                                Kosongkan jika tidak ingin mengubah password.
                                            </p>

                                        </div>


                                        {{-- BUTTON MODAL --}}
                                        <div class="flex gap-2 mt-4">

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                            >
                                                Simpan
                                            </button>

                                            <button
                                                type="button"
                                                @click="openId = null"
                                                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                                            >
                                                Batal
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

                    {{-- DATA KOSONG --}}
                    <tr>

                        <td
                            colspan="6"
                            class="p-4 text-center text-gray-500"
                        >
                            Belum ada data user.
                        </td>

                    </tr>

                @endforelse

            </tbody>


            {{-- FOOTER TABEL --}}
            <tfoot>

                <tr class="bg-gray-50 border-t font-semibold">

                    <td
                        colspan="6"
                        class="p-3 text-sm"
                    >
                        Total: {{ $users->total() }} akun
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>


    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layouts.admin>