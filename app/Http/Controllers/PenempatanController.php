<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbing;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use App\Models\Penempatan;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        $penempatans = Penempatan::with([
            'mahasiswa.user',
            'sekolah',
            'guruPamong.user',
            'dosenPembimbing'
        ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.penempatan.index',
            compact('penempatans')
        );
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::with('user')->get();

        $sekolahs = Sekolah::where('status', 'aktif')->get();

        $guruPamongs = GuruPamong::with('user')->get();

        $dosenPembimbings = DosenPembimbing::all();

        return view(
            'admin.penempatan.create',
            compact(
                'mahasiswas',
                'sekolahs',
                'guruPamongs',
                'dosenPembimbings'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',

            'sekolah_id' => 'required|exists:sekolahs,id',

            'guru_pamong_id' => 'required|exists:guru_pamongs,id',

            'dosen_pembimbing_id' =>
                'nullable|exists:dosen_pembimbings,id',

            'periode' =>
                'required|string|max:100',

            'tanggal_mulai' =>
                'required|date',

            'tanggal_selesai' =>
                'required|date|after_or_equal:tanggal_mulai',

            'status' =>
                'required|in:menunggu,berjalan,selesai,dibatalkan',
        ]);

        Penempatan::create($validated);

        return redirect()
            ->route('admin.penempatan.index')
            ->with(
                'success',
                'Data penempatan berhasil ditambahkan.'
            );
    }

    public function show(Penempatan $penempatan)
    {
        $penempatan->load([
            'mahasiswa.user',
            'sekolah',
            'guruPamong.user',
            'dosenPembimbing'
        ]);

        return view(
            'admin.penempatan.show',
            compact('penempatan')
        );
    }

    public function edit(Penempatan $penempatan)
    {
        $mahasiswas = Mahasiswa::with('user')->get();

        $sekolahs = Sekolah::where('status', 'aktif')->get();

        $guruPamongs = GuruPamong::with('user')->get();

        $dosenPembimbings = DosenPembimbing::all();

        return view(
            'admin.penempatan.edit',
            compact(
                'penempatan',
                'mahasiswas',
                'sekolahs',
                'guruPamongs',
                'dosenPembimbings'
            )
        );
    }

    public function update(
        Request $request,
        Penempatan $penempatan
    ) {
        $validated = $request->validate([
            'mahasiswa_id' =>
                'required|exists:mahasiswas,id',

            'sekolah_id' =>
                'required|exists:sekolahs,id',

            'guru_pamong_id' =>
                'required|exists:guru_pamongs,id',

            'dosen_pembimbing_id' =>
                'nullable|exists:dosen_pembimbings,id',

            'periode' =>
                'required|string|max:100',

            'tanggal_mulai' =>
                'required|date',

            'tanggal_selesai' =>
                'required|date|after_or_equal:tanggal_mulai',

            'status' =>
                'required|in:menunggu,berjalan,selesai,dibatalkan',
        ]);

        $penempatan->update($validated);

        return redirect()
            ->route('admin.penempatan.index')
            ->with('success','Data penempatan berhasil diperbarui.'
            );
    }

    
    public function destroy(Penempatan $penempatan)
    {
        $penempatan->delete();

        return redirect()
            ->route('admin.penempatan.index')
            ->with('success','Data penempatan berhasil dihapus.');
    }
}