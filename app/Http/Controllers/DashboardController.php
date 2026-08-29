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
        $guruPamong = Auth::user()->guruPamong;

        if (!$guruPamong) {
            return view('dashboards.guru-pamong', [
                'mahasiswaBimbingan' => collect(),
                'mahasiswaCount' => 0,
                'menungguVerifikasi' => 0,
                'logbookDisetujui' => 0,
            ]);
        }

        $mahasiswaBimbingan = Penempatan::with([
            'mahasiswa.user',
            'sekolah'
        ])
            ->where('guru_pamong_id', $guruPamong->id)
            ->whereIn('status', ['menunggu', 'berjalan'])
            ->latest()
            ->take(5)
            ->get();

        $mahasiswaCount = Penempatan::where(
            'guru_pamong_id',
            $guruPamong->id
        )
            ->whereIn('status', ['menunggu', 'berjalan'])
            ->count();

        $penempatanIds = Penempatan::where(
            'guru_pamong_id',
            $guruPamong->id
        )->pluck('id');

        $menungguVerifikasi = Logbook::whereIn(
            'penempatan_id',
            $penempatanIds
        )
            ->where('status_verifikasi', 'menunggu')
            ->count();

        $logbookDisetujui = Logbook::whereIn(
            'penempatan_id',
            $penempatanIds
        )
            ->where('status_verifikasi', 'disetujui')
            ->count();

        return view('dashboards.guru-pamong', compact(
            'guruPamong',
            'mahasiswaBimbingan',
            'mahasiswaCount',
            'menungguVerifikasi',
            'logbookDisetujui'
        ));
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

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        $hariIni = now()->startOfDay();

        $sudahAbsenHariIni = $penempatan->absensis()
            ->whereDate('tanggal', $hariIni)
            ->exists();

        $hariIniHariKerja = $hariIni->isWeekday();

        $hariIniDalamPeriodeMagang =
            $hariIni->gte($tanggalMulai)
            && $hariIni->lte($tanggalSelesai);

        $perluAbsenHariIni =
            $hariIniHariKerja
            && $hariIniDalamPeriodeMagang
            && !$sudahAbsenHariIni;

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

        $absensiSelesai =
            $hadirCount
            + $sakitCount
            + $izinCount;

        if ($hariMagang > 0) {
            $persenKehadiran = round(
                ($absensiSelesai / $hariMagang) * 100
            );
        } else {
            $persenKehadiran = 0;
        }

        $persenKehadiran = max(
            0,
            min(100, $persenKehadiran)
        );

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