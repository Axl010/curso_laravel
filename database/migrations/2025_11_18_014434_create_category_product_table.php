<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            // LLAVES FORÁNEAS
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade'); // Si eliminas producto, elimina relaciones

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade'); // Si eliminas categoría, elimina relaciones

            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();

            // ÍNDICES PARA OPTIMIZACIÓN
            $table->index('product_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
