<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbing;
use Illuminate\Http\Request;

class DosenPembimbingController extends Controller
{
    public function index()
    {
        $dosenPembimbings = DosenPembimbing::latest()->paginate(10);
        return view('admin.dosen-pembimbing.index', compact('dosenPembimbings'));
    }

    public function create()
    {
        return view('admin.dosen-pembimbing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip_nidn' => 'nullable',
            'universitas' => 'nullable',
            'no_hp' => 'nullable',
            'email' => 'nullable|email',
        ]);

        DosenPembimbing::create($request->all());

        return redirect()->route('admin.dosen-pembimbing.index')->with('success', 'Data dosen pembimbing berhasil ditambahkan.');
    }

    public function show(DosenPembimbing $dosenPembimbing)
    {
        return view('admin.dosen-pembimbing.show', compact('dosenPembimbing'));
    }

    public function edit(DosenPembimbing $dosenPembimbing)
    {
        return view('admin.dosen-pembimbing.edit', compact('dosenPembimbing'));
    }

    public function update(Request $request, DosenPembimbing $dosenPembimbing)
    {
        $request->validate([
            'nama' => 'required',
            'nip_nidn' => 'nullable',
            'universitas' => 'nullable',
            'no_hp' => 'nullable',
            'email' => 'nullable|email',
        ]);

        $dosenPembimbing->update($request->all());

        return redirect()->route('admin.dosen-pembimbing.index')->with('success', 'Data dosen pembimbing berhasil diperbarui.');
    }

    public function destroy(DosenPembimbing $dosenPembimbing)
    {
        $dosenPembimbing->delete();

        return redirect()->route('admin.dosen-pembimbing.index')->with('success', 'Data dosen pembimbing berhasil dihapus.');
    }
}