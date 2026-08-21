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

        if (!$mahasiswa) {
            return view('dashboards.mahasiswa', [
                'penempatan' => null,
                'hariMagang' => 0,
                'totalHariKerja' => 0,
                'persenKehadiran' => 0,
                'hadirCount' => 0,
                'sakitCount' => 0,
                'izinCount' => 0,
                'alpaCount' => 0,
                'totalLogbook' => 0,
                'logbookDisetujui' => 0,
                'logbookRevisi' => 0,
            ]);
        }

        $penempatan = $mahasiswa->penempatans()
            ->latest()
            ->first();

        if (!$penempatan) {
            return view('dashboards.mahasiswa', [
                'penempatan' => null,
                'hariMagang' => 0,
                'totalHariKerja' => 0,
                'persenKehadiran' => 0,
                'hadirCount' => 0,
                'sakitCount' => 0,
                'izinCount' => 0,
                'alpaCount' => 0,
                'totalLogbook' => 0,
                'logbookDisetujui' => 0,
                'logbookRevisi' => 0,
            ]);
        }

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        $hariIni = now()->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | MENGHITUNG HARI MAGANG YANG SUDAH BERJALAN
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | MENGHITUNG TOTAL HARI KERJA
        |--------------------------------------------------------------------------
        */

        $totalHariKerja = 0;

        $tanggal = $tanggalMulai->copy();

        while ($tanggal->lte($tanggalSelesai)) {

            if ($tanggal->isWeekday()) {
                $totalHariKerja++;
            }

            $tanggal->addDay();
        }

        /*
        |--------------------------------------------------------------------------
        | DATA ABSENSI
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KEHADIRAN
        |--------------------------------------------------------------------------
        |
        | Kehadiran dihitung dari absensi yang sudah tercatat.
        |
        | Contoh:
        | Hadir = 1
        | Sakit = 0
        | Izin  = 0
        | Alpa  = 0
        |
        | Maka:
        | 1 / 1 x 100 = 100%
        |
        */

        $totalAbsensi = $hadirCount
            + $sakitCount
            + $izinCount
            + $alpaCount;

        if ($totalAbsensi > 0) {

            $persenKehadiran = round(
                ($hadirCount / $totalAbsensi) * 100
            );

        } else {

            $persenKehadiran = 0;
        }

        if ($persenKehadiran > 100) {
            $persenKehadiran = 100;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA LOGBOOK
        |--------------------------------------------------------------------------
        */

        $totalLogbook = $penempatan->logbooks()
            ->count();

        $logbookDisetujui = $penempatan->logbooks()
            ->where('status_verifikasi', 'disetujui')
            ->count();

        $logbookRevisi = $penempatan->logbooks()
            ->where('status_verifikasi', 'revisi')
            ->count();

        $logbookMenunggu = $penempatan->logbooks()
            ->where('status_verifikasi', 'menunggu')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PROGRESS MAGANG
        |--------------------------------------------------------------------------
        |
        | Progress berdasarkan hari magang yang sudah berjalan
        | dibandingkan dengan total hari kerja.
        |
        | Contoh:
        | 15 / 89 x 100 = 16.85%
        | dibulatkan menjadi 17%.
        |
        */

        if ($totalHariKerja > 0) {

            $progress = round(
                ($hariMagang / $totalHariKerja) * 100
            );

        } else {

            $progress = 0;
        }

        if ($progress > 100) {
            $progress = 100;
        }

        if ($progress < 0) {
            $progress = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | SISA HARI MAGANG
        |--------------------------------------------------------------------------
        */

        $sisaHari = $totalHariKerja - $hariMagang;

        if ($sisaHari < 0) {
            $sisaHari = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD MAHASISWA
        |--------------------------------------------------------------------------
        */

        return view('dashboards.mahasiswa', [

            'penempatan' => $penempatan,

            'hariMagang' => $hariMagang,

            'totalHariKerja' => $totalHariKerja,

            'persenKehadiran' => $persenKehadiran,

            'hadirCount' => $hadirCount,

            'sakitCount' => $sakitCount,

            'izinCount' => $izinCount,

            'alpaCount' => $alpaCount,

            'totalAbsensi' => $totalAbsensi,

            'totalLogbook' => $totalLogbook,

            'logbookDisetujui' => $logbookDisetujui,

            'logbookRevisi' => $logbookRevisi,

            'logbookMenunggu' => $logbookMenunggu,

            'progress' => $progress,

            'sisaHari' => $sisaHari,
        ]);
    }
}