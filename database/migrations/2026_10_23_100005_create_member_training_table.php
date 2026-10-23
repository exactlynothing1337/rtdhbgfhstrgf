<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ⭐ задание 3: промежуточная таблица связи «многие-ко-многим» Training ⇄ Member
    public function up(): void
    {
        Schema::create('member_training', function (Blueprint $table) {
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->primary(['member_id', 'training_id']);   // одного участника нельзя записать дважды
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_training');
    }
};
