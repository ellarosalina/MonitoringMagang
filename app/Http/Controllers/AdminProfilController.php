<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfilController extends Controller
{
    public function index()
    {
        return view('admin.profil.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('admin.profil.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
}