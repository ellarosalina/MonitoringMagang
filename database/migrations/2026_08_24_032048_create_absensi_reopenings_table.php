<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_reopenings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penempatan_id')
                ->constrained('penempatans')
                ->cascadeOnDelete();

            $table->foreignId('guru_pamong_id')
                ->constrained('guru_pamongs')
                ->restrictOnDelete();

            $table->date('tanggal');

            $table->timestamp('dibuka_pada')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'penempatan_id',
                'tanggal'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_reopenings');
    }
};