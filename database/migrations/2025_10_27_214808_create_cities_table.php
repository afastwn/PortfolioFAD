<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('cities', function (Blueprint $t) {
      $t->id();
      $t->string('name');                     // "Kota Yogyakarta" / "Kabupaten Sleman"
      $t->string('type', 10)->index();        // "KOTA" | "KAB"
      $t->string('province_id', 3)->index();  // "34", "35", dst
      $t->string('province');                 // "Daerah Istimewa Yogyakarta"
      $t->decimal('lat', 10, 6);
      $t->decimal('lng', 10, 6);
      $t->json('raw')->nullable();
      $t->timestamps();

      // satu nama unik per provinsi (aman untuk kasus Indonesia)
      $t->unique(['province_id', 'name']);
    });

    Schema::table('schools', function (Blueprint $t) {
      $t->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
      $t->index(['province','regency','city']);
    });
  }

  public function down(): void {
    Schema::table('schools', function (Blueprint $t) {
      $t->dropConstrainedForeignId('city_id');
    });
    Schema::dropIfExists('cities');
  }
};