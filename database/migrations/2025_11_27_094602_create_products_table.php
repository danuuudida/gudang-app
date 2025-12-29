<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 100)->unique();
            $table->string('nama_barang');
            $table->string('sku', 100)->nullable();
            $table->integer('stok')->default(0);
            $table->string('satuan', 50)->nullable()->default('pcs');
            $table->decimal('harga_beli', 15, 2)->nullable();
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index('barcode');
            $table->index('nama_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};