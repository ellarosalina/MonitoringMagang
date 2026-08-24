<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Penempatan;
use App\Models\GuruPamong;

class AbsensiReopening extends Model
{
    use HasFactory;

    protected $table = 'absensi_reopenings';

    protected $fillable = [
        'penempatan_id',
        'guru_pamong_id',
        'tanggal',
        'dibuka_pada',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'dibuka_pada' => 'datetime',
    ];

    public function penempatan(): BelongsTo
    {
        return $this->belongsTo(Penempatan::class);
    }

    public function guruPamong(): BelongsTo
    {
        return $this->belongsTo(GuruPamong::class);
    }
}