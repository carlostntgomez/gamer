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
            $table->integer('id')->primary();
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('price')->index();
            $table->decimal('sale_price')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->integer('stock_quantity')->default(0);
            $table->string('type')->default('gadget');
            $table->string('condition')->default('new');
            $table->string('video_url')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_new')->default(false);
            $table->text('colors')->nullable();
            $table->text('specifications')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->text('delivery_info')->nullable();
            $table->text('return_policy')->nullable();
            $table->string('main_image_path')->nullable();
            $table->text('gallery_image_paths')->nullable();
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
