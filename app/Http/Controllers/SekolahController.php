<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::latest()->paginate(10);
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    public function create()
    {
        return view('admin.sekolah.create');
    }
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

    public function show(Sekolah $sekolah)
    {
        return view('admin.sekolah.show', compact('sekolah'));
    }

    public function edit(Sekolah $sekolah)
    {
        return view('admin.sekolah.edit', compact('sekolah'));
    }

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

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil dihapus.');
    }
}