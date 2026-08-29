<x-layouts.admin title="Edit Guru Pamong" subtitle="Ubah data guru pamong">

    @if ($errors->any())

        <div class="mb-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="max-w-5xl mx-auto">

        <form action="{{ route('admin.guru-pamong.update', $guruPamong->id) }}" method="POST">

            @csrf

            @method('PUT')

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- AKUN LOGIN --}}
                    <div>

                        <div class="flex items-center gap-2 mb-5">

                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">

                                <svg class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>

                                </svg>

                            </div>

                            <h3 class="text-sm font-semibold text-gray-800">
                                Akun Login
                            </h3>

                        </div>

                        <div class="space-y-5">

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $guruPamong->user->name) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $guruPamong->user->email) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Password Baru
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                                <p class="text-xs text-gray-500 mt-2">
                                    Kosongkan jika tidak ingin mengubah password.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- DATA GURU PAMONG --}}
                    <div>

                        <div class="flex items-center gap-2 mb-5">

                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4"/>

                                </svg>

                            </div>

                            <h3 class="text-sm font-semibold text-gray-800">
                                Data Guru Pamong
                            </h3>

                        </div>

                        <div class="space-y-4">

                            <div
                                x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ old('sekolah_id', $guruPamong->sekolah_id) }}'
                                }"
                                class="relative">

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Sekolah
                                </label>

                                <input
                                    type="hidden"
                                    name="sekolah_id"
                                    :value="selected"
                                >

                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white text-left flex items-center justify-between focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">

                                    <span
                                        x-text="selected ? $refs['school' + selected]?.textContent : '-- Pilih Sekolah --'">
                                    </span>

                                    <svg
                                        class="w-4 h-4 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"/>

                                    </svg>

                                </button>

                                <div
                                    x-show="open"
                                    @click.outside="open = false"
                                    x-transition
                                    class="absolute z-30 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">

                                    <div class="p-2 border-b border-gray-200">

                                        <input
                                            type="text"
                                            x-model="search"
                                            placeholder="Cari sekolah..."
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-gray-400"
                                        >

                                    </div>

                                    <div class="max-h-48 overflow-y-auto">

                                        <button
                                            type="button"
                                            @click="selected = ''; open = false; search = ''"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50">

                                            -- Pilih Sekolah --

                                        </button>

                                        @foreach ($sekolahs as $sekolah)

                                            <button
                                                type="button"
                                                x-ref="school{{ $sekolah->id }}"
                                                @click="selected = '{{ $sekolah->id }}'; open = false; search = ''"
                                                x-show="'{{ strtolower($sekolah->nama_sekolah) }}'.includes(search.toLowerCase())"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50">

                                                {{ $sekolah->nama_sekolah }}

                                            </button>

                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Mata Pelajaran
                                </label>

                                <input
                                    type="text"
                                    name="mapel"
                                    value="{{ old('mapel', $guruPamong->mapel) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                            </div>


                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    NIP
                                </label>

                                <input
                                    type="text"
                                    name="nip"
                                    value="{{ old('nip', $guruPamong->nip) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                            </div>


                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    No. HP
                                </label>

                                <input
                                    type="text"
                                    name="no_hp"
                                    value="{{ old('no_hp', $guruPamong->no_hp) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- TOMBOL --}}
                <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">

                    <a
                        href="{{ route('admin.guru-pamong.index') }}"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700">

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</x-layouts.admin>