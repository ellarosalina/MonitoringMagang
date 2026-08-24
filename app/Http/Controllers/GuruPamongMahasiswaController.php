<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruPamongMahasiswaController extends Controller
{
    public function index()
    {
        $guruPamong = Auth::user()->guruPamong;

        $penempatans = $guruPamong->penempatans()
            ->with(['mahasiswa.user', 'sekolah'])
            ->withCount([
                'absensis',
                'absensis as hadir_count' => fn ($q) => $q->where('status', 'hadir'),
                'logbooks',
                'logbooks as logbook_menunggu_count' => fn ($q) => $q->where('status_verifikasi', 'menunggu'),
            ])
            ->latest()
            ->get();

        foreach ($penempatans as $penempatan) {

            $tanggalMulai = $penempatan->tanggal_mulai
                ->copy()
                ->startOfDay();

            $tanggalSelesai = $penempatan->tanggal_selesai
                ->copy()
                ->startOfDay();

            $hariIni = Carbon::today();

            if ($hariIni->lt($tanggalMulai)) {
                $tanggalAkhir = null;
            } else {
                $tanggalAkhir = $hariIni->gt($tanggalSelesai)
                    ? $tanggalSelesai
                    : $hariIni;
            }

            $dataAbsensi = $penempatan->absensis()
                ->get()
                ->keyBy(function ($absensi) {
                    return Carbon::parse($absensi->tanggal)->format('Y-m-d');
                });

            $dataReopening = $penempatan->absensiReopenings()
                ->get()
                ->keyBy(function ($reopening) {
                    return Carbon::parse($reopening->tanggal)->format('Y-m-d');
                });

            $rekapAbsensi = collect();

            if ($tanggalAkhir) {

                $tanggal = $tanggalMulai->copy();

                while ($tanggal->lte($tanggalAkhir)) {

                    if ($tanggal->isWeekday()) {

                        $tanggalKey = $tanggal->format('Y-m-d');

                        $absensi = $dataAbsensi->get($tanggalKey);

                        $reopening = $dataReopening->get($tanggalKey);

                        if ($absensi) {

                            $status = $absensi->status;

                        } elseif ($tanggal->isSameDay($hariIni)) {

                            $status = 'belum_absen';

                        } elseif ($reopening) {

                            $status = 'dibuka';

                        } else {

                            $status = 'alpa';
                        }

                        $rekapAbsensi->push([
                            'tanggal' => $tanggal->copy(),
                            'absensi' => $absensi,
                            'reopening' => $reopening,
                            'status' => $status,
                            'ada_data' => $absensi !== null,
                        ]);
                    }

                    $tanggal->addDay();
                }

                $rekapAbsensi = $rekapAbsensi
                    ->sortByDesc(function ($item) {
                        return $item['tanggal']->format('Y-m-d');
                    })
                    ->values();
            }

            $penempatan->rekap_absensi = $rekapAbsensi;
        }

        return view('guru-pamong.mahasiswa.index', compact('penempatans'));
    }
}