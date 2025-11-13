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
        Schema::table('categories', function (Blueprint $table) {
            // 1. ELIMINAR ÍNDICES PRIMERO (Buenas prácticas)
            $table->dropIndex(['slug']); // Eliminar índice único del slug
            $table->dropIndex(['is_active','position']); // Eliminar índice único del slug

            // 2. ELIMINAR RESTRICCIONES DE LLAVE FORÁNEA (si existieran)
            // No aplica en este caso ya que no hay FKs referenciando estas columnas

            // 3. ELIMINAR LAS COLUMNAS
            $table->dropColumn('slug');
            $table->dropColumn('position');

            // 4. ACTUALIZAR ÍNDICES (recrear sin las columnas eliminadas)
            $table->index(['is_active']); // Nuevo índice solo para is_active
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // 1. AGREGAR LAS COLUMNAS DE VUELTA
            $table->string('slug', 120)->nullable()->after('name');
            $table->integer('position')->default(0)->after('is_active');

            // 2. RECREAR ÍNDICES
            $table->unique('slug'); // Índice único para slug
            $table->index(['is_active', 'position']); // Índice compuesto

            // 3. ELIMINAR ÍNDICE TEMPORAL (si se creó en el up)
            $table->dropIndex(['is_active']);
        });
    }
};
