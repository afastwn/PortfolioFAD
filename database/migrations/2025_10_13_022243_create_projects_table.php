<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ===== Basic Info =====
            // $table->string('anonim_name', 100)->nullable(); // Nama anonim mahasiswa (dibuat pertama kali di Semester 1)
            $table->string('title');                 // Project Title
            $table->string('category')->nullable();  // 51 kategori (string)
            $table->string('course')->nullable();    // Mata kuliah
            $table->string('client')->nullable();
            $table->date('project_date')->nullable();
            $table->unsignedTinyInteger('semester'); // 1..8
            $table->unique(['user_id','semester']);  // 1 project per semester per user

            $table->text('design_brief')->nullable();      // Concept/abstract
            $table->text('design_process')->nullable();    // Data, sketch, prototyping
            $table->string('spec_material')->nullable();   // Material
            $table->string('spec_size')->nullable();       // Size

            // ===== Upload Section (arrays JSON) =====
            $table->json('final_product_photos')->nullable();
            $table->json('design_process_photos')->nullable();
            $table->json('testing_photos')->nullable();
            $table->json('display_photos')->nullable(); // dipakai sbg cover di MyWorks
            $table->json('poster_images')->nullable();
            $table->json('videos')->nullable(); // path file atau URL

            // statistik ringan
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};