<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // khusus mahasiswa
            $table->string('nim', 20)->unique()->nullable();

            // khusus dosen
            $table->string('nip', 50)->nullable();   // contoh: 104E344
            $table->string('nidn', 50)->nullable();  // contoh: 0525016601

            // identitas umum
            $table->string('name_asli', 100)->nullable();         // nama lengkap
            $table->string('username', 50)->nullable()->unique(); // alias/username

            // email resmi UKDW
            $table->string('email', 100)->nullable()->unique();   // mahasiswa: nim@ukdw.ac.id, dosen: staff.ukdw.ac.id

            // role user
            $table->enum('role', ['mahasiswa','dosen','admin']);

            // autentikasi
            $table->string('password');
            $table->rememberToken();

            // 🚫 Tidak ada created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
