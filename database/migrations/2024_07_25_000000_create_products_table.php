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
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->decimal('price', 10, 2)->index();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->unique()->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('type')->default('gadget');
            $table->string('condition')->default('new');
            $table->string('video_url')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_new')->default(false);
            $table->json('colors')->nullable();
            $table->json('specifications')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('seo_title', 60)->nullable();
            $table->string('seo_description', 160)->nullable();
            $table->json('seo_keywords')->nullable();
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
