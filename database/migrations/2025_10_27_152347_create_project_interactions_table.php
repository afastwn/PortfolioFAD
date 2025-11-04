<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('anon_key', 64)->nullable(); // publik pakai cookie anon
            $table->boolean('liked')->default(false);
            $table->json('comments')->nullable(); // array kalimat komentar preset
            $table->timestamps();

            $table->unique(['project_id', 'user_id']);
            $table->unique(['project_id', 'anon_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_interactions');
    }
};
