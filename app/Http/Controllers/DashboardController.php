<?php


namespace App\Http\Controllers;

use App\Models\GuruPamong;
use App\Models\Logbook;
use App\Models\Mahasiswa;
use App\Models\Penempatan;
use App\Models\Sekolah;
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
        $totalMahasiswa = Mahasiswa::count();
        $totalSekolah = Sekolah::count();
        $totalGuruPamong = GuruPamong::count();
        $totalPenempatan = Penempatan::count();

        $penempatanPerStatus = [
            'menunggu' => Penempatan::where('status', 'menunggu')->count(),
            'berjalan' => Penempatan::where('status', 'berjalan')->count(),
            'selesai' => Penempatan::where('status', 'selesai')->count(),
            'dibatalkan' => Penempatan::where('status', 'dibatalkan')->count(),
        ];

         $logbookMenunggu = Logbook::where('status_verifikasi', 'menunggu')->count();
        $logbookDisetujui = Logbook::where('status_verifikasi', 'disetujui')->count();
        $logbookRevisi = Logbook::where('status_verifikasi', 'revisi')->count();

        return view('dashboards.admin', compact(
            'totalMahasiswa',
            'totalSekolah',
            'totalGuruPamong',
            'totalPenempatan',
            'penempatanPerStatus',
            'logbookMenunggu',
            'logbookDisetujui',
            'logbookRevisi'
        ));
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