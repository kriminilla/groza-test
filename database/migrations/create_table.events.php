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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_event_id')->nullable();
            $table->string('cover')->nullable(); // path gambar cover
            $table->longText('description')->nullable();
            $table->date('event_date')->nullable();

            // Relasi ke tabel event_categories
            $table->foreign('category_event_id')
                  ->references('id')
                  ->on('event_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
