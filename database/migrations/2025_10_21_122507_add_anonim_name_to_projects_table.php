<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // letakkan setelah user_id biar urut; kalau kolom sudah ada, abaikan manualnya
            if (!Schema::hasColumn('projects', 'anonim_name')) {
                $table->string('anonim_name', 100)->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'anonim_name')) {
                $table->dropColumn('anonim_name');
            }
        });
    }
};
