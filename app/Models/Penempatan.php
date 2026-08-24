<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'sekolah_id',
        'guru_pamong_id',
        'periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function guruPamong()
    {
        return $this->belongsTo(GuruPamong::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function absensiReopenings(): HasMany
    {
    return $this->hasMany(AbsensiReopening::class);
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function getHariSeharusnyaIsiAttribute(): int
    {
        $mulai = $this->tanggal_mulai->copy()->startOfDay();
        $selesai = $this->tanggal_selesai->copy()->startOfDay();
        $hariIni = Carbon::now()->startOfDay();

        if ($hariIni->lt($mulai)) {
            return 0;
        }

        $akhir = $hariIni->gt($selesai)
            ? $selesai
            : $hariIni;

        $hari = 0;

        $tanggal = $mulai->copy();

        while ($tanggal->lte($akhir)) {

            if ($tanggal->isWeekday()) {
                $hari++;
            }

            $tanggal->addDay();
        }

        return $hari;
    }

    public function getProgressPercentAttribute(): int
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 0;
        }

        $hariIni = Carbon::now()->startOfDay();

        $mulai = $this->tanggal_mulai
            ->copy()
            ->startOfDay();

        $selesai = $this->tanggal_selesai
            ->copy()
            ->startOfDay();

        if ($hariIni->lt($mulai)) {
            return 0;
        }

        $akhir = $hariIni->gt($selesai)
            ? $selesai
            : $hariIni;

        $hariKerjaBerjalan = 0;

        $tanggal = $mulai->copy();

        while ($tanggal->lte($akhir)) {

            if ($tanggal->isWeekday()) {
                $hariKerjaBerjalan++;
            }

            $tanggal->addDay();
        }

        if ($hariKerjaBerjalan <= 0) {
            return 0;
        }

        $absensiSelesai = $this->absensis()
            ->whereIn('status', [
                'hadir',
                'sakit',
                'izin',
            ])
            ->count();


        $logbookDisetujui = $this->logbooks()
            ->where('status_verifikasi', 'disetujui')
            ->count();


        $totalTarget = $hariKerjaBerjalan * 2;

        $totalSelesai = $absensiSelesai + $logbookDisetujui;

        if ($totalTarget <= 0) {
            return 0;
        }

        $progress = round(
            ($totalSelesai / $totalTarget) * 100
        );


        return (int) max(
            0,
            min(100, $progress)
        );
    }
}