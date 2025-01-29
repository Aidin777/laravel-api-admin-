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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('grad_color_1')->nullable();
            $table->string('grad_color_2')->nullable();
            $table->string('grad_radius')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentetion_themes');
    }
};
