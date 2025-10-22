<?php

// database/migrations/2025_10_21_000002_add_photo_to_profiles.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'photo')) {
                $table->string('photo')->nullable()->after('tags');
            }
        });
    }
    public function down(): void {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};


