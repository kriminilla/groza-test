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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image')->nullable(); // gambar utama produk
            $table->string('logo')->nullable();  // logo brand produk
            $table->string('caption')->nullable(); // keterangan singkat
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();

            // Relasi ke tabel kategori
            $table->foreign('category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('set null');

            $table->foreign('subcategory_id')
                  ->references('id')
                  ->on('product_subcategories')
                  ->onDelete('set null');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
