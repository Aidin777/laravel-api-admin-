<?php

use App\Models\Lesson;
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
        Schema::create('lesson_tests', function (Blueprint $table) {
            $table->id();
            $table->json('content');
            $table->string('type')->nullable();
            $table->boolean('have_text')->default(false);
            $table->text('text')->nullable();
            $table->foreignIdFor(Lesson::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_tests');
    }
};
