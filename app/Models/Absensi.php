<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'penempatan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'catatan',
    ];

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class);
    }
}