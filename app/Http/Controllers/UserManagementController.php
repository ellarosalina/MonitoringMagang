<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}