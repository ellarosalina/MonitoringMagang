<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaLogbookController extends Controller
{
    public function index(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('mahasiswa.logbook.index', [
                'penempatan' => null,
                'logbooks' => collect(),
                'status' => 'semua',
            ]);
        }

        $status = $request->get('status', 'semua');

        if (!in_array($status, ['semua', 'menunggu', 'disetujui', 'revisi'])) {
            $status = 'semua';
        }

        $query = $penempatan->logbooks()
            ->orderBy('tanggal', 'desc');

        if ($status !== 'semua') {
            $query->where('status_verifikasi', $status);
        }

        $logbooks = $query
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.logbook.index', compact(
            'penempatan',
            'logbooks',
            'status'
        ));
    }

    public function create()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        return view('mahasiswa.logbook.create', compact('penempatan'));
    }

    public function store(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Anda belum memiliki penempatan magang.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'detail_kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $sudahAda = $penempatan->logbooks()
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Anda sudah mengisi logbook untuk tanggal ini. Satu tanggal hanya boleh 1 logbook.',
                ]);
        }

        $path = null;

        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')
                ->store('logbook', 'public');
        }

        Logbook::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'detail_kegiatan' => $request->detail_kegiatan,
            'dokumentasi' => $path,
            'status_verifikasi' => 'menunggu',
            'catatan_guru_pamong' => null,
            'verified_by' => null,
            'verified_at' => null,
        ]);

        return redirect()
            ->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook berhasil disimpan.');
    }

    public function edit(Logbook $logbook)
    {
        return view('mahasiswa.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'detail_kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $duplikat = $logbook->penempatan->logbooks()
            ->whereDate('tanggal', $request->tanggal)
            ->where('id', '!=', $logbook->id)
            ->exists();

        if ($duplikat) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Sudah ada logbook lain di tanggal tersebut. Silakan pilih tanggal yang berbeda.',
                ]);
        }

        $path = $logbook->dokumentasi;

        if ($request->hasFile('dokumentasi')) {

            if ($logbook->dokumentasi) {
                Storage::disk('public')
                    ->delete($logbook->dokumentasi);
            }

            $path = $request->file('dokumentasi')
                ->store('logbook', 'public');
        }

        $logbook->update([
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'detail_kegiatan' => $request->detail_kegiatan,
            'dokumentasi' => $path,
            'status_verifikasi' => 'menunggu',
            'catatan_guru_pamong' => null,
            'verified_by' => null,
            'verified_at' => null,
        ]);

        return redirect()
            ->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy(Logbook $logbook)
    {
        if ($logbook->dokumentasi) {
            Storage::disk('public')
                ->delete($logbook->dokumentasi);
        }

        $logbook->delete();

        return redirect()
            ->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }
}