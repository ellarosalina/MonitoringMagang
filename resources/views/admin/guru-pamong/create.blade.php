<x-layouts.admin title="Tambah Guru Pamong" subtitle="Buat akun dan data guru pamong baru">

    @if ($errors->any())
        <div class="mb-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-4xl">
        <form action="{{ route('admin.guru-pamong.store') }}" method="POST">
            @csrf

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-3">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Akun Login</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h.01M12 10h.01M15 10h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800">Data Guru Pamong</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <div x-data="{ open: false, search: '', selected: '{{ old('sekolah_id') }}', selectedName: '{{ old('sekolah_id') ? optional($sekolahs->firstWhere('id', old('sekolah_id')))->nama_sekolah : '' }}' }" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>

                        <input type="hidden" name="sekolah_id" :value="selected">

                        <button type="button" @click="open = !open" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-left bg-white focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                            <span x-text="selectedName || '-- Pilih Sekolah --'" :class="selectedName ? 'text-gray-800' : 'text-gray-400'"></span>
                            <span class="float-right text-gray-500">▼</span>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition class="absolute z-30 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">

                            <div class="p-2 border-b border-gray-200">
                                <input type="text" x-model="search" placeholder="Cari sekolah..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                            </div>

                            <div class="max-h-48 overflow-y-auto">

                                <button type="button" @click="selected = ''; selectedName = ''; open = false; search = ''" class="w-full px-3 py-2 text-left text-sm text-gray-500 hover:bg-gray-50">
                                    -- Pilih Sekolah --
                                </button>

                                @foreach ($sekolahs as $sekolah)
                                    <button type="button"
                                        x-show="{{ json_encode(strtolower($sekolah->nama_sekolah)) }}.includes(search.toLowerCase())"
                                        @click="selected = '{{ $sekolah->id }}'; selectedName = {{ Js::from($sekolah->nama_sekolah) }}; open = false; search = ''"
                                        class="w-full px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-50">
                                        {{ $sekolah->nama_sekolah }}
                                    </button>
                                @endforeach

                                <div x-show="search && ![...$el.parentElement.children].some(el => el.tagName === 'BUTTON' && el.innerText.toLowerCase().includes(search.toLowerCase()))" class="px-3 py-3 text-sm text-gray-500 text-center">
                                    Sekolah tidak ditemukan.
                                </div>

                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <input type="text" name="mapel" value="{{ old('mapel') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 focus:ring-1 focus:ring-gray-200">
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-5 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.guru-pamong.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700">
                        Simpan
                    </button>
                </div>
            </div>

        </form>
    </div>

</x-layouts.admin>