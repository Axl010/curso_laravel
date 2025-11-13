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
        Schema::table('products', function (Blueprint $table) {
            // $table->dropColumn('sold_count');
            // $table->dropColumn('status');
            // $table->dropColumn('published_ad');

            $table->dropColumn([
                'sold_count',
                'status',
                'published_ad',
                'is_feature'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1. AGREGAR LAS COLUMNAS DE VUELTA CON SUS PROPIEDADES ORIGINALES
            $table->integer('sold_count')->default(0);
            $table->boolean('is_feature')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('is_feature');
            $table->datetime('published_ad');
        });
    }
};