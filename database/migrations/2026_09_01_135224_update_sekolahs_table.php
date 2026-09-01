<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sekolahs', 'jenjang')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->string('jenjang')->nullable()->after('kepala_sekolah');
            });
        }

        if (!Schema::hasColumn('sekolahs', 'kabupaten')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->string('kabupaten')->nullable()->after('kecamatan');
            });
        }

        Schema::table('sekolahs', function (Blueprint $table) {
            $table->string('status')->default('negeri')->change();
        });

        DB::table('sekolahs')
            ->where('status', 'aktif')
            ->update(['status' => 'negeri']);

        DB::table('sekolahs')
            ->where('status', 'nonaktif')
            ->update(['status' => 'swasta']);

        Schema::table('sekolahs', function (Blueprint $table) {
            $table->enum('status', ['negeri', 'swasta'])->default('negeri')->change();
        });

        if (Schema::hasColumn('sekolahs', 'no_telp')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->dropColumn('no_telp');
            });
        }

        if (Schema::hasColumn('sekolahs', 'email')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }

    public function down(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->string('status')->default('aktif')->change();
        });

        DB::table('sekolahs')
            ->where('status', 'negeri')
            ->update(['status' => 'aktif']);

        DB::table('sekolahs')
            ->where('status', 'swasta')
            ->update(['status' => 'nonaktif']);

        Schema::table('sekolahs', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->change();
        });

        if (!Schema::hasColumn('sekolahs', 'no_telp')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->string('no_telp')->nullable();
            });
        }

        if (!Schema::hasColumn('sekolahs', 'email')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->string('email')->nullable();
            });
        }

        if (Schema::hasColumn('sekolahs', 'jenjang')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->dropColumn('jenjang');
            });
        }

        if (Schema::hasColumn('sekolahs', 'kabupaten')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->dropColumn('kabupaten');
            });
        }
    }
};