<?php

namespace App\Exports;

use App\Models\Penempatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonitoringIndividualExport implements FromCollection, WithHeadings, WithMapping
{
    protected $penempatan;

    public function __construct(Penempatan $penempatan)
    {
        $this->penempatan = $penempatan;
    }

    public function collection()
    {
        $penempatan = $this->penempatan;

        $hadir = $penempatan->absensis()->where('status', 'hadir')->count();
        $izin = $penempatan->absensis()->where('status', 'izin')->count();
        $sakit = $penempatan->absensis()->where('status', 'sakit')->count();
        $alpa = $penempatan->absensis()->where('status', 'alpa')->count();

        $totalAbsensi = $penempatan->absensis()->count();

        $totalLogbook = $penempatan->logbooks()->count();
        $logbookDisetujui = $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count();
        $logbookMenunggu = $penempatan->logbooks()->where('status_verifikasi', 'menunggu')->count();
        $logbookRevisi = $penempatan->logbooks()->where('status_verifikasi', 'revisi')->count();

        $tanggalMulai = $penempatan->tanggal_mulai
            ? $penempatan->tanggal_mulai->format('d-m-Y')
            : '-';

        $tanggalSelesai = $penempatan->tanggal_selesai
            ? $penempatan->tanggal_selesai->format('d-m-Y')
            : '-';

        return collect([
            $penempatan
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'Sekolah',
            'Guru Pamong',
            'Periode',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'Total Absensi',
            'Hadir',
            'Izin',
            'Sakit',
            'Alpa',
            'Total Logbook',
            'Logbook Disetujui',
            'Logbook Menunggu',
            'Logbook Revisi',
        ];
    }

    public function map($penempatan): array
    {
        $hadir = $penempatan->absensis()->where('status', 'hadir')->count();
        $izin = $penempatan->absensis()->where('status', 'izin')->count();
        $sakit = $penempatan->absensis()->where('status', 'sakit')->count();
        $alpa = $penempatan->absensis()->where('status', 'alpa')->count();

        $totalAbsensi = $penempatan->absensis()->count();

        $totalLogbook = $penempatan->logbooks()->count();
        $logbookDisetujui = $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count();
        $logbookMenunggu = $penempatan->logbooks()->where('status_verifikasi', 'menunggu')->count();
        $logbookRevisi = $penempatan->logbooks()->where('status_verifikasi', 'revisi')->count();

        return [
            $penempatan->mahasiswa->user->name ?? '-',
            $penempatan->sekolah->nama_sekolah ?? '-',
            $penempatan->guruPamong->user->name ?? '-',
            $penempatan->periode ?? '-',
            $penempatan->tanggal_mulai ? $penempatan->tanggal_mulai->format('d-m-Y') : '-',
            $penempatan->tanggal_selesai ? $penempatan->tanggal_selesai->format('d-m-Y') : '-',
            ucfirst($penempatan->status ?? '-'),
            $totalAbsensi,
            $hadir,
            $izin,
            $sakit,
            $alpa,
            $totalLogbook,
            $logbookDisetujui,
            $logbookMenunggu,
            $logbookRevisi,
        ];
    }
}