<?php

namespace App\Http\Controllers;

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

        return view('guru-pamong.mahasiswa.index', compact('penempatans'));
    }
}