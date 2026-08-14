<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dipanggil saat user membuka /dashboard.
     * Cek role user yang login, lalu arahkan ke dashboard sesuai role.
     */
   public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('admin_gtk')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('guru_pamong')) {
            return redirect()->route('guru-pamong.dashboard');
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        abort(403, 'Akun Anda belum memiliki role. Hubungi Admin GTK.');
    }

    public function admin()
    {
        return view('dashboards.admin');
    }

    public function guruPamong()
    {
        return view('dashboards.guru-pamong');
    }

    public function mahasiswa()
    {
        return view('dashboards.mahasiswa');
    }
}