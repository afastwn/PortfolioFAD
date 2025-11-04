<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ Tambah kolom NIK (Nomor Induk Kepegawaian)
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 50)->nullable()->unique()->after('nim');
            }

            // 🚫 Hapus kolom nip & nidn kalau masih ada
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('users', 'nidn')) {
                $table->dropColumn('nidn');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom lama jika perlu rollback
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip', 50)->nullable();
            }
            if (!Schema::hasColumn('users', 'nidn')) {
                $table->string('nidn', 50)->nullable();
            }

            if (Schema::hasColumn('users', 'nik')) {
                $table->dropUnique('users_nik_unique');
                $table->dropColumn('nik');
            }
        });
    }
};
