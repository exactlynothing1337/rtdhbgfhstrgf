<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');   // новый столбец
            $table->string('title', 121)->change();                    // STR_LEN = 100 + 3·7 = 121
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('title', 100)->change();                    // исходная длина
        });
    }
};
