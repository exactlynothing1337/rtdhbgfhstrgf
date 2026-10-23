<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Member;
use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $halls = Hall::factory()->count(4)->create();                // PARENTS = 3 + (7 mod 3) = 4

        $trainings = Training::factory()
            ->count(19)                                              // SEED = 12 + 7 = 19
            ->recycle($halls)                                        // только созданные залы
            ->create();

        // ⭐ участники и записи на тренировки (M:N)
        $members = Member::factory()->count(15)->create();

        foreach ($trainings as $training) {
            $take = min($training->max_people, random_int(0, 6));    // не больше мест в группе
            $training->members()->attach($members->random($take)->pluck('id'));
        }
    }
}
