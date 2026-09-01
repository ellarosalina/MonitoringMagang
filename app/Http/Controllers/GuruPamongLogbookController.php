<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruPamongLogbookController extends Controller
{
    public function index(Request $request)
    {
        $guruPamong = Auth::user()->guruPamong;
        $search = $request->search;
        $status = $request->status ?? 'semua';

        $logbooks = Logbook::whereHas('penempatan', function ($q) use ($guruPamong) {
            $q->where('guru_pamong_id', $guruPamong->id);
        })
        ->with(['penempatan.mahasiswa.user'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('penempatan.mahasiswa.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('kegiatan', 'like', "%{$search}%");
        })
        ->when($status !== 'semua', function ($query) use ($status) {
            $query->where('status_verifikasi', $status);
        })
        ->orderByRaw("FIELD(status_verifikasi, 'menunggu', 'revisi', 'disetujui')")
        ->orderBy('tanggal', 'desc')
        ->paginate(10)
        ->withQueryString();

        return view('guru-pamong.logbook.index', compact('logbooks', 'search', 'status'));
    }

    private function pastikanMilikBimbingan(Logbook $logbook)
    {
        $guruPamong = Auth::user()->guruPamong;

        if ($logbook->penempatan->guru_pamong_id !== $guruPamong->id) {
            abort(403, 'Anda tidak berwenang memverifikasi logbook ini.');
        }
    }

    public function approve(Request $request, Logbook $logbook)
    {
        $this->pastikanMilikBimbingan($logbook);

        $request->validate([
            'catatan_guru_pamong' => 'required|string|max:1000',
        ]);

        $logbook->update([
            'status_verifikasi' => 'disetujui',
            'catatan_guru_pamong' => $request->catatan_guru_pamong,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('guru-pamong.logbook.index')
            ->with('success', 'Logbook berhasil disetujui.');
    }

    public function revisi(Request $request, Logbook $logbook)
    {
        $this->pastikanMilikBimbingan($logbook);

        $request->validate([
            'catatan_guru_pamong' => 'required|string|max:1000',
        ]);

        $logbook->update([
            'status_verifikasi' => 'revisi',
            'catatan_guru_pamong' => $request->catatan_guru_pamong,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('guru-pamong.logbook.index')
            ->with('success', 'Logbook dikembalikan untuk direvisi.');
    }
}