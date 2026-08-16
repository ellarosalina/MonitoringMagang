<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MahasiswaProfilController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        return view('mahasiswa.profil.index', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'password' => 'nullable|min:8|confirmed',
            'password' => 'nullable|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $mahasiswa = $user->mahasiswa;

        $mahasiswa->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'dosen_pembimbing' => $request->dosen_pembimbing,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()
            ->route('mahasiswa.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}