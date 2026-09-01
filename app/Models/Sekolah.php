<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'kepala_sekolah',
        'jenjang',
        'kecamatan',
        'kabupaten',
        'alamat',
        'status',
        'kuota_magang',
    ];

    public function guruPamongs()
    {
        return $this->hasMany(GuruPamong::class);
    }
}