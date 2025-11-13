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
        Schema::table('inventory', function (Blueprint $table) {
            // RENAME COLUMN: quantity → current_stock
            $table->renameColumn('quantity','current_stock');

            // MODIFY EXISTING COLUMNS WITH NEW DEFAULTS
            $table->integer('current_stock')->unsigned()->default(10)->change();
            $table->integer('min_stock')->unsigned()->default(10)->change();
            $table->integer('max_stock')->unsigned()->default(500)->change();
            
            $table->boolean('is_active')->default(true)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
             // REVERT COLUMN RENAME
            $table->renameColumn('current_stock', 'quantity');
            
            // REVERT COLUMN MODIFICATIONS
            $table->integer('quantity')->unsigned()->default(0)->change();
            $table->integer('min_stock')->unsigned()->default(5)->change();
            $table->integer('max_stock')->unsigned()->default(100)->change();
            
            // REMOVE ADDED COLUMNS
            $table->dropColumn('is_active');
        });
    }
};
