<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'universitas',
        'fakultas',
        'dosen_pembimbing',
        'prodi',
        'no_hp',
        'alamat',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class);
    }
}