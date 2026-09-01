<?php

namespace App\Http\Controllers;

use App\Models\AbsensiReopening;
use App\Models\Penempatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class GuruPamongAbsensiController extends Controller
{
    public function show(Penempatan $penempatan, Request $request)
    {
        $guruPamong = Auth::user()->guruPamong;

        if (!$guruPamong) {
            abort(403, 'Akun ini bukan Guru Pamong.');
        }

        if ($penempatan->guru_pamong_id !== $guruPamong->id) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        $hariIni = Carbon::today();

        $tanggalAkhir = $hariIni->gt($tanggalSelesai)
            ? $tanggalSelesai
            : $hariIni;

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

        if (!$hariIni->lt($tanggalMulai)) {

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
                    ]);
                }

                $tanggal->addDay();
            }
        }

        $rekapAbsensi = $rekapAbsensi
            ->sortByDesc(function ($item) {
                return $item['tanggal']->format('Y-m-d');
            })
            ->values();

        $totalAbsensi = $rekapAbsensi->count();

        $perPage = 10;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $rekapAbsensi = new LengthAwarePaginator(
            $rekapAbsensi
                ->forPage($currentPage, $perPage)
                ->values(),
            $totalAbsensi,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('guru-pamong.absensi.show', [
            'penempatan' => $penempatan,
            'rekapAbsensi' => $rekapAbsensi,
            'totalAbsensi' => $totalAbsensi,
        ]);
    }

    public function buka(Penempatan $penempatan, Request $request)
    {
        $guruPamong = Auth::user()->guruPamong;

        if (!$guruPamong) {
            abort(403, 'Akun ini bukan Guru Pamong.');
        }

        if ($penempatan->guru_pamong_id !== $guruPamong->id) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],
        ]);

        $tanggal = Carbon::parse($request->tanggal)
            ->startOfDay();

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        if ($tanggal->lt($tanggalMulai) || $tanggal->gt($tanggalSelesai)) {

            return back()->with(
                'error',
                'Tanggal tersebut berada di luar periode magang.'
            );
        }

        if ($tanggal->isWeekend()) {

            return back()->with(
                'error',
                'Absensi hanya dapat dibuka untuk hari kerja.'
            );
        }

        $absensi = $penempatan->absensis()
            ->whereDate('tanggal', $tanggal)
            ->first();

        $reopening = $penempatan->absensiReopenings()
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$absensi && $reopening) {

            return back()->with(
                'error',
                'Absensi pada tanggal tersebut sudah dibuka kembali dan sedang menunggu mahasiswa.'
            );
        }

        if ($absensi) {

            $absensi->delete();
        }

        AbsensiReopening::updateOrCreate(
            [
                'penempatan_id' => $penempatan->id,
                'tanggal' => $tanggal->format('Y-m-d'),
            ],
            [
                'guru_pamong_id' => $guruPamong->id,
                'dibuka_pada' => now(),
            ]
        );

        return back()->with(
            'success',
            'Absensi tanggal ' .
            $tanggal->locale('id')->translatedFormat('d F Y') .
            ' berhasil dibuka kembali untuk mahasiswa.'
        );
    }
}