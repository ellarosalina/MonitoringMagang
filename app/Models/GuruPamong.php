<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPamong extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sekolah_id',
        'nip',
        'mapel',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

     public function penempatans()
    {
        return $this->hasMany(Penempatan::class);
    }
}