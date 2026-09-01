<x-layouts.admin title="Edit Sekolah" subtitle="Ubah data sekolah">

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">NPSN</label>
                <input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Jenjang</label>
                <select name="jenjang" class="w-full border rounded p-2">
                    <option value="">Pilih Jenjang</option>
                    <option value="SMA" {{ old('jenjang', $sekolah->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                    <option value="SMK" {{ old('jenjang', $sekolah->jenjang) == 'SMK' ? 'selected' : '' }}>SMK</option>
                    <option value="SLB" {{ old('jenjang', $sekolah->jenjang) == 'SLB' ? 'selected' : '' }}>SLB</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $sekolah->kecamatan) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten', $sekolah->kabupaten) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $sekolah->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="">Pilih Status</option>
                    <option value="negeri" {{ old('status', $sekolah->status) == 'negeri' ? 'selected' : '' }}>Negeri</option>
                    <option value="swasta" {{ old('status', $sekolah->status) == 'swasta' ? 'selected' : '' }}>Swasta</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kuota Magang</label>
                <input type="number" name="kuota_magang" value="{{ old('kuota_magang', $sekolah->kuota_magang) }}" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('admin.sekolah.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>