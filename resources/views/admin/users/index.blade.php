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

    {{-- Tab filter --}}
    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded text-sm {{ !$role ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">
            Semua
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin_gtk']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'admin_gtk' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">
            Admin GTK
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'guru_pamong']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'guru_pamong' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">
            Guru Pamong
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'mahasiswa']) }}" class="px-4 py-2 rounded text-sm {{ $role == 'mahasiswa' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border' }}">
            Mahasiswa
        </a>
    </div>

    @if (!$role || $role == 'admin_gtk')
        <a href="{{ route('admin.users.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah Admin GTK
        </a>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
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
                            @if ($user->hasRole('admin_gtk'))
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            @elseif ($user->hasRole('guru_pamong') && $user->guruPamong)
                                <a href="{{ route('admin.guru-pamong.edit', $user->guruPamong->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            @elseif ($user->hasRole('mahasiswa') && $user->mahasiswa)
                                <a href="{{ route('admin.mahasiswa.edit', $user->mahasiswa->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            @endif

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus akun {{ $user->name }}? Semua data terkait akun ini juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @endif
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