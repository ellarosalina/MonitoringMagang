<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaAbsensiController extends Controller
{
    public function index()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('mahasiswa.absensi.index', [
                'penempatan' => null,
                'absensis' => collect(),
            ]);
        }

        // Hanya menampilkan absensi yang sudah benar-benar disimpan
        $absensis = $penempatan->absensis()
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('mahasiswa.absensi.index', [
            'penempatan' => $penempatan,
            'absensis' => $absensis,
        ]);
    }

    public function create()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        // Tanggal hari ini otomatis
        $tanggalHariIni = Carbon::today();

        // Hari otomatis dalam Bahasa Indonesia
        $hariHariIni = $tanggalHariIni
            ->locale('id')
            ->translatedFormat('l');

        // Sabtu dan Minggu tidak bisa mengisi absensi
        if ($tanggalHariIni->isWeekend()) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi hanya dapat diisi pada hari kerja, yaitu Senin sampai Jumat.');
        }

        // Cek apakah hari ini sudah pernah absen
        $sudahAbsen = $penempatan->absensis()
            ->whereDate('tanggal', $tanggalHariIni)
            ->exists();

        // Kalau sudah absen, tidak boleh membuat absensi kedua
        if ($sudahAbsen) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi hari ini sudah diisi.');
        }

        return view('mahasiswa.absensi.create', [
            'penempatan' => $penempatan,
            'tanggalHariIni' => $tanggalHariIni,
            'hariHariIni' => $hariHariIni,
            'sudahAbsen' => $sudahAbsen,
        ]);
    }

    public function store(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Anda belum memiliki penempatan magang.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        // Tanggal hari ini
        $tanggalHariIni = Carbon::today();

        // Pastikan tanggal yang dikirim adalah tanggal hari ini
        if (
            Carbon::parse($request->tanggal)->format('Y-m-d')
            !==
            $tanggalHariIni->format('Y-m-d')
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Tanggal absensi harus menggunakan tanggal hari ini.'
                ]);
        }

        // Pastikan bukan Sabtu/Minggu
        if ($tanggalHariIni->isWeekend()) {
            return back()
                ->withErrors([
                    'tanggal' => 'Absensi hanya dapat diisi pada hari kerja.'
                ]);
        }

        // Cegah absensi ganda pada tanggal yang sama
        $sudahAbsen = $penempatan->absensis()
            ->whereDate('tanggal', $tanggalHariIni)
            ->exists();

        if ($sudahAbsen) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi hari ini sudah diisi.');
        }

        Absensi::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $tanggalHariIni->format('Y-m-d'),
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('mahasiswa.absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function edit(Absensi $absensi)
    {
        return view('mahasiswa.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        // Tanggal TIDAK divalidasi dari request
        // karena tanggal tidak boleh diubah saat edit
        $request->validate([
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        // Hanya jam dan status yang boleh diubah
        $absensi->update([
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('mahasiswa.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }
}