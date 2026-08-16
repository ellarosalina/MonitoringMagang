<x-layouts.guru-pamong title="Verifikasi Logbook" subtitle="Pantau dan verifikasi logbook mahasiswa bimbingan">

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-3">
        @forelse ($logbooks as $logbook)
            <div class="bg-white border rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-semibold">{{ $logbook->penempatan->mahasiswa->user->name }}</span>
                        <span class="text-sm text-gray-500">— {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</span>
                    </div>
                    <span class="px-2 py-1 text-xs rounded
                        @if($logbook->status_verifikasi == 'disetujui') bg-green-100 text-green-700
                        @elseif($logbook->status_verifikasi == 'revisi') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700
                        @endif">
                        {{ ucfirst($logbook->status_verifikasi) }}
                    </span>
                </div>
                <p class="text-sm text-gray-700 mb-2">{{ $logbook->kegiatan }}</p>

                @if ($logbook->dokumentasi)
                    <img src="{{ Storage::url($logbook->dokumentasi) }}" alt="Dokumentasi" class="w-32 rounded border mb-2">
                @endif

                @if ($logbook->catatan_guru_pamong)
                    <p class="text-xs text-gray-500 mb-2"><strong>Catatan Anda:</strong> {{ $logbook->catatan_guru_pamong }}</p>
                @endif

                @if ($logbook->status_verifikasi === 'menunggu')
                    <div class="flex gap-2 items-center mt-3 pt-3 border-t" x-data="{ showRevisi: false }">
                        <form action="{{ route('guru-pamong.logbook.approve', $logbook->id) }}" method="POST" onsubmit="return confirm('Setujui logbook ini?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700">Setujui</button>
                        </form>

                        <button type="button" @click="showRevisi = !showRevisi" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Minta Revisi
                        </button>

                        <div x-show="showRevisi" x-cloak class="w-full mt-2">
                            <form action="{{ route('guru-pamong.logbook.revisi', $logbook->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="catatan_guru_pamong" class="w-full border rounded p-2 text-sm" placeholder="Tulis alasan/catatan revisi..." required></textarea>
                                <button type="submit" class="mt-2 px-3 py-1.5 bg-red-600 text-white text-sm rounded hover:bg-red-700">Kirim Revisi</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">Belum ada logbook dari mahasiswa bimbingan.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $logbooks->links() }}
    </div>

</x-layouts.guru-pamong>