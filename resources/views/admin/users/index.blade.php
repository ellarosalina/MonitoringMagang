<x-layouts.admin title="Manajemen User" subtitle="Semua akun pengguna sistem">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
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

    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded text-sm {{ !$role ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">Semua</a>
        <a href="{{ route('admin.users.index', ['role' => 'admin_gtk']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'admin_gtk' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">Admin GTK</a>
        <a href="{{ route('admin.users.index', ['role' => 'guru_pamong']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'guru_pamong' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">Guru Pamong</a>
        <a href="{{ route('admin.users.index', ['role' => 'mahasiswa']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'mahasiswa' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">Mahasiswa</a>
    </div>

    @if (!$role || $role == 'admin_gtk')
        <a href="{{ route('admin.users.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Admin GTK</a>
    @endif
    

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto" x-data="{ openId: null, showPassword: false }">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600 w-12">No</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Role</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Terdaftar</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td class="p-3 text-sm">
                            {{ $user->name }}
                            @if ($user->id === auth()->id())
                                <span class="text-xs text-gray-400">(Anda)</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">{{ $user->email }}</td>
                        <td class="p-3 text-sm">
                            @foreach ($user->roles as $r)
                                <span class="px-2 py-1 text-xs rounded
                                    @if($r->name == 'admin_gtk') bg-purple-100 text-purple-700
                                    @elseif($r->name == 'guru_pamong') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($r->name)) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="p-3 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-3 text-sm space-x-2">
                            <button @click="openId = {{ $user->id }}; showPassword = false" class="text-blue-600 hover:underline">Edit</button>

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus akun {{ $user->name }}? Semua data terkait akun ini juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <tr x-show="openId === {{ $user->id }}" x-cloak>
                        <td colspan="6" class="p-0">
                            <div x-show="openId === {{ $user->id }}" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="openId = null">
                                <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[85vh] overflow-y-auto p-6">
                                    <h3 class="font-semibold text-lg mb-4">Edit {{ $user->name }}</h3>

                                                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Nama</label>
                                            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2">
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2">
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Password Baru</label>
                                            <div class="relative">
                                                <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full border rounded p-2 pr-10">
                                                <button type="button" @click="showPassword = !showPassword" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">
                                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 012.132-3.411m3.712-2.687A9.98 9.98 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.132 5.411M3 3l18 18"/></svg>
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                                        </div>
                                        <div class="flex gap-2 mt-4">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                                            <button type="button" @click="openId = null" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t font-semibold">
                    <td colspan="6" class="p-3 text-sm">Total: {{ $users->total() }} akun</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layouts.admin>