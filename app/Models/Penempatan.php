<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'sekolah_id',
        'guru_pamong_id',
        'dosen_pembimbing_id',
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

    public function dosenPembimbing()
    {
        return $this->belongsTo(DosenPembimbing::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function getProgressPercentAttribute(): int
    {
        $mulai = $this->tanggal_mulai;
        $selesai = $this->tanggal_selesai;
        $hariIni = Carbon::now();

        if ($hariIni->lt($mulai)) {
            return 0;
        }

        $hariAcuan = $hariIni->gt($selesai) ? $selesai : $hariIni;

        $hariSeharusnyaIsi = max(1, $mulai->diffInDays($hariAcuan) + 1);

        $jumlahLogbookTerisi = $this->logbooks()->count();

        return (int) min(100, round(($jumlahLogbookTerisi / $hariSeharusnyaIsi) * 100));
    }
}