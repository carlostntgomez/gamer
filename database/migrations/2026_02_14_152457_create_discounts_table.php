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
        Schema::create('discounts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('code')->unique();
            $table->string('type');
            $table->decimal('value');
            $table->decimal('min_amount')->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('uses')->default(0);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('applies_to')->default('all');
            $table->text('product_ids')->nullable();
            $table->text('category_ids')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
