<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'penempatan_id',
        'tanggal',
        'kegiatan',
        'dokumentasi',
        'status_verifikasi',
        'catatan_guru_pamong',
        'verified_by',
        'verified_at',
    ];

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}