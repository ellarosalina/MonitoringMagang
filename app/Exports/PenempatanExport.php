<?php

namespace App\Exports;

use App\Models\Penempatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenempatanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $search;
    protected $status;

    public function __construct($search = null, $status = null)
    {
        $this->search = $search;
        $this->status = $status;
    }

    public function collection()
    {
        return Penempatan::with(['mahasiswa.user', 'sekolah', 'guruPamong.user'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('mahasiswa.user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('sekolah', function ($query) {
                        $query->where('nama_sekolah', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('guruPamong.user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->status && in_array($this->status, ['menunggu', 'berjalan', 'selesai', 'dibatalkan']), function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Mahasiswa',
            'Sekolah',
            'Guru Pamong',
            'Periode',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
        ];
    }

    public function map($penempatan): array
    {
        static $no = 0;

        $no++;

        return [
            $no,
            $penempatan->mahasiswa->user->name,
            $penempatan->sekolah->nama_sekolah,
            $penempatan->guruPamong->user->name,
            $penempatan->periode,
            $penempatan->tanggal_mulai,
            $penempatan->tanggal_selesai,
            ucfirst($penempatan->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Penempatan';
    }
}