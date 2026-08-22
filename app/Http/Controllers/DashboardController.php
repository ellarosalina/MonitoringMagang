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

        $logbookMenunggu = Logbook::where(
            'status_verifikasi',
            'menunggu'
        )->count();

        $logbookDisetujui = Logbook::where(
            'status_verifikasi',
            'disetujui'
        )->count();

        $logbookRevisi = Logbook::where(
            'status_verifikasi',
            'revisi'
        )->count();

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
        $penempatan = $mahasiswa->penempatans()
            ->latest()
            ->first();
        
        if (!$penempatan) {
            return view('dashboards.mahasiswa', [
                'penempatan' => null
            ]);
        }

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        $hariIni = now()->startOfDay();

        if ($hariIni->lt($tanggalMulai)) {

            $hariMagang = 0;

        } else {
            $tanggalAkhir = $hariIni->gt($tanggalSelesai)
                ? $tanggalSelesai
                : $hariIni;

            $hariMagang = 0;
            $tanggal = $tanggalMulai->copy();
            while ($tanggal->lte($tanggalAkhir)) {
                if ($tanggal->isWeekday()) {
                    $hariMagang++;
                }
                $tanggal->addDay();
            }
        }

        $totalHariKerja = 0;
        $tanggal = $tanggalMulai->copy();
        while ($tanggal->lte($tanggalSelesai)) {
            if ($tanggal->isWeekday()) {
                $totalHariKerja++;
            }
            $tanggal->addDay();
        }

        $totalAbsensi = $penempatan->absensis()->count();
        $hadirCount = $penempatan->absensis()
          ->where('status', 'hadir')
          ->count();
        $sakitCount = $penempatan->absensis()
         ->where('status', 'sakit')
         ->count();
        $izinCount = $penempatan->absensis()
         ->where('status', 'izin')
         ->count();
        $alpaCount = $penempatan->absensis()
        ->where('status', 'alpa')
        ->count();

        $totalPenilaian = $hadirCount + $alpaCount;
        $persenKehadiran = $totalPenilaian > 0
        ? round(($hadirCount / $totalPenilaian) * 100)
        : 0;

        $totalLogbook = $penempatan->logbooks()->count();
        $logbookDisetujui = $penempatan->logbooks()
            ->where('status_verifikasi', 'disetujui')
            ->count();

        return view('dashboards.mahasiswa', [
            'penempatan' => $penempatan,
            'hariMagang' => $hariMagang,
            'totalHariKerja' => $totalHariKerja,
            'persenKehadiran' => $persenKehadiran,
            'hadirCount' => $hadirCount,
            'sakitCount' => $sakitCount,
            'izinCount' => $izinCount,
            'alpaCount' => $alpaCount,
            'totalLogbook' => $totalLogbook,
            'logbookDisetujui' => $logbookDisetujui,
        ]);
    }
}