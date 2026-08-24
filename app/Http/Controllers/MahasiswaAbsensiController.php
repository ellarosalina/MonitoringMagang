<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiReopening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaAbsensiController extends Controller
{
    public function index()
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return view('mahasiswa.absensi.index', [
                'penempatan' => null,
                'rekapAbsensi' => collect(),
            ]);
        }

        $tanggalMulai = $penempatan->tanggal_mulai->copy()->startOfDay();
        $tanggalSelesai = $penempatan->tanggal_selesai->copy()->startOfDay();
        $hariIni = Carbon::today();

        if ($hariIni->lt($tanggalMulai)) {
            $rekapAbsensi = collect();
        } else {
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

            $tanggal = $tanggalMulai->copy();

            while ($tanggal->lte($tanggalAkhir)) {

                if ($tanggal->isWeekday()) {

                    $tanggalKey = $tanggal->format('Y-m-d');

                    $absensi = $dataAbsensi->get($tanggalKey);
                    $reopening = $dataReopening->get($tanggalKey);

                    if ($absensi) {

                        $rekapAbsensi->push([
                            'tanggal' => $tanggal->copy(),
                            'absensi' => $absensi,
                            'status' => $absensi->status,
                            'jam_masuk' => $absensi->jam_masuk,
                            'jam_pulang' => $absensi->jam_pulang,
                            'ada_data' => true,
                            'dibuka_kembali' => false,
                        ]);

                    } else {

                        if ($tanggal->isSameDay($hariIni)) {
                            $status = 'belum_absen';
                        } elseif ($reopening) {
                            $status = 'dibuka';
                        } else {
                            $status = 'alpa';
                        }

                        $rekapAbsensi->push([
                            'tanggal' => $tanggal->copy(),
                            'absensi' => null,
                            'status' => $status,
                            'jam_masuk' => null,
                            'jam_pulang' => null,
                            'ada_data' => false,
                            'dibuka_kembali' => $reopening !== null,
                        ]);
                    }
                }

                $tanggal->addDay();
            }

            $rekapAbsensi = $rekapAbsensi
                ->sortByDesc(function ($item) {
                    return $item['tanggal']->format('Y-m-d');
                })
                ->values();
        }

        return view('mahasiswa.absensi.index', [
            'penempatan' => $penempatan,
            'rekapAbsensi' => $rekapAbsensi,
        ]);
    }

    public function create(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Anda belum memiliki penempatan magang. Hubungi Admin GTK.');
        }

        $hariIni = Carbon::today();

        $tanggalInput = $request->query('tanggal');

        if ($tanggalInput) {
            try {
                $tanggalYangDipilih = Carbon::parse($tanggalInput)->startOfDay();
            } catch (\Exception $e) {
                return redirect()
                    ->route('mahasiswa.absensi.index')
                    ->with('error', 'Tanggal absensi tidak valid.');
            }
        } else {
            $tanggalYangDipilih = $hariIni->copy()->startOfDay();
        }

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        if (
            $tanggalYangDipilih->lt($tanggalMulai) ||
            $tanggalYangDipilih->gt($tanggalSelesai)
        ) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Tanggal absensi berada di luar periode magang.');
        }

        if ($tanggalYangDipilih->isWeekend()) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi hanya dapat diisi pada hari kerja, yaitu Senin sampai Jumat.');
        }

        $sudahAbsen = $penempatan->absensis()
            ->whereDate('tanggal', $tanggalYangDipilih)
            ->exists();

        if ($sudahAbsen) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi pada tanggal tersebut sudah diisi.');
        }

        $reopening = $penempatan->absensiReopenings()
            ->whereDate('tanggal', $tanggalYangDipilih)
            ->first();

        $bolehIsiTanggalLama = $reopening !== null;

        if (
            !$tanggalYangDipilih->isSameDay($hariIni) &&
            !$bolehIsiTanggalLama
        ) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi tanggal tersebut belum dibuka kembali oleh Guru Pamong.');
        }

        $hariHariIni = $tanggalYangDipilih
            ->locale('id')
            ->translatedFormat('l');

        return view('mahasiswa.absensi.create', [
            'penempatan' => $penempatan,
            'tanggalHariIni' => $tanggalYangDipilih,
            'hariHariIni' => $hariHariIni,
            'sudahAbsen' => $sudahAbsen,
            'reopening' => $reopening,
            'bolehIsiTanggalLama' => $bolehIsiTanggalLama,
        ]);
    }

    public function store(Request $request)
    {
        $penempatan = Auth::user()->mahasiswa->penempatans()->latest()->first();

        if (!$penempatan) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Anda belum memiliki penempatan magang.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $tanggal = Carbon::parse($request->tanggal)->startOfDay();

        $hariIni = Carbon::today();

        $tanggalMulai = $penempatan->tanggal_mulai
            ->copy()
            ->startOfDay();

        $tanggalSelesai = $penempatan->tanggal_selesai
            ->copy()
            ->startOfDay();

        if (
            $tanggal->lt($tanggalMulai) ||
            $tanggal->gt($tanggalSelesai)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Tanggal absensi berada di luar periode magang.'
                ]);
        }

        if ($tanggal->isWeekend()) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Absensi hanya dapat diisi pada hari kerja.'
                ]);
        }

        $reopening = $penempatan->absensiReopenings()
            ->whereDate('tanggal', $tanggal)
            ->first();

        $bolehIsiTanggalLama = $reopening !== null;

        if (
            !$tanggal->isSameDay($hariIni) &&
            !$bolehIsiTanggalLama
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Tanggal tersebut belum dibuka kembali oleh Guru Pamong.'
                ]);
        }

        $sudahAbsen = $penempatan->absensis()
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if ($sudahAbsen) {
            return redirect()
                ->route('mahasiswa.absensi.index')
                ->with('error', 'Absensi pada tanggal tersebut sudah diisi.');
        }

        Absensi::create([
            'penempatan_id' => $penempatan->id,
            'tanggal' => $tanggal->format('Y-m-d'),
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('mahasiswa.absensi.index')
            ->with(
                'success',
                'Absensi tanggal ' .
                $tanggal->locale('id')->translatedFormat('d F Y') .
                ' berhasil disimpan.'
            );
    }

    public function edit(Absensi $absensi)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($absensi->penempatan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Anda tidak memiliki akses ke absensi ini.');
        }

        return view('mahasiswa.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($absensi->penempatan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Anda tidak memiliki akses ke absensi ini.');
        }

        $request->validate([
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $absensi->update([
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('mahasiswa.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }
}