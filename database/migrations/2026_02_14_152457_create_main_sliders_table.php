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
        Schema::create('main_sliders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title');
            $table->string('subtitle');
            $table->string('image_path');
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('image_path_mobile')->nullable();
            $table->boolean('is_visible')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_sliders');
    }
};
