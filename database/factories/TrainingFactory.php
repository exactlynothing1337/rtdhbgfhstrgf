<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends Factory<\App\Models\Training> */
class TrainingFactory extends Factory
{
    public function definition(): array
    {
        $isGroup = fake()->boolean(65);

        return [
            'hall_id'      => Hall::factory(),
            'title'        => fake()->unique()->randomElement([
                'Утренняя йога', 'Хатха-йога', 'Вечерняя растяжка', 'Бокс для начинающих',
                'Силовая тренировка', 'Кардио-интенсив', 'Пилатес', 'Функциональный тренинг',
                'Персональный спарринг', 'Зумба', 'Круговая тренировка', 'Табата',
                'Аэробика', 'Стретчинг', 'Кроссфит', 'Тай-бо', 'Баланс и осанка',
                'Спина без боли', 'Танцы для взрослых', 'ОФП для всех', 'Бодифлекс',
                'Здоровая спина', 'Мобильность суставов', 'Интервальный бег',
            ]),
            'description'  => fake()->optional()->realText(120),
            'starts_at'    => Carbon::instance(fake()->dateTimeBetween('-1 week', '+1 month'))
                                ->setMinute(fake()->randomElement([0, 30]))->setSecond(0),
            'duration_min' => fake()->randomElement([45, 50, 60, 75, 90]),
            'max_people'   => $isGroup ? fake()->numberBetween(8, 25) : fake()->numberBetween(1, 3),
            'is_group'     => $isGroup,
        ];
    }
}
