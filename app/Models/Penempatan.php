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

        $akhir = $hariIni->gt($selesai) ? $selesai : $hariIni;

        $hari = 0;
        $tanggal = $mulai->copy();
        while ($tanggal->lte($akhir)) {
            if ($tanggal->isWeekday()) {
                $hari++;
            }
            $tanggal->addDay();
        }

        return max(1, $hari);
    }

    public function getProgressPercentAttribute(): int
    {
        if ($this->tanggal_mulai->gt(Carbon::now())) {
            return 0;
        }

        $jumlahLogbookTerisi = $this->logbooks()->count();

        return (int) min(100, round(($jumlahLogbookTerisi / $this->hari_seharusnya_isi) * 100));
    }
}