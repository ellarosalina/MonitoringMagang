<?php

namespace App\Exports;

use App\Models\Penempatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonitoringExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Penempatan::with(['mahasiswa.user', 'sekolah', 'guruPamong.user'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Universitas',
            'Program Studi',
            'Dosen Pembimbing',
            'Sekolah',
            'Guru Pamong',
            'Periode',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'Progress (%)',
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
        return [
            $penempatan->mahasiswa->user->name,
            $penempatan->mahasiswa->nim,
            $penempatan->mahasiswa->universitas,
            $penempatan->mahasiswa->prodi,
            $penempatan->mahasiswa->dosen_pembimbing ?? '-',
            $penempatan->sekolah->nama_sekolah,
            $penempatan->guruPamong->user->name,
            $penempatan->periode,
            $penempatan->tanggal_mulai->format('d-m-Y'),
            $penempatan->tanggal_selesai->format('d-m-Y'),
            ucfirst($penempatan->status),
            $penempatan->progress_percent,
            $penempatan->absensis()->where('status', 'hadir')->count(),
            $penempatan->absensis()->where('status', 'izin')->count(),
            $penempatan->absensis()->where('status', 'sakit')->count(),
            $penempatan->absensis()->where('status', 'alpa')->count(),
            $penempatan->logbooks()->count(),
            $penempatan->logbooks()->where('status_verifikasi', 'disetujui')->count(),
            $penempatan->logbooks()->where('status_verifikasi', 'menunggu')->count(),
            $penempatan->logbooks()->where('status_verifikasi', 'revisi')->count(),
        ];
    }
}