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

            // identitas umum
            $table->string('name_asli', 100);         // nama lengkap
            $table->string('username', 50)->unique(); // alias/username

            // email resmi UKDW
            $table->string('email', 100)->unique();   // mahasiswa: nim@ukdw.ac.id, dosen: staff.ukdw.ac.id

            // role user
            $table->enum('role', ['mahasiswa','dosen']);

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
