<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'type' => fake()->randomElement(['keras', 'biasa']),
            'price' => fake()->randomNumber(5),
            'stock' => fake()->randomNumber(2),
            'description' => fake()->text(),
            'pharmacist_id' => fake()->numberBetween(7, 8),
            // 'image' => fake()->image('public/storage/images', 640, 480, null, false),
        ];
    }
}
