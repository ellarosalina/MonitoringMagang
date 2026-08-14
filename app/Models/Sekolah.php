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
        'alamat',
        'kecamatan',
        'kepala_sekolah',
        'no_telp',
        'email',
        'kuota_magang',
        'status',
    ];

    public function guruPamongs()
    {
        return $this->hasMany(GuruPamong::class);
    }
}