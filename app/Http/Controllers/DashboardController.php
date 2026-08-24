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

                'totalAbsensi' => 0,

                'totalLogbook' => 0,

                'logbookDisetujui' => 0,

                'logbookRevisi' => 0,

                'logbookMenunggu' => 0,

                'progress' => 0,

                'sisaHari' => 0,

                'sudahAbsenHariIni' => false,

                'perluAbsenHariIni' => false,
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

                'totalAbsensi' => 0,

                'totalLogbook' => 0,

                'logbookDisetujui' => 0,

                'logbookRevisi' => 0,

                'logbookMenunggu' => 0,

                'progress' => 0,

                'sisaHari' => 0,

                'sudahAbsenHariIni' => false,

                'perluAbsenHariIni' => false,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TANGGAL MAGANG
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        $hariIni = now()->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | CEK ABSENSI HARI INI
        |--------------------------------------------------------------------------
        |
        | Kita cek langsung ke database apakah mahasiswa sudah memiliki
        | data absensi dengan tanggal hari ini.
        |
        */

        $sudahAbsenHariIni = $penempatan->absensis()
            ->whereDate('tanggal', $hariIni)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH HARI INI HARI KERJA
        |--------------------------------------------------------------------------
        */

        $hariIniHariKerja = $hariIni->isWeekday();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH HARI INI MASIH DALAM PERIODE MAGANG
        |--------------------------------------------------------------------------
        */

        $hariIniDalamPeriodeMagang =
            $hariIni->gte($tanggalMulai)
            && $hariIni->lte($tanggalSelesai);

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN APAKAH PERLU ABSEN HARI INI
        |--------------------------------------------------------------------------
        |
        | Notifikasi hanya muncul jika:
        |
        | 1. Hari ini hari kerja
        | 2. Hari ini berada dalam periode magang
        | 3. Mahasiswa belum melakukan absensi
        |
        */

        $perluAbsenHariIni =
            $hariIniHariKerja
            && $hariIniDalamPeriodeMagang
            && !$sudahAbsenHariIni;

        /*
        |--------------------------------------------------------------------------
        | HARI MAGANG YANG SUDAH BERJALAN
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
        | TOTAL HARI KERJA SELAMA MAGANG
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
        | ABSENSI YANG DIANGGAP SELESAI
        |--------------------------------------------------------------------------
        |
        | Hadir = dihitung
        | Sakit = dihitung
        | Izin  = dihitung
        | Alpa  = tidak dihitung
        | Belum absen = tidak dihitung
        |
        */

        $absensiSelesai =
            $hadirCount
            + $sakitCount
            + $izinCount;

        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KEHADIRAN
        |--------------------------------------------------------------------------
        |
        | Penyebut menggunakan jumlah hari kerja yang sudah berjalan.
        |
        | Contoh:
        |
        | Hari kerja berjalan = 16
        | Absensi selesai = 15
        |
        | 15 / 16 x 100
        | = 93,75%
        | = 94%
        |
        */

        if ($hariMagang > 0) {

            $persenKehadiran = round(
                ($absensiSelesai / $hariMagang) * 100
            );

        } else {

            $persenKehadiran = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | BATASI KEHADIRAN
        |--------------------------------------------------------------------------
        */

        $persenKehadiran = max(
            0,
            min(100, $persenKehadiran)
        );

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


        if ($hariMagang > 0) {

            $totalTargetProgress = $hariMagang * 2;

            $totalProgressSelesai =
                $absensiSelesai
                + $logbookDisetujui;

            $progress = round(
                ($totalProgressSelesai / $totalTargetProgress) * 100
            );

        } else {

            $progress = 0;
        }


        $progress = max(
            0,
            min(100, $progress)
        );

        $sisaHari = $totalHariKerja - $hariMagang;

        if ($sisaHari < 0) {
            $sisaHari = 0;
        }
        return view('dashboards.mahasiswa', [

            'penempatan' => $penempatan,

            'hariMagang' => $hariMagang,

            'totalHariKerja' => $totalHariKerja,

            'persenKehadiran' => $persenKehadiran,

            'hadirCount' => $hadirCount,

            'sakitCount' => $sakitCount,

            'izinCount' => $izinCount,

            'alpaCount' => $alpaCount,

            'totalAbsensi' => $absensiSelesai,

            'totalLogbook' => $totalLogbook,

            'logbookDisetujui' => $logbookDisetujui,

            'logbookRevisi' => $logbookRevisi,

            'logbookMenunggu' => $logbookMenunggu,

            'progress' => $progress,

            'sisaHari' => $sisaHari,

            'sudahAbsenHariIni' => $sudahAbsenHariIni,

            'perluAbsenHariIni' => $perluAbsenHariIni,
        ]);
    }
}