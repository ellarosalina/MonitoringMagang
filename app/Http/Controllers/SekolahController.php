<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $sekolahs = Sekolah::when($search, function ($query) use ($search) {
            $query->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('jenjang', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kabupaten', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.sekolah.index', compact('sekolahs', 'search'));
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
            'kepala_sekolah' => 'nullable',
            'jenjang' => 'required|in:SMA,SMK,SLB',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'alamat' => 'required',
            'status' => 'required|in:negeri,swasta',
            'kuota_magang' => 'nullable|integer',
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
            'kepala_sekolah' => 'nullable',
            'jenjang' => 'required|in:SMA,SMK,SLB',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'alamat' => 'required',
            'status' => 'required|in:negeri,swasta',
            'kuota_magang' => 'nullable|integer',
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