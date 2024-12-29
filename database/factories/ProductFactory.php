<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => fake()->numberBetween(1, 5),
            'name' => fake()->firstName(),
            'price' => fake()->randomFloat(2,10,1000),
            'description' => fake()->text(200),
            'photo' => "https://via.placeholder.com/150x100",

        ];
    }
}
