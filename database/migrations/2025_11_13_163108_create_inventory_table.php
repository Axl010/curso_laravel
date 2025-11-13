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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->commit('Reference to warehouse table');
            $table->string('sku', 50)->unique();
            $table->integer('quantity')->unsigned()->default(0);
            $table->integer('min_stock')->unsigned()->default(5);
            $table->integer('max_stock')->unsigned()->default(100);
            $table->string('location', 100)->nullable();
            $table->enum('status', ['in_stock','low_stock','ot_of_stock'])->default('in_stock');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('sku');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
