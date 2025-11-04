<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // urutan bebas, tapi konsisten: mahasiswa, dosen, kaprodi, admin
        DB::statement(
            "ALTER TABLE `users`
             MODIFY `role` ENUM('mahasiswa','dosen','kaprodi','admin') NOT NULL"
        );
    }

    public function down(): void
    {
        // rollback ke enum semula (tanpa kaprodi)
        DB::statement(
            "ALTER TABLE `users`
             MODIFY `role` ENUM('mahasiswa','dosen','admin') NOT NULL"
        );
    }
};
