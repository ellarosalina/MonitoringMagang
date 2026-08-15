<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Logbook
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

                <form action="{{ route('mahasiswa.logbook.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Kegiatan</label>
                        <textarea name="kegiatan" rows="5" class="w-full border rounded p-2" placeholder="Ceritakan kegiatan yang dilakukan hari ini...">{{ old('kegiatan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Dokumentasi (opsional)</label>
                        <input type="file" name="dokumentasi" accept="image/*" class="w-full border rounded p-2">
                        <p class="text-sm text-gray-500 mt-1">Format gambar (JPG/PNG), maksimal 2MB.</p>
                    </div>

                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('mahasiswa.logbook.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>