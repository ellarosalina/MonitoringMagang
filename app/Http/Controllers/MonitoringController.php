<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;
use Carbon\Carbon;
use App\Exports\MonitoringExport;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringController extends Controller
{
    public function index()
    {
        $penempatans = Penempatan::with(['mahasiswa.user', 'sekolah', 'guruPamong.user'])
            ->withCount([
                'absensis',
                'absensis as hadir_count' => fn ($q) => $q->where('status', 'hadir'),
                'logbooks',
                'logbooks as logbook_disetujui_count' => fn ($q) => $q->where('status_verifikasi', 'disetujui'),
                'logbooks as logbook_menunggu_count' => fn ($q) => $q->where('status_verifikasi', 'menunggu'),
                'logbooks as logbook_revisi_count' => fn ($q) => $q->where('status_verifikasi', 'revisi'),
            ])
            ->latest()
            ->paginate(10);

        return view('admin.monitoring.index', compact('penempatans'));
    }

    public function show(Penempatan $penempatan)
    {
        $hadirCount = $penempatan->absensis()->where('status', 'hadir')->count();
        $izinCount = $penempatan->absensis()->where('status', 'izin')->count();
        $sakitCount = $penempatan->absensis()->where('status', 'sakit')->count();
        $alpaTersimpan = $penempatan->absensis()->where('status', 'alpa')->count();
        $tanggalMulai = $penempatan->tanggal_mulai->copy()->startOfDay();
        $tanggalSelesai = $penempatan->tanggal_selesai->copy()->startOfDay();
        $hariIni = Carbon::today();if ($hariIni->lt($tanggalMulai)) {
            $alpaOtomatis = 0;
            } else {
                $tanggalAkhir = $hariIni->gt($tanggalSelesai)? $tanggalSelesai: $hariIni;
                $tanggalSudahAbsen = $penempatan->absensis()->pluck('tanggal')->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('Y-m-d');
            })->unique()->values()->toArray();
            $alpaOtomatis = 0;
            $tanggal = $tanggalMulai->copy();
            while ($tanggal->lt($tanggalAkhir)) {
                if ($tanggal->isWeekday()) {
                    $tanggalKey = $tanggal->format('Y-m-d');
                    if (!in_array($tanggalKey, $tanggalSudahAbsen)) {
                        $alpaOtomatis++;
                        }
            }
            $tanggal->addDay();
            }
        }
        $alpaCount = $alpaTersimpan + $alpaOtomatis;
        $absensiPerStatus = [
            'hadir' => $hadirCount,
            'izin' => $izinCount,
            'sakit' => $sakitCount,
            'alpa' => $alpaCount,
            ];
        $logbookPerStatus = [
            'menunggu' => $penempatan->logbooks()->where('status_verifikasi', 'menunggu')->count(),
            'disetujui' => $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count(),
            'revisi' => $penempatan->logbooks()->where('status_verifikasi', 'revisi')->count(),
        ];

        $logbooks = $penempatan->logbooks()->orderBy('tanggal', 'desc')->get();

        return view('admin.monitoring.show', compact('penempatan', 'absensiPerStatus', 'logbookPerStatus', 'logbooks'));
    }

    public function export()
    {
        return Excel::download(new MonitoringExport, 'rekap-monitoring-magang-' . now()->format('Y-m-d') . '.xlsx');
    }
}