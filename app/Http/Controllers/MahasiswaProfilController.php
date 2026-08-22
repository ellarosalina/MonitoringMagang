<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'dosen_pembimbing' => 'nullable',
            'password' => 'nullable|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $mahasiswa = $user->mahasiswa;

        $mahasiswa->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'dosen_pembimbing' => $request->dosen_pembimbing,
        ]);

        // Upload foto profil
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('profile', 'public');

            // Simpan path foto ke database
            $mahasiswa->update([
                'foto' => $fotoPath,
            ]);
        }

        // Update password jika diisi
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