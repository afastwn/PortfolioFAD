<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            // penerima notifikasi = pemilik proyek
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();

            // aktor (yang memberi like/komentar): user atau anon
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('actor_anon_key', 64)->nullable();

            // tipe: like | comment
            $table->string('type', 20);

            // payload opsional (misal array komentar yg dipilih)
            $table->json('payload')->nullable();

            $table->timestamps();

            $table->index(['owner_user_id','created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_notifications');
    }
};
