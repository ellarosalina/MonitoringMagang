<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaAbsensiController extends Controller
{
    // Tampilkan riwayat absensi milik mahasiswa yang login
    public function index()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('mahasiswa.absensi.index', ['penempatan' => null, 'absensis' => collect()]);
        }

        $absensis = $penempatan->absensis()->orderBy('tanggal', 'desc')->paginate(10);

        return view('mahasiswa.absensi.index', compact('penempatan', 'absensis'));
    }

    // Tampilkan form tambah absensi
    public function create()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()->route('mahasiswa.absensi.index')->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        return view('mahasiswa.absensi.create', compact('penempatan'));
    }

    // Simpan absensi baru
    public function store(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'catatan' => 'nullable',
        ]);

        Absensi::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('mahasiswa.absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }

    // Tampilkan form edit absensi
    public function edit(Absensi $absensi)
    {
        return view('mahasiswa.absensi.edit', compact('absensi'));
    }

    // Update absensi
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'catatan' => 'nullable',
        ]);

        $absensi->update($request->all());

        return redirect()->route('mahasiswa.absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }
}