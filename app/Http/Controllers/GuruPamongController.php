<?php

namespace App\Http\Controllers;

use App\Models\GuruPamong;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruPamongController extends Controller
{
    // Tampilkan semua data guru pamong
    public function index()
    {
        $guruPamongs = GuruPamong::with(['user', 'sekolah'])->latest()->paginate(10);
        return view('admin.guru-pamong.index', compact('guruPamongs'));
    }

    // Tampilkan form tambah guru pamong
    public function create()
    {
        $sekolahs = Sekolah::where('status', 'aktif')->get();
        return view('admin.guru-pamong.create', compact('sekolahs'));
    }

    // Simpan data guru pamong baru (bikin akun + profil sekaligus)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nip' => 'nullable',
            'mapel' => 'nullable',
            'no_hp' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('guru_pamong');

            GuruPamong::create([
                'user_id' => $user->id,
                'sekolah_id' => $request->sekolah_id,
                'nip' => $request->nip,
                'mapel' => $request->mapel,
                'no_hp' => $request->no_hp,
            ]);
        });

        return redirect()->route('admin.guru-pamong.index')->with('success', 'Akun dan data guru pamong berhasil ditambahkan.');
    }

    public function show(GuruPamong $guruPamong)
    {
        return view('admin.guru-pamong.show', compact('guruPamong'));
    }

    // Tampilkan form edit
    public function edit(GuruPamong $guruPamong)
    {
        $sekolahs = Sekolah::where('status', 'aktif')->get();
        return view('admin.guru-pamong.edit', compact('guruPamong', 'sekolahs'));
    }

    // Update data (password opsional, cuma diubah kalau diisi)
    public function update(Request $request, GuruPamong $guruPamong)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $guruPamong->user_id,
            'password' => 'nullable|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nip' => 'nullable',
            'mapel' => 'nullable',
            'no_hp' => 'nullable',
        ]);

        DB::transaction(function () use ($request, $guruPamong) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $guruPamong->user->update($userData);

            $guruPamong->update([
                'sekolah_id' => $request->sekolah_id,
                'nip' => $request->nip,
                'mapel' => $request->mapel,
                'no_hp' => $request->no_hp,
            ]);
        });

        return redirect()->route('admin.guru-pamong.index')->with('success', 'Data guru pamong berhasil diperbarui.');
    }

    // Hapus guru pamong (otomatis hapus user login-nya juga, karena cascadeOnDelete)
    public function destroy(GuruPamong $guruPamong)
    {
        $guruPamong->user->delete();

        return redirect()->route('admin.guru-pamong.index')->with('success', 'Data guru pamong berhasil dihapus.');
    }
}