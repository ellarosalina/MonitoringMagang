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

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
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
                        <td class="p-3 text-sm">
                            {{ $user->name }}
                            @if ($user->id === auth()->id())
                                <span class="text-xs text-gray-400">(Anda)</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">{{ $user->email }}</td>
                        <td class="p-3 text-sm">
                            @foreach ($user->roles as $role)
                                <span class="px-2 py-1 text-xs rounded
                                    @if($role->name == 'admin_gtk') bg-purple-100 text-purple-700
                                    @elseif($role->name == 'guru_pamong') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($role->name)) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="p-3 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-3 text-sm">
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun {{ $user->name }}? Semua data terkait akun ini juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layouts.admin>