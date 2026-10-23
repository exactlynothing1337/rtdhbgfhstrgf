<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Hall> */
class HallFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Зал йоги', 'Зал бокса', 'Тренажёрный зал', 'Кардио-зал',
                'Зал пилатеса', 'Танцевальный зал', 'Зал единоборств', 'Зал функционала',
            ]),
            'area' => fake()->numberBetween(30, 400),
        ];
    }
}
