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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->unique()->nullable();

            $table->boolean('isPremium')->default(false);
            $table->boolean('inDuel')->default(false);
            $table->boolean('inQueu')->default(false);
            $table->boolean('approwed_promo')->default(false);
            $table->integer('role')->default(1);

            $table->integer('duel_wins')->default(0);
            $table->integer('duel_loses')->default(0);
            $table->integer('duel_draws')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
