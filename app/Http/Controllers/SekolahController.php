<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    // Tampilkan semua data sekolah
    public function index()
    {
        $sekolahs = Sekolah::latest()->paginate(10);
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    // Tampilkan form tambah sekolah
    public function create()
    {
        return view('admin.sekolah.create');
    }

    // Simpan data sekolah baru
    public function store(Request $request)
    {
        $request->validate([
            'npsn' => 'required|unique:sekolahs,npsn',
            'nama_sekolah' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'nullable',
            'kepala_sekolah' => 'nullable',
            'no_telp' => 'nullable',
            'email' => 'nullable|email',
            'kuota_magang' => 'nullable|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Sekolah::create($request->all());

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    // Tampilkan detail 1 sekolah (opsional, boleh dilewati)
    public function show(Sekolah $sekolah)
    {
        return view('admin.sekolah.show', compact('sekolah'));
    }

    // Tampilkan form edit sekolah
    public function edit(Sekolah $sekolah)
    {
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    // Simpan perubahan data sekolah
    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'npsn' => 'required|unique:sekolahs,npsn,' . $sekolah->id,
            'nama_sekolah' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'nullable',
            'kepala_sekolah' => 'nullable',
            'no_telp' => 'nullable',
            'email' => 'nullable|email',
            'kuota_magang' => 'nullable|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $sekolah->update($request->all());

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    // Hapus data sekolah
    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}