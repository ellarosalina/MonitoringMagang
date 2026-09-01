<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('nama_sekolah');
            $table->string('kepala_sekolah')->nullable();
            $table->string('jenjang');
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->text('alamat');
            $table->enum('status', ['negeri', 'swasta'])->default('negeri');
            $table->integer('kuota_magang')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};