<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penempatan_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('kegiatan');
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'revisi'])->default('menunggu');
            $table->text('catatan_guru_pamong')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};