<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'theme' => fake()->randomElement(['Ударения', '“Ъ” или “Ь”', 'Приставки ', 'Корни', 'Суффиксы и окончания', '“Н” или “НН”', 'Числительные']),
            'question' => fake()->sentence(3),
            'answers' => '[{"Верный":true,"Неверный":false}]',
        ];
    }
}
