<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaLogbookController extends Controller
{
    /**
     * Ambil penempatan terbaru milik mahasiswa yang sedang login.
     */
    private function penempatanAktif()
    {
        return Auth::user()->mahasiswa->penempatans()->latest()->first();
    }

    /**
     * Validasi bahwa logbook memang milik penempatan mahasiswa yang login.
     */
    private function pastikanMilikSendiri(Logbook $logbook, $penempatan): void
    {
        if (!$penempatan || $logbook->penempatan_id != $penempatan->id) {
            abort(403);
        }
    }

    public function index()
    {
        $penempatan = $this->penempatanAktif();

        if (!$penempatan) {
            return view('mahasiswa.logbook.index', [
                'penempatan' => null,
                'logbooks' => collect(),
            ]);
        }

        $logbooks = $penempatan->logbooks()
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('mahasiswa.logbook.index', compact('penempatan', 'logbooks'));
    }

    public function create()
    {
        $penempatan = $this->penempatanAktif();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        return view('mahasiswa.logbook.create', compact('penempatan'));
    }

    public function store(Request $request)
    {
        $penempatan = $this->penempatanAktif();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Anda belum memiliki penempatan magang.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        $sudahAda = $penempatan->logbooks()
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Logbook untuk tanggal tersebut sudah ada. Satu tanggal hanya dapat memiliki satu logbook.',
            ]);
        }

        $path = $request->hasFile('dokumentasi')
            ? $request->file('dokumentasi')->store('logbook', 'public')
            : null;

        Logbook::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
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
        $penempatan = $this->penempatanAktif();
        $this->pastikanMilikSendiri($logbook, $penempatan);

        if ($logbook->status_verifikasi === 'disetujui') {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Logbook yang sudah disetujui tidak dapat diedit.');
        }

        return view('mahasiswa.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        $penempatan = $this->penempatanAktif();
        $this->pastikanMilikSendiri($logbook, $penempatan);

        if ($logbook->status_verifikasi === 'disetujui') {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Logbook yang sudah disetujui tidak dapat diedit.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        // Logbook yang sedang diedit tidak dihitung sebagai duplikat
        $duplikat = $penempatan->logbooks()
            ->whereDate('tanggal', $request->tanggal)
            ->where('id', '!=', $logbook->id)
            ->exists();

        if ($duplikat) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Sudah ada logbook lain pada tanggal tersebut. Silakan pilih tanggal yang berbeda.',
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
            'status_verifikasi' => 'menunggu', // harus diverifikasi ulang setelah diedit
            'catatan_guru_pamong' => null,
            'verified_by' => null,
            'verified_at' => null,
        ]);

        return redirect()
            ->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook berhasil diperbarui dan menunggu verifikasi kembali.');
    }

    public function destroy(Logbook $logbook)
    {
        $penempatan = $this->penempatanAktif();
        $this->pastikanMilikSendiri($logbook, $penempatan);

        if ($logbook->status_verifikasi !== 'menunggu') {
            return redirect()
                ->route('mahasiswa.logbook.index')
                ->with('error', 'Logbook yang sudah diproses Guru Pamong tidak dapat dihapus.');
        }

        if ($logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
        }

        $logbook->delete();

        return redirect()
            ->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }
}