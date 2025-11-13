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
        Schema::create('categories', function (Blueprint $table) {
              // IDENTIFICACIÓN
            $table->id();
            
            // INFORMACIÓN BÁSICA
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            
            // APARIENCIA
            $table->string('image')->nullable();
            $table->string('color', 7)->default('#3498db');
            
            // ESTADO Y POSICIÓN
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
            
            // RELACIÓN PADRE-HIJO (CATEGORÍAS JERÁRQUICAS)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories') // Referencia a la misma tabla
                  ->onDelete('set null'); // Si se elimina padre, hijas quedan sin padre
            
            // TIMESTAMPS AUTOMÁTICOS
            $table->timestamps();
            
            // ÍNDICES PARA MEJOR PERFORMANCE
            $table->index('slug'); // Búsquedas por slug rápidas
            $table->index('parent_id'); // Búsquedas de categorías hijas
            $table->index(['is_active', 'position']); // Búsquedas de categorías activas ordenadas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
