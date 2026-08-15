<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaLogbookController extends Controller
{
    public function index()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('mahasiswa.logbook.index', ['penempatan' => null, 'logbooks' => collect()]);
        }

        $logbooks = $penempatan->logbooks()->orderBy('tanggal', 'desc')->paginate(10);

        return view('mahasiswa.logbook.index', compact('penempatan', 'logbooks'));
    }

    public function create()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()->route('mahasiswa.logbook.index')->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        return view('mahasiswa.logbook.create', compact('penempatan'));
    }

    public function store(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        // Cek apakah sudah ada logbook di tanggal yang sama untuk penempatan ini
        $sudahAda = $penempatan->logbooks()->whereDate('tanggal', $request->tanggal)->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Anda sudah mengisi logbook untuk tanggal ini. Satu tanggal hanya boleh 1 logbook.',
            ]);
        }

        $path = null;
        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')->store('logbook', 'public');
        }

        Logbook::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'dokumentasi' => $path,
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook berhasil disimpan.');
    }

    public function edit(Logbook $logbook)
    {
        return view('mahasiswa.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        // Cek duplikat tanggal, tapi kecualikan logbook yang sedang diedit ini sendiri
        $duplikat = $logbook->penempatan->logbooks()
            ->whereDate('tanggal', $request->tanggal)
            ->where('id', '!=', $logbook->id)
            ->exists();

        if ($duplikat) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Sudah ada logbook lain di tanggal tersebut. Silakan pilih tanggal yang berbeda.',
            ]);
        }

        $path = $logbook->dokumentasi;

        if ($request->hasFile('dokumentasi')) {
            if ($logbook->dokumentasi) {
                Storage::disk('public')->delete($logbook->dokumentasi);
            }
            $path = $request->file('dokumentasi')->store('logbook', 'public');
        }

        $logbook->update([
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'dokumentasi' => $path,
            'status_verifikasi' => 'menunggu',
            'catatan_guru_pamong' => null,
        ]);

        return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy(Logbook $logbook)
    {
        if ($logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
        }

        $logbook->delete();

        return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook berhasil dihapus.');
    }
}