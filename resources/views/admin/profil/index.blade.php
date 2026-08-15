<x-layouts.admin title="Ganti Password" subtitle="Ubah password akun Anda">

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

    <div class="bg-white rounded-lg shadow-sm p-6 max-w-md">
        <form action="{{ route('admin.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Password Baru</label>
                <input type="password" name="password" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Password</button>
        </form>
    </div>

</x-layouts.admin>