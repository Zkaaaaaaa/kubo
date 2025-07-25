<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'product_id' => fake()->numberBetween(1, 100),
            'note' => fake()->name(),
            'quantity' => fake()->numberBetween(1, 100),
            'total' => fake()->randomFloat(2, 10, 1000),
            'table' => fake()->numberBetween(1, 100),
            'status' => fake()->randomElement(['cart', 'process', 'done']),
            'user_id' => fake()->numberBetween(1, 3),
            'token' => fake()->text(10),
        ];
    }
}
