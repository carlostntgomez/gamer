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
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->index();
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->decimal('shipping_cost', 8, 2)->default(0);
            $table->string('sku')->unique()->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('type')->default('gadget');
            $table->string('condition')->default('nuevo');
            $table->boolean('is_featured')->default(false)->index();
            $table->json('colors')->nullable();
            $table->json('specifications')->nullable();
            $table->json('other_content')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->timestamps();
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
