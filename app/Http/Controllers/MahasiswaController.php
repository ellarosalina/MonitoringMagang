<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('user')->latest()->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nim' => 'required|unique:mahasiswas,nim',
            'universitas' => 'nullable',
            'fakultas' => 'nullable',
            'prodi' => 'nullable',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('mahasiswa');

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'universitas' => $request->universitas,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun dan data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'password' => 'nullable|min:8',
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'universitas' => 'nullable',
            'fakultas' => 'nullable',
            'prodi' => 'nullable',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
        ]);

        DB::transaction(function () use ($request, $mahasiswa) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $mahasiswa->user->update($userData);

            $mahasiswa->update([
                'nim' => $request->nim,
                'universitas' => $request->universitas,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->user->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}