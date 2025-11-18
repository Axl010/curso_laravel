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
        Schema::create('products', function (Blueprint $table) {
            // LLAVE PRIMARIA
            $table->id(); // id BIGINT auto_increment PRIMARY KEY

            // COLUMNAS DE TEXTO
            $table->string('name'); // VARCHAR(255)
            $table->string('sku', 50)->unique(); // VARCHAR(50) UNIQUE
            $table->text('description')->nullable();

            // COLUMNAS NUMÉRICAS
            $table->decimal('price', 8,2); // DECIMAL(8,2)
            $table->integer('stock')->default(0);
            $table->integer('sold_count')->default(0);

            // COLUMNAS DE ESTADO
            $table->boolean('is_active')->default(true); // TINYINT(1)
            $table->boolean('is_feature')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // LLAVE FORÁNEA (relación con categories)
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories') // referencia a tabla categories
                  ->onDelete('set null'); // si se elimina categoría, poner NULL aquí
 
            // DATE
            $table->date('expires_at')->nullable(); // DATE
            $table->datetime('published_ad'); // DATETIME

            // TIMESTAMPS
            $table->timestamps(); // created_at, updated_at (TIMESTAMP)

            // ÍNDICES para búsquedas rápidas
            $table->index('name');
            $table->index('price');
            $table->index(['is_active','stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
