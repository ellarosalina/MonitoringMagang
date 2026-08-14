<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Isi Absensi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded p-2">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpa">Alpa</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jam Pulang</label>
                        <input type="time" name="jam_pulang" value="{{ old('jam_pulang') }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Catatan (opsional)</label>
                        <textarea name="catatan" class="w-full border rounded p-2">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('mahasiswa.absensi.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>