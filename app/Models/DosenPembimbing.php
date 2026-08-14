<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip_nidn',
        'universitas',
        'no_hp',
        'email',
    ];
}