<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;

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
        $penempatan->load(['mahasiswa.user', 'sekolah', 'guruPamong.user']);

        $absensiPerStatus = [
            'hadir' => $penempatan->absensis()->where('status', 'hadir')->count(),
            'izin' => $penempatan->absensis()->where('status', 'izin')->count(),
            'sakit' => $penempatan->absensis()->where('status', 'sakit')->count(),
            'alpa' => $penempatan->absensis()->where('status', 'alpa')->count(),
        ];

        $logbookPerStatus = [
            'menunggu' => $penempatan->logbooks()->where('status_verifikasi', 'menunggu')->count(),
            'disetujui' => $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count(),
            'revisi' => $penempatan->logbooks()->where('status_verifikasi', 'revisi')->count(),
        ];

        $logbooks = $penempatan->logbooks()->orderBy('tanggal', 'desc')->get();

        return view('admin.monitoring.show', compact('penempatan', 'absensiPerStatus', 'logbookPerStatus', 'logbooks'));
    }
}