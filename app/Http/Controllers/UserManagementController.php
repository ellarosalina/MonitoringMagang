<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
{
    $role = $request->query('role');
    $search = $request->query('search');

    $query = User::with(['roles', 'guruPamong', 'mahasiswa']);

    if ($role) {
        $query->role($role);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    $users = $query->latest()
        ->paginate(15)
        ->appends([
            'role' => $role,
            'search' => $search,
        ]);

    $sekolahs = \App\Models\Sekolah::where('status', 'aktif')->get();

    return view('admin.users.index', compact(
        'users',
        'role',
        'search',
        'sekolahs'
    ));
}

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin_gtk');

        return redirect()->route('admin.users.index')->with('success', 'Akun Admin GTK berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!$user->hasRole('admin_gtk')) {
            abort(403, 'Hanya akun Admin GTK yang dapat diedit dari halaman ini.');
        }

        return view('admin.users.edit', compact('user'));
    }

        public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
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