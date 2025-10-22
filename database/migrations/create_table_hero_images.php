<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('hero_image', function (Blueprint $table) {
            $table->id();
            $table->string('src'); // path atau URL gambar
            $table->string('alt')->nullable(); // teks alternatif untuk SEO & aksesibilitas
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_image');
    }
};
