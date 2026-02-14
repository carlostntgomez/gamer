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
        Schema::table('category_product', function (Blueprint $table) {
            $table->foreign(['product_id'], null)->references(['id'])->on('products')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['category_id'], null)->references(['id'])->on('categories')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_product', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};
