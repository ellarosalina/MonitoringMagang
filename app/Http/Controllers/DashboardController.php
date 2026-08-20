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
        $mahasiswa = Auth::user()->mahasiswa;
        $penempatan = $mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('dashboards.mahasiswa', ['penempatan' => null]);
        }

        $hariMagang = now()->diffInDays($penempatan->tanggal_mulai) >= 0 && now()->gt($penempatan->tanggal_mulai)
            ? $penempatan->tanggal_mulai->diffInDays(now()->lt($penempatan->tanggal_selesai) ? now() : $penempatan->tanggal_selesai) + 1
            : 0;

        $totalAbsensi = $penempatan->absensis()->count();
        $hadirCount = $penempatan->absensis()->where('status', 'hadir')->count();
        $persenKehadiran = $totalAbsensi > 0 ? round(($hadirCount / $totalAbsensi) * 100) : 0;

        $totalLogbook = $penempatan->logbooks()->count();
        $logbookDisetujui = $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count();

        return view('dashboards.mahasiswa', [
            'penempatan' => $penempatan,
            'hariMagang' => $hariMagang,
            'persenKehadiran' => $persenKehadiran,
            'totalLogbook' => $totalLogbook,
            'logbookDisetujui' => $logbookDisetujui,
        ]);
    }
}