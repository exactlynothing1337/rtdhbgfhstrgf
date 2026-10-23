<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')
                ->constrained()                        // внешний ключ на halls.id
                ->cascadeOnDelete();                   // ON_DELETE: N = 7 (нечётный) → cascade
            $table->string('title', 100);
            $table->dateTime('starts_at');
            $table->unsignedInteger('duration_min');
            $table->unsignedInteger('max_people');
            $table->boolean('is_group')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
