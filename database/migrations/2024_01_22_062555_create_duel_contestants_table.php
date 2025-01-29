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
        Schema::create('duel_contestants', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('scoreboard')->nullable();
            $table->integer('nominal_score')->default(0);
            $table->foreignId("duel_id")
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('isComplete')->default(false);
            $table->boolean('isCounted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duel_contestants');
    }
};
