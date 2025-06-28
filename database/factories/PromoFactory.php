<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'photo_1' => "nasi_goreng_1.jpeg",
            'photo_2' => "nasi_goreng_2.jpeg",
            'photo_3' => "mie_goreng_1.jpeg",
        ];
    }
}
