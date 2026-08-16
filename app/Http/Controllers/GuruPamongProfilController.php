<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruPamongProfilController extends Controller
{
    public function index()
    {
        $guruPamong = Auth::user()->guruPamong;

        return view('guru-pamong.profil.index', compact('guruPamong'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'no_hp' => 'nullable',
            'mapel' => 'nullable',
            'foto' => 'nullable|image|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $guruPamong = $user->guruPamong;

        $userData = [
            'name' => $request->name
        ];

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            $userData['foto'] = $request->file('foto')
                ->store('foto-profil', 'public');
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $guruPamong->update([
            'no_hp' => $request->no_hp,
            'mapel' => $request->mapel,
        ]);

        return redirect()
            ->route('guru-pamong.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}