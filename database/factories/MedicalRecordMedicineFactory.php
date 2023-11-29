<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecordMedicine>
 */
class MedicalRecordMedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medical_record_id' => fake()->numberBetween(1, 3),
            'medicine_id' => fake()->numberBetween(1, 3),
            'amount' => fake()->numberBetween(1, 3),
        ];
    }
}
