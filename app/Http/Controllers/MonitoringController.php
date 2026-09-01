<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\MonitoringExport;
use App\Exports\MonitoringIndividualExport;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $penempatans = Penempatan::with(['mahasiswa.user', 'sekolah', 'guruPamong.user'])
            ->withCount([
                'absensis',
                'absensis as hadir_count' => fn ($q) => $q->where('status', 'hadir'),
                'logbooks',
                'logbooks as logbook_disetujui_count' => fn ($q) => $q->where('status_verifikasi', 'disetujui'),
                'logbooks as logbook_menunggu_count' => fn ($q) => $q->where('status_verifikasi', 'menunggu'),
                'logbooks as logbook_revisi_count' => fn ($q) => $q->where('status_verifikasi', 'revisi'),
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('mahasiswa.user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('sekolah', fn ($q) => $q->where('nama_sekolah', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.monitoring.index', compact('penempatans', 'search'));
    }

    public function show(Penempatan $penempatan)
    {
        $hadirCount = $penempatan->absensis()->where('status', 'hadir')->count();
        $izinCount = $penempatan->absensis()->where('status', 'izin')->count();
        $sakitCount = $penempatan->absensis()->where('status', 'sakit')->count();
        $alpaTersimpan = $penempatan->absensis()->where('status', 'alpa')->count();

        $tanggalMulai = $penempatan->tanggal_mulai->copy()->startOfDay();
        $tanggalSelesai = $penempatan->tanggal_selesai->copy()->startOfDay();
        $hariIni = Carbon::today();

        if ($hariIni->lt($tanggalMulai)) {
            $alpaOtomatis = 0;
        } else {
            $tanggalAkhir = $hariIni->gt($tanggalSelesai) ? $tanggalSelesai : $hariIni;

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

    public function exportIndividual(Penempatan $penempatan)
    {
        $penempatan->load([
            'mahasiswa.user',
            'sekolah',
            'guruPamong.user',
            'absensis',
            'logbooks',
        ]);

        $namaMahasiswa = $penempatan->mahasiswa->user->name ?? 'Mahasiswa';
        $namaFile = 'Monitoring_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $namaMahasiswa) . '.xlsx';

        return Excel::download(
            new MonitoringIndividualExport($penempatan),
            $namaFile
        );
    }
}