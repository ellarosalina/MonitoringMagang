<?php

namespace App\Models;

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
}